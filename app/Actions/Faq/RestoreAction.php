<?php

namespace App\Actions\Faq;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\FaqRepositoryInterface;

class RestoreAction{

    public function __construct(protected FaqRepositoryInterface $interface){}



    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}
