<?php

namespace App\Actions\Game;

use App\DTOs\Game\CreateGameDTO;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateAction
{

  public function __construct(protected GameRepositoryInterface $gameRepository) {}

  public function execute(CreateGameDTO $dto):Game
  {


   return  DB::transaction(function () use ($dto) {

      $data = $dto->toArray();

      if ($dto->logo) {

        $logo_name = $data['slug'] . '-logo-' . time() . '.' . $dto->logo->getClientOriginalExtension();

        $data['logo']  = $dto->logo->storeAs('logo', $logo_name, 'public');
      }

      if ($dto->banner) {

        $banner_name = $data['slug'] . '-banner-' . time() . '.' . $dto->banner->getClientOriginalExtension();

        $data['banner']  = $dto->banner->storeAs('banners', $banner_name, 'public');
      }

      if ($dto->thumbnail) {

        $thumbnail_name = $data['slug'] . '-thumbnail-' . time() . '.' . $dto->thumbnail->getClientOriginalExtension();

        $data['thumbnail']  = $dto->thumbnail->storeAs('thumbnails', $thumbnail_name, 'public');
      }
      
    
      return $this->gameRepository->createGame($data);

    });
  }
}
