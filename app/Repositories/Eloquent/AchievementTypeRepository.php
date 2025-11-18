<?php

namespace App\Repositories\Eloquent;

use App\Models\AchievementType;
use Illuminate\Database\Eloquent\Collection;
use App\Repositories\Contracts\AchievementTypeRepositoryInterface;

class AchievementTypeRepository implements AchievementTypeRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected AchievementType $model
    ) {}



    /* ================== ================== ==================
    *                      Find Methods
    * ================== ================== ================== */
    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function find($column_value, string $column_name = 'id',  bool $trashed = false): ?AchievementType
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }
}
