<?php

namespace App\Actions\Game;


use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Events\Game\GameCreated;

class CreateAction
{

  public function __construct(protected GameRepositoryInterface $interface) {}

  public function execute(array $data): Game
  {


    return  DB::transaction(function () use ($data) {

      if ($data['logo']) {
        $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
        $fileName = $prefix . '-' . $data['logo']->getClientOriginalName();
        $data['logo'] = Storage::disk('public')->putFileAs('game', $data['logo'], $fileName);
      }
      $newData =  $this->interface->create($data);
      event(new GameCreated($newData));

      return $newData->fresh();
    });
  }
}
