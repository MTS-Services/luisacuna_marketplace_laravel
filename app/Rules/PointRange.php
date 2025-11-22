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

        // **NIYOM 1: Prothom rank 0 theke shuru hote hobe**
        $existingRanksCount = Rank::when($this->ignoreId, function ($query) {
            return $query->where('id', '!=', $this->ignoreId);
        })->count();

        if ($existingRanksCount === 0 && $this->min !== 0) {
            $fail('The first rank must start from 0 points.');
            return;
        }

        // **NIYOM 2: Porer rank ager rank er maximum + 1 theke shuru hobe**
        if ($existingRanksCount > 0) {
            $previousRank = Rank::when($this->ignoreId, function ($query) {
                return $query->where('id', '!=', $this->ignoreId);
            })
            ->where('maximum_points', '<', $this->min)
            ->orderBy('maximum_points', 'desc')
            ->first();

            if ($previousRank) {
                $expectedMin = $previousRank->maximum_points + 1;
                
                if ($this->min !== $expectedMin) {
                    $fail(sprintf(
                        'The minimum points must be exactly %s (one point after the previous rank "%s" which ends at %s). Current minimum is %s.',
                        number_format($expectedMin),
                        $previousRank->name,
                        number_format($previousRank->maximum_points),
                        number_format($this->min)
                    ));
                    return;
                }
            } elseif ($this->min !== 0) {
                // Jodi kono previous rank na thake tahole 0 theke start hobe
                $fail('No previous rank found. The rank must start from 0 points.');
                return;
            }
        }

        // **NIYOM 3: Porer rank check - kono gap thakbe na**
        $nextRank = Rank::when($this->ignoreId, function ($query) {
            return $query->where('id', '!=', $this->ignoreId);
        })
        ->where('minimum_points', '>', $this->max)
        ->orderBy('minimum_points', 'asc')
        ->first();

        if ($nextRank) {
            $expectedNextMin = $this->max + 1;
            
            if ($nextRank->minimum_points !== $expectedNextMin) {
                $fail(sprintf(
                    'The maximum points must be exactly %s (one point before the next rank "%s" which starts at %s). Setting maximum to %s would create a gap.',
                    number_format($nextRank->minimum_points - 1),
                    $nextRank->name,
                    number_format($nextRank->minimum_points),
                    number_format($this->max)
                ));
                return;
            }
        }
 
        // Existing overlap check (backup safety check)
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