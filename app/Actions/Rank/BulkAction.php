<?php 

namespace App\Actions\Rank;

use App\Repositories\Contracts\RankRepositoryInterface;

class BulkAction{

    public function __construct(protected RankRepositoryInterface $interface){}
    
}