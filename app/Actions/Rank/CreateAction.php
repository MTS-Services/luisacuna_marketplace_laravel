<?php 

namespace App\Actions\Rank;

use App\Repositories\Contracts\RankRepositoryInterface;

class CreateAction{

    public function __construct(protected RankRepositoryInterface $interface){}
    
}