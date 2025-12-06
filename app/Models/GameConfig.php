<?php

namespace App\Models;

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class GameConfig extends BaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        "sort_order",
        "delivery_methods",
        "game_id",
        "category_id",
        "game_category_id",
        "field_name",
        "slug",
        "filter_type",
        "input_type",
        "dropdown_values",
    ];

    protected $hidden = [];

    protected $casts = [
        'sort_order' => 'integer',
        'game_id' => 'integer',
        'category_id' => 'integer',
        'game_category_id' => 'integer',
        'delivery_methods' => 'array',
        'dropdown_values' => 'array',
        'filter_type' => GameConfigFilterType::class,
        'input_type' => GameConfigInputType::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function gameCategory()
    {
        return $this->belongsTo(GameCategory::class);
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
               End of RELATIONSHIPS
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of SCOPES
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function scopeForGame($query, int $gameId)
    {
        return $query->where('game_id', $gameId);
    }

    public function scopeForCategory($query, int $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeForGameCategory($query, int $gameCategoryId)
    {
        return $query->where('game_category_id', $gameCategoryId);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
               End of SCOPES
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of ACCESSORS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    /**
     * Get formatted dropdown values as comma-separated string
     */
    public function getDropdownValuesStringAttribute(): string
    {
        return is_array($this->dropdown_values)
            ? implode(', ', $this->dropdown_values)
            : '';
    }

    /**
     * Get formatted delivery methods as comma-separated string
     */
    public function getDeliveryMethodsStringAttribute(): string
    {
        if (!is_array($this->delivery_methods)) {
            return '';
        }

        $methods = delivery_methods();
        return collect($this->delivery_methods)
            ->map(fn($key) => $methods[$key] ?? $key)
            ->join(', ');
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
               End of ACCESSORS
    =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'dropdown_values_string',
            'delivery_methods_string',
        ]);
    }
}
