<?php

namespace App\Rules;

use Closure;
use App\Models\Rank;
use Illuminate\Contracts\Validation\ValidationRule;
 
class PointRange implements ValidationRule
{
    /**
     * Create a new rule instance.
     *
     * @param int $min The minimum value of the range
     * @param int $max The maximum value of the range
     * @param int|null $ignoreId The ID to ignore during validation (for updates)
     */
    public function __construct(
        protected int $min,
        protected int $max,
        protected ?int $ignoreId = null
    ) {}
 
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure $fail
     * @return void
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Validate that min is not greater than max
        if ($this->min > $this->max) {
            $fail($this->getInvalidRangeMessage());
            return;
        }
 
        // Check for overlapping ranges with optimized single query
        $overlappingRank = $this->findOverlappingRank();
 
        if ($overlappingRank) {
            $fail($this->getOverlapMessage($overlappingRank));
        }
    }
 
    /**
     * Find the first overlapping rank using an optimized query.
     *
     * @return \App\Models\Rank|null
     */
    protected function findOverlappingRank(): ?Rank
    {
        return Rank::query()
            ->select(['id', 'name', 'minimum_points', 'maximum_points'])
            ->where(function ($query) {
                // Case 1: New range starts within an existing range
                $query->where(function ($q) {
                    $q->where('minimum_points', '<=', $this->min)
                      ->where('maximum_points', '>=', $this->min);
                })
                // Case 2: New range ends within an existing range
                ->orWhere(function ($q) {
                    $q->where('minimum_points', '<=', $this->max)
                      ->where('maximum_points', '>=', $this->max);
                })
                // Case 3: New range completely contains an existing range
                ->orWhere(function ($q) {
                    $q->where('minimum_points', '>=', $this->min)
                      ->where('maximum_points', '<=', $this->max);
                })
                // Case 4: Existing range completely contains the new range
                ->orWhere(function ($q) {
                    $q->where('minimum_points', '<=', $this->min)
                      ->where('maximum_points', '>=', $this->max);
                });
            })
            ->when($this->ignoreId, fn($query) => $query->where('id', '!=', $this->ignoreId))
            ->first();
    }
 
    /**
     * Get the error message for invalid range (min > max).
     *
     * @return string
     */
    protected function getInvalidRangeMessage(): string
    {
        return sprintf(
            'The minimum points (%s) cannot be greater than the maximum points (%s).',
            number_format($this->min),
            number_format($this->max)
        );
    }
 
    /**
     * Get a detailed overlap error message.
     *
     * @param \App\Models\Rank $rank
     * @return string
     */
    protected function getOverlapMessage(Rank $rank): string
    {
        $existingRange = sprintf(
            '%s-%s',
            number_format($rank->minimum_points),
            number_format($rank->maximum_points)
        );
 
        $newRange = sprintf(
            '%s-%s',
            number_format($this->min),
            number_format($this->max)
        );
 
        // Determine the type of overlap
        if ($this->min >= $rank->minimum_points && $this->min <= $rank->maximum_points) {
            return sprintf(
                'The minimum points %s conflicts with the existing "%s" rank (range: %s).',
                number_format($this->min),
                $rank->name,
                $existingRange
            );
        }
 
        if ($this->max >= $rank->minimum_points && $this->max <= $rank->maximum_points) {
            return sprintf(
                'The maximum points %s conflicts with the existing "%s" rank (range: %s).',
                number_format($this->max),
                $rank->name,
                $existingRange
            );
        }
 
        if ($this->min <= $rank->minimum_points && $this->max >= $rank->maximum_points) {
            return sprintf(
                'The range %s completely overlaps the existing "%s" rank (range: %s).',
                $newRange,
                $rank->name,
                $existingRange
            );
        }
 
        return sprintf(
            'The range %s overlaps with the existing "%s" rank (range: %s).',
            $newRange,
            $rank->name,
            $existingRange
        );
    }
}