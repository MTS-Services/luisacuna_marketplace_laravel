<?php

namespace App\Actions\Game\Category;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DeleteAction
{
    public function __construct(
        protected CategoryRepositoryInterface $interface
    ) {}

    public function execute($id, $forceDelete = false, ?int $actionerId = null, bool $cascade = false)
    {
        return DB::transaction(function () use ($id, $forceDelete, $actionerId, $cascade) {
            $findData = null;

            if ($forceDelete) {
                $findData = $this->interface->findData($id, 'id', false, false, true);
            } else {
                $findData = $this->interface->findData($id, 'id', false, false, false);
            }

            if (!$findData) {
                throw new \Exception('Data not found');
            }
            // If related data exists and cascade not requested, prevent deletion
            if ($findData->hasRelatedData() && !$cascade) {
                throw new \Exception('Cannot delete this category. It has associated data in the system.');
            }

            // If cascade requested, delete related games and associated relations first
            if ($cascade) {
                $games = $findData->games()->get();
                foreach ($games as $game) {
                    // delete dependent relations for game
                    if (method_exists($game, 'products')) {
                        $game->products()->delete();
                    }
                    if (method_exists($game, 'gameConfig')) {
                        $game->gameConfig()->delete();
                    }
                    // detach pivot relations
                    if (method_exists($game, 'categories')) {
                        $game->categories()->detach();
                    }
                    if (method_exists($game, 'platforms')) {
                        $game->platforms()->detach();
                    }
                    if (method_exists($game, 'tags')) {
                        $game->tags()->detach();
                    }

                    // finally delete the game (soft delete)
                    $game->delete();
                }

                // delete other category-related data
                if (method_exists($findData, 'gameCategories')) {
                    $findData->gameCategories()->delete();
                }
                if (method_exists($findData, 'achievements')) {
                    $findData->achievements()->delete();
                }
                if (method_exists($findData, 'products')) {
                    $findData->products()->delete();
                }
            }
            if ($forceDelete) {
                if ($findData->icon && Storage::disk('public')->exists($findData->icon)) {

                    Storage::disk('public')->delete($findData->icon);
                }

                return $this->interface->forceDelete($id);
            }
            return $this->interface->delete($id, $actionerId);
        });
    }
}
