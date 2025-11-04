<?php

namespace App\Actions\Game;

use App\DTOs\Game\UpdateGameDTO;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class UpdateAction
{
    public function __construct(protected GameRepositoryInterface $interface) {}

    public function execute($id, array $data, int $actioner_id): ?bool
    {

        return  DB::transaction(function () use ($id, $data, $actioner_id) {

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

            $old_data = $this->interface->find($id)->getAttributes();

            if (! isset($data['slug'])) {

                $new_data['slug'] = Str::slug($data['name']);
            }

            if ($data['logo']) {

                $new_data['logo']  = Storage::disk('public')->putFile('logos', $data['logo']);

                $old = $old_data['logo'];
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }


            if ($data['banner']) {
                $new_data['banner']  = Storage::disk('public')->putFile('banners', $data['banner']);
                $old = $old_data['banner'];
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }


            if ($data['thumbnail']) {
                
                $new_data['thumbnail']  = Storage::disk('public')->putFile('thumbnails', $data['thumbnail']);

                $old = $old_data['thumbnail'];
                
                if ($old && Storage::disk('public')->exists($old)) {
                    Storage::disk('public')->delete($old);
                }
            }
        
            return $this->interface->update($id, $new_data);

        });
    }
}
