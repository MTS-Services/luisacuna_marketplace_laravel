<?php

namespace App\Actions\OfferItem;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\OfferItemRepositoryInterface;

class RestoreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OfferItemRepositoryInterface $interface
    )
    {}

    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
