<?php

namespace App\Actions\Game;

use App\DTOs\Game\CreateGameDTO;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateGameAction
{

  public function __construct(protected GameRepositoryInterface $gameRepository) {}

  public function execute(CreateGameDTO $dto):Game
  {


   return  DB::transaction(function () use ($dto) {

      $data = $dto->toArray();

      if ($dto->logo) {
        
        $logo_name = $data['slug'] . '-logo-' . time() . '.' . $dto->logo->getClientOriginalExtension();

        $data['logo']  = $dto->logo->storeAs('logos', $logo_name, 'public');
      }

      if ($dto->banner) {
        $banner_name = $data['slug'] . '-banner-' . time() . '.' . $dto->logo->getClientOriginalExtension();

        $data['banner']  = $dto->logo->storeAs('banners', $banner_name, 'public');
      }

      if ($dto->thumbnail) {
        $thumbnail_name = $data['slug'] . '-thumbnail-' . time() . '.' . $dto->logo->getClientOriginalExtension();

        $data['thumbnail']  = $dto->logo->storeAs('thumbnails', $thumbnail_name, 'public');
      }
      

      return $this->gameRepository->createGame($data);

    });
  }
}
