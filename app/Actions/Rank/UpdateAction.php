<?php 

namespace App\Actions\Rank;

use App\Repositories\Contracts\RankRepositoryInterface;

class UpdateAction{

    public function __construct(protected RankRepositoryInterface $interface){}
    
}