<?php

namespace App\Actions\Game\Category;

use Illuminate\Support\Str;
use App\Models\GameCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;

class CreateAction
{

    public function __construct(protected GameCategoryRepositoryInterface $interface) {}
    public function execute(array $data): GameCategory
    {

        return DB::transaction(function () use ($data) {

            $icon = $data['icon'] ?? null;
            unset($data['icon']);


            $gamecat = $this->interface->create($data);

            if ($icon && is_object($icon)) {
                $this->handleIcon($gamecat, $icon);
            }
            return $gamecat->fresh();
        });
    }

    protected function handleIcon(GameCategory $gamecat, $icon): void
    {
        if ($gamecat->icon && Storage::disk('public')->exists($gamecat->icon)) {
            Storage::disk('public')->delete($gamecat->icon);
        }

        // Generate unique filename
        $filename = Str::slug($gamecat->slug) . '-' . time() . '.' . $icon->getClientOriginalExtension();

        // Store with custom filename
        $path = $icon->storeAs('game-categories/icons', $filename, 'public');

        // Update the model with new icon path
        $gamecat->update(['icon' => $path]);
    }
}
