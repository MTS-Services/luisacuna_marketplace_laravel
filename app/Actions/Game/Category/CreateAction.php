<?php

namespace App\Actions\Game\Category;

use App\Jobs\TranslateCategoryJob;
use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\Facades\Log;

class CreateAction
{

    public function __construct(protected CategoryRepositoryInterface $interface) {}
    public function execute(array $data): Category
    {
        return DB::transaction(function () use ($data) {

            // Handle icon upload
            if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('icons', $data['icon'], $fileName);
            }

            // Create category
            $newData = $this->interface->create($data);

            // Dispatch translation job in background
            // Assuming the source language is English (EN)
            Log::info('Dispatching TranslateCategoryJob for Category ID: ' . $newData->id);
            TranslateCategoryJob::dispatch($newData->fresh(), 'EN');

            return $newData->fresh();
        });
    }
}
