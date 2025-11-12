<?php

namespace App\Actions\Game;


use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAction
{

  public function __construct(protected GameRepositoryInterface $interface) {}

  public function execute(array $data): Game
  {


    return  DB::transaction(function () use ($data) {



      if (! isset($data['slug'])) {
        $data['slug'] = Str::slug($data['name']);
      }

      if (isset($data['logo'])) {
        $data['logo']  = Storage::disk('public')->putFile('logo', $data['logo']);
      }


      if (isset($data['banner'])) {
        $data['banner']  = Storage::disk('public')->putFile('banners', $data['banner']);
      }


      if ( isset($data['thumbnail'])) {
        $data['thumbnail']  = Storage::disk('public')->putFile('thumbnails', $data['thumbnail']);
      }

      return $this->interface->create($data);
    });
  }
}
