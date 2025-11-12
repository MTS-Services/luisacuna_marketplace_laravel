<?php 

namespace App\Actions\Rank;

use App\Repositories\Contracts\RankRepositoryInterface;

class DeleteAction{

    public function __construct(protected RankRepositoryInterface $interface){}
    
}