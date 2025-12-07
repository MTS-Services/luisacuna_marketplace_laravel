<?php

namespace App\Models;

use App\Enums\GameConfigFilterType;
use App\Enums\GameConfigInputType;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use OwenIt\Auditing\Contracts\Auditable;
use App\Traits\AuditableTrait;

class GameConfig extends BaseModel implements Auditable
{
    use AuditableTrait;

    protected $fillable = [
        'sort_order',
        'delivery_methods',
        'game_id',
        'category_id',
        'game_category_id',
        'field_name',
        'slug',
        'filter_type',
        'input_type',
        'dropdown_values',
    ];

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

    /* ═══════════════════════════════════════════════════════════════
                            RELATIONSHIPS
       ═══════════════════════════════════════════════════════════════ */

    public function gameCategory(): BelongsTo
    {
        return $this->belongsTo(GameCategory::class);
    }

    public function game(): BelongsTo
    {
        return $this->belongsTo(Game::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function product_configs()
    {
        return $this->hasOne(ProductConfig::class, 'game_config_id', 'id');
    }
    /* ═══════════════════════════════════════════════════════════════
                                SCOPES
       ═══════════════════════════════════════════════════════════════ */

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

    public function scopeDeliveryMethodsOnly($query)
    {
        return $query->where('sort_order', 0)->whereNull('field_name');
    }

    public function scopeFieldsOnly($query)
    {
        return $query->where('sort_order', '>', 0)->whereNotNull('field_name');
    }

    /* ═══════════════════════════════════════════════════════════════
                              ACCESSORS
       ═══════════════════════════════════════════════════════════════ */

    /**
     * Get formatted dropdown values as comma-separated string
     */
    protected function dropdownValuesString(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn() => is_array($this->dropdown_values)
                ? implode(', ', $this->dropdown_values)
                : ''
        );
    }

    /**
     * Get formatted delivery methods as comma-separated string
     */
    protected function deliveryMethodsString(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if (!is_array($this->delivery_methods)) {
                    return '';
                }

                $methods = delivery_methods();
                return collect($this->delivery_methods)
                    ->map(fn($key) => $methods[$key] ?? $key)
                    ->join(', ');
            }
        );
    }

    /* ═══════════════════════════════════════════════════════════════
                            HELPER METHODS
       ═══════════════════════════════════════════════════════════════ */

    /**
     * Check if this config is for delivery methods
     */
    public function isDeliveryMethodsConfig(): bool
    {
        return $this->sort_order === 0 && empty($this->field_name);
    }

    /**
     * Check if this config is a field
     */
    public function isFieldConfig(): bool
    {
        return $this->sort_order > 0 && !empty($this->field_name);
    }

    /**
     * Check if field requires dropdown values
     */
    public function requiresDropdownValues(): bool
    {
        return $this->input_type === GameConfigInputType::SELECT_DROPDOWN;
    }
}
