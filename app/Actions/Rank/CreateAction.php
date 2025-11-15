<?php 

namespace App\Actions\Rank;

use App\Models\Rank;
use Illuminate\Support\Facades\DB;
use App\Repositories\Contracts\RankRepositoryInterface;


class CreateAction{

    public function __construct(protected RankRepositoryInterface $interface){}


        public function execute(array $data): Rank
    {
        return DB::transaction(function () use ($data) {

            $newData = $this->interface->create($data);
            return $newData->fresh();
        });
    }
    
}