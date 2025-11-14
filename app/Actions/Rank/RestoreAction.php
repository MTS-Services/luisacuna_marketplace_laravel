<?php 

namespace App\Actions\Rank;

use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\RankRepositoryInterface;

class RestoreAction{

    public function __construct(protected RankRepositoryInterface $interface){}
    


    public function execute(int $id, ?int $actionerId): bool
    {
        return DB::transaction(function () use ($id, $actionerId) {
            return $this->interface->restore($id, $actionerId);
        });
    }
}