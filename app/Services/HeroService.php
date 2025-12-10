<?php

namespace App\Services;

use App\Models\Hero;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HeroService
{
    public function __construct(protected Hero $model) {}


    /* ================== ================== ==================
    *                          Find Methods
    * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc'): Collection
    {
        $query = $this->model->query();
        return $query->orderBy($sortField, $order)->get();
    }

    public function findData($column_value, string $column_name = 'id',  bool $trashed = false): ?Hero
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function getFristData(array $filters = [], $sortField = 'created_at', $order = 'desc'): ?Hero
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->orderBy($sortField, $order)->first();
    }

    public function getFirstActiveData(array $filters = [], $sortField = 'created_at', $order = 'desc') :?Hero
    {
        $query = $this->model->query();

        if (!empty($filters)) {
            $query->filter($filters);
        }

        return $query->active()->orderBy($sortField, $order)->first();
    }

    public function getPaginatedData(int $perPage =  15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            // Scout Search
            return Hero::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }

    /* ================== ================== ==================
    *                   Action Executions
    * ================== ================== ================== */

    public function updateData(int $id, array $data): ?Hero
    {
        return DB::transaction(function () use ($id, $data) {
            $model = $this->findData($id);
            $newSingleImagePath = null;
            $newSingleImagePathMobile = null;
            if (!$model) {
                return null;
            }

            
                $oldData = $model->getAttributes();
                $newData = $data;

                // --- 1. Single Avatar Handling ---
                $oldImagePath = Arr::get($oldData, 'image');
                $uploadedImage = Arr::get($data, 'image');


                
                if ($uploadedImage instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if (!empty($oldImagePath) && Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                    // Store the new file and track path for rollback
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedImage->getClientOriginalName();

                    $newSingleImagePath = Storage::disk('public')->putFileAs('banners', $uploadedImage, $fileName);
                    $newData['image'] = $newSingleImagePath;
                } elseif ($newData['remove_file']) {
                    if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
                        Storage::disk('public')->delete($oldImagePath);
                    }
                    $newData['image'] = null;
                }
                
                // Cleanup temporary/file object keys
                if (!$newData['remove_file'] && !$newSingleImagePath) {
                    $newData['image'] = $oldImagePath ?? null;
                }
                unset($newData['remove_file']);


                //Mobile Image
                $oldImagePathMobile = Arr::get($oldData, 'mobile_image');
                $uploadedImageMobile = Arr::get($data, 'mobile_image');
                
     
                if ($uploadedImageMobile instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                   if (!empty($oldImagePathMobile) && Storage::disk('public')->exists($oldImagePathMobile)) {
                        Storage::disk('public')->delete($oldImagePathMobile);
                    }
                    // Store the new file and track path for rollback
                    $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                    $fileName = $prefix . '-' . $uploadedImageMobile->getClientOriginalName();

                    $newSingleImagePathMobile = Storage::disk('public')->putFileAs('banners', $uploadedImageMobile, $fileName);
                    $newData['mobile_image'] = $newSingleImagePathMobile;
                } elseif ($newData['remove_file_mobile']) {
                    if ($oldImagePath && Storage::disk('public')->exists($oldImagePathMobile)) {
                        Storage::disk('public')->delete($oldImagePathMobile);
                    }
                    $newData['mobile_image'] = null;
                }
                
                // Cleanup temporary/file object keys
                if (!$newData['remove_file_mobile'] && !$newSingleImagePathMobile) {
                    $newData['mobile_image'] = $oldImagePathMobile ?? null;
                }
                unset($newData['remove_file_mobile']);

            $model->update($newData);
            return $model->fresh();
        });
    }


    public function deleteData(int $id):bool
    {
    return  DB::transaction(function () use ($id) {
        $image_url = null ; $mobile_image_url = null;
        $model = $this->findData($id);
        if (!$model) {
            return false;
        }

        if ($model->image) {
            $image_url = $model->image;
           
        }
        if ($model->mobile_image) {
            $mobile_image_url = $model->mobile_image;
          
        }

        $deleted =  $model->delete();

        if($deleted){
            if (Storage::disk('public')->exists($image_url))  {
                Storage::disk('public')->delete($image_url);
            }
            if (Storage::disk('public')->exists($mobile_image_url))  {
                Storage::disk('public')->delete($mobile_image_url);
            }
        }
        return $deleted;
     });
    }

  
}
