<?php

namespace App\Actions\Game;

use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateGameAction {

    public function __construct( protected GameRepositoryInterface $gameRepository)
    {
        
    }

    public function execute( $data)
    {
      DB::transaction(function () use($data){
        
       
      });
    }
}