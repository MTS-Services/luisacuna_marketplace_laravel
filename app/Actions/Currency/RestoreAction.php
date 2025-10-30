<?php

namespace App\Actions\Currency;


use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
