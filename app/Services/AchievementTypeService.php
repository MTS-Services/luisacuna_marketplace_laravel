<?php

namespace App\Services;

use App\Models\AchievementType;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;

class AchievementTypeService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementTypeRepositoryInterface $interface,
    ) {}


    /* ================== ================== ==================
    *                          Find Methods
    * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        return $this->interface->all($sortField, $order);
    }

    public function findData($column_value, string $column_name = 'id'): ?AchievementType
    {
        return $this->interface->find($column_value, $column_name);
    }
}
