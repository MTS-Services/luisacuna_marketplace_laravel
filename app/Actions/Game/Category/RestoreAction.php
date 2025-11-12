<?php

namespace App\Actions\Game\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(
        protected CategoryRepositoryInterface $interface
    ) {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
