<?php

namespace App\Actions\Game\Category;

use Illuminate\Support\Str;
use App\Models\GameCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;

class UpdateAction
{

    public function __construct(protected GameCategoryRepositoryInterface $interface) {}
    public function execute(?int $id, array $data, ?int $actionerId)
    {

        return DB::transaction(function () use ($id, $data, $actionerId): GameCategory {


            return DB::transaction(function () use ($id, $data) {

                // Fetch gameacategory
                $gamecat = $this->interface->find($id);

                if (!$gamecat) {
                    Log::error('gameacategory not found', ['gameacategory_id' => $id]);
                    throw new \Exception('gameacategory not found');
                }

                $oldData = $gamecat->getAttributes();



                $icon = $data['icon'] ?? null;
                unset($data['icon']);




                // Update gameacategory
                $updated = $this->interface->update($id, $data);

                if (!$updated) {
                    Log::error('Failed to update gameacategory', ['gamecategory_id' => $id]);
                    throw new \Exception('Failed to update gameacategory');
                }


                if ($icon && is_object($icon)) {
                    $this->handleIcon($gamecat, $icon);
                }

                // Refresh model
                $gamecat = $gamecat->fresh();

                // Detect changes
                $changes = [];
                foreach ($gamecat->getAttributes() as $key => $value) {
                    if (isset($oldData[$key]) && $oldData[$key] != $value) {
                        $changes[$key] = [
                            'old' => $oldData[$key],
                            'new' => $value
                        ];
                    }
                }

                return $gamecat;
            });
        });
    }


    protected function handleIcon(GameCategory $gamecat, $icon): void
    {
        if ($gamecat->icon && Storage::disk('public')->exists($gamecat->icon)) {
            Storage::disk('public')->delete($gamecat->icon);
        }

        $filename = Str::slug($gamecat->slug) . '-' . time() . '.' . $icon->getClientOriginalExtension();

        $path = $icon->storeAs('game-categories/icons', $filename, 'public');

        $gamecat->update(['icon' => $path]);
    }
}
