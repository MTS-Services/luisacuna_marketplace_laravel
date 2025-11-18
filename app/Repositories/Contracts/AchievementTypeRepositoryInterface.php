<?php

namespace App\Repositories\Contracts;

use App\Models\AchievementType;
use Illuminate\Database\Eloquent\Collection;

interface AchievementTypeRepositoryInterface
{
    /* ================== ================== ==================
    *                      Find Methods
    * ================== ================== ================== */

    public function all(string $sortField = 'created_at', $order = 'desc'): Collection;

    public function find($column_value, string $column_name = 'id', bool $trashed = false): ?AchievementType;
}
