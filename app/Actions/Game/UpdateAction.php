<?php 

namespace App\Actions\Game;

use App\DTOs\Game\UpdateGameDTO;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UpdateAction {
    public function __construct(protected GameRepositoryInterface $gameRepository)
    {
    }

    public function execute($id , array $data): ?bool
    {

      return  DB::transaction(function () use($id, $data){
         

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