<?php

namespace App\Actions\Rarity;


use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repositories\Contracts\RankRepositoryInterface;

class UpdateAction
{

    public function __construct(protected RankRepositoryInterface $interface) {}


    public function execute()
    {
        //
    }
}
