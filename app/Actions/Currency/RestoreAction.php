<?php

namespace App\Actions\Currency;


use App\Repositories\Contracts\CurrencyRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
    public function __construct(
        protected CurrencyRepositoryInterface $interface
    ) {}

    public function execute(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            return $this->interface->restore($id);
        });
    }
}
