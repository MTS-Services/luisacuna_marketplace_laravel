<?php 

namespace App\Actions\Game;

use App\DTOs\Game\UpdateGameDTO;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateAction {
    public function __construct(protected GameRepositoryInterface $interface)
    {
    }

    public function execute($id , array $data , int $actioner_id): ?bool
    {

      return  DB::transaction(function () use($id, $data, $actioner_id){
         
        $new_data = [
            'name' => $data['name'],
            'status' => $data['status'],
            'developer' => $data['developer'],
            'publisher' => $data['publisher'],
            'release_date' => $data['release_date'],
            'platform' => $data['platform'],
            'description' => $data['description'],
            'is_featured' => $data['is_featured'],
            'is_trending' => $data['is_trending'],
            'meta_title' => $data['meta_title'],
            'meta_description' => $data['meta_description'],
            'meta_keywords' => $data['meta_keywords'],
            'updater_id' => $actioner_id,
            'game_category_id' => $data['game_category_id'],

        ];

              
      if(! isset($data['slug'])){
        $new_data['slug'] = Str::slug($data['name']);
      } 

      if ($data['logo']) {
        $new_data['logo']  = Storage::disk('public')->putFile('logos', $data['logo']);
      }
      

      if ($data['banner']) {
        $new_data['banner']  = Storage::disk('public')->putFile('banners', $data['banner']);
      }
      

      if ($data['thumbnail']) {
        $new_data['thumbnail']  = Storage::disk('public')->putFile('thumbnails', $data['thumbnail']);
      }

        dd($dto);
            $game = $this->gameRepository->find($id); 

            if (!$game) {

                Log::error('Game not found with this id '.$id);
                
                throw new \Exception('Admin not found');
            }
            $old_data = $game->getAttributes();

            Log::info('Game found', [
                'game_id' => $id,
                'game_data' => $game->toArray()
            ]);

            $data = $dto->toArray();

            Log::info('UpdateGameDTO data', [
                'dto_data' => $data
            ]);

            //Handle Logo if found

            if ($dto->logo) {

                Log::info('Processing logo upload');

                $logo_name = $data['slug'] . '-logo-' . time() . '.' . $dto->logo->getClientOriginalExtension();   

                Log::info('Logo name', [
                    'logo_name' => $logo_name
                ]);

                $data['logo']  = $dto->logo->storeAs('logo', $logo_name, 'public');

                Log::info('Logo uploaded');

                Log::info('Deleting old logo', [
                    'old_logo' => $game->logo
                ]);

                Storage::disk('public')->delete($game->logo);

            }

            //Handle Banner if found

            if ($dto->banner) {
                Log::info('Banner Changed');
                $banner_name = $data['slug'] . '-banner-' . time() . '.' . $dto->banner->getClientOriginalExtension();  

                $data['banner']  = $dto->banner->storeAs('banners', $banner_name, 'public');

                Storage::disk('public')->delete($game->banner);

            }

            //Handle Thumbnail if found

            if ($dto->thumbnail) {

                Log::info('Thumbnail Changed');


                $thumbnail_name = $data['slug'] . '-thumbnail-' . time() . '.' . $dto->thumbnail->getClientOriginalExtension();

                $data['thumbnail']  = $dto->thumbnail->storeAs('thumbnails', $thumbnail_name, 'public');

                Storage::disk('public')->delete($game->thumbnail);

            }

      

           $game =  $this->gameRepository->updateGame($id, $data);

            Log::info('Game updated', [
                'game_id' => $id,
                'old_data' => $old_data,
                'new_data' => $dto->toArray()
            ]);

            return $game;

        });
    }
}