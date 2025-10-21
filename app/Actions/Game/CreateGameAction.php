<?php

namespace App\Actions\Game;

use App\DTOs\Game\CreateGameDTO;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateGameAction {

    public function __construct( protected GameRepositoryInterface $gameRepository)
    {
        
    }

    public function execute(CreateGameDTO $dto)
    {
      
      if($dto->logo) $dto->logo->store('logo', 'public');


      $dto = $dto->toArray();
      DB::transaction(function () use($dto){
        
        // if($data->logo) dd($data->logo);
       
        dd($dto);

      });
    }
}