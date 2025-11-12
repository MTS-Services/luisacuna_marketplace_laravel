<?php 

namespace App\Actions\Rank;

use App\Repositories\Contracts\RankRepositoryInterface;

class RestoreAction{

    public function __construct(protected RankRepositoryInterface $interface){}
    
}