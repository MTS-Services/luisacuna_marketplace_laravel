<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;
use App\Models\Tag;
use App\Models\GameTag;

class GameTagSeeder extends Seeder
{
    public function run(): void
    {
        $primaryTagId = 1;

        $otherTagIds = Tag::where('id', '!=', 1)->pluck('id')->toArray();

        $games = Game::whereBetween('id', [1, 12])->get();

        foreach ($games as $game) {

            GameTag::updateOrCreate(
                [
                    'game_id' => $game->id,
                    'tag_id'  => $primaryTagId,
                ],
                []
            );

            if (!empty($otherTagIds)) {
                $randomTags = collect($otherTagIds)->random(rand(1, 2))->toArray();

                foreach ($randomTags as $tagId) {
                    GameTag::updateOrCreate(
                        [
                            'game_id' => $game->id,
                            'tag_id'  => $tagId,
                        ],
                        []
                    );
                }
            }
        }
    }
}
