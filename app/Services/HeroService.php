<?php

namespace App\Services;

use App\Enums\HeroStatus;
use App\Models\Hero;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HeroService
{
    public function __construct(protected Hero $model, protected CloudinaryService $cloudinaryService) {}


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

    public function latestData($limit = 10 , $filters = []):Collection {
        
        return $this->model->query()->filter($filters)->limit($limit)->get();
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

    public function createData(array $data): ?Hero
    {  return DB::transaction(function () use ($data) {

            if ($data['image']) {
                $uploadedData =  $this->cloudinaryService->upload($data['image'], ['folder' => 'banners']);
                $data['image'] = $uploadedData->publicId;

            }
             if ($data['mobile_image']) {
                 $uploadedData =  $this->cloudinaryService->upload($data['mobile_image'], ['folder' => 'banners']);
                $data['mobile_image'] = $uploadedData->publicId;
            }
            $data['target'] = $data['target'] ?? '_self';
            $data['status'] = $data['status'] ?? HeroStatus::ACTIVE;
            
            $newData = $this->model->create($data);
            // Dispatch event

            $freshData =  $newData->fresh();

            if($freshData){
                Log::info('Hero Translations Created', ['hero_id' => $freshData->id, 'content' => $freshData->message]);

                $freshData->dispatchTranslation(
                    defaultLanguageLocale: app()->getLocale() ?? 'en',
                    forceTranslation: true,
                    targetLanguageIds: null
                );
            }
        });
        
    }
    public function updateData(int $id, array $data): ?Hero
    {
        return DB::transaction(function () use ($id, $data) {

            
            $hero = $this->findData($id);
            $newSingleImagePath = null;
            $newSingleImagePathMobile = null;
            if (!$hero) {
                return null;
            }

            
                $oldData = $hero->getAttributes();
                $newData = $data;

                $titleChanged = $oldData['title'] !== $newData['title'];
                $contentChanged = $oldData['content'] !== $newData['content'];
                // --- 1. Single Avatar Handling ---
                $oldImagePath = Arr::get($oldData, 'image');
                $uploadedImage = Arr::get($data, 'image');


                
                if ($uploadedImage instanceof UploadedFile) {
                    // Delete old file permanently (File deletion is non-reversible)
                    if (!empty($oldImagePath)) { 
                        $this->cloudinaryService->delete($oldImagePath);
                    }
                    $uploadedData =  $this->cloudinaryService->upload($uploadedImage, ['folder' => 'banners']);
                    $newSingleImagePath = $uploadedData->publicId;
                    $newData['image'] = $newSingleImagePath;

                } elseif ($newData['remove_file']) {
                    if ($oldImagePath) {
                        $this->cloudinaryService->delete($oldImagePath);
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
                    if (!empty($oldImagePathMobile)) { 
                        $this->cloudinaryService->delete($oldImagePathMobile);
                    }
                    $uploadedData =  $this->cloudinaryService->upload($uploadedImageMobile, ['folder' => 'banners']);
                    $newSingleImagePathMobile = $uploadedData->publicId;
                    $newData['mobile_image'] = $newSingleImagePathMobile;

                } elseif ($newData['remove_file_mobile']) {
                    if ($oldImagePath) {
                        $this->cloudinaryService->delete($oldImagePathMobile);
                    }
                    $newData['mobile_image'] = null;
                }
                
                // Cleanup temporary/file object keys
                if (!$newData['remove_file_mobile'] && !$newSingleImagePathMobile) {
                    $newData['mobile_image'] = $oldImagePathMobile ?? null;
                }
                
                unset($newData['remove_file_mobile']);

            $update = $hero->update($newData);
            
              if($update){

                if($titleChanged || $contentChanged){

                    $freshData = $hero->fresh();

                    Log::info('Hero Translations Created', ['hero_id' => $freshData->id, 'content' => $freshData->message]);

                $freshData->dispatchTranslation(
                    defaultLanguageLocale: app()->getLocale() ?? 'en',
                    forceTranslation: true,
                    targetLanguageIds: null
                );

                }
               
            }

            return $hero->fresh();
           
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
            if($image_url){
                $this->cloudinaryService->delete($image_url);
            }
            if($mobile_image_url){
                $this->cloudinaryService->delete($mobile_image_url);
            }
        }
        return $deleted;
     });
    }

  
}
