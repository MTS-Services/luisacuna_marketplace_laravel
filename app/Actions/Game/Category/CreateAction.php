<?php

namespace App\Actions\Game\Category;

use Illuminate\Support\Str;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Contracts\CategoryRepositoryInterface;

class CreateAction
{

    public function __construct(protected CategoryRepositoryInterface $interface) {}
    public function execute(array $data): Category
    {

        return DB::transaction(function () use ($data) {

            if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('icons', $data['icon'], $fileName);
            }

            $newData = $this->interface->create($data);

            return $newData->fresh();
        });
    }
}
