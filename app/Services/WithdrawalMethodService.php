<?php

namespace App\Services;

use Illuminate\Support\Arr;
use App\Enums\WithdrawalFeeType;
use App\Models\WithdrawalMethod;
use App\Enums\ActiveInactiveEnum;
use Illuminate\Support\Facades\DB;
use App\Traits\FileManagementTrait;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use App\Services\Cloudinary\CloudinaryService;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class WithdrawalMethodService
{

use FileManagementTrait;

    public function __construct(
        protected WithdrawalMethod $model,
        protected CloudinaryService $cloudinaryService,
    ) {}


    /* ================== ================== ==================
     *                          Find Methods
     * ================== ================== ================== */

    public function getAllDatas($sortField = 'created_at', $order = 'desc', array $with = []): Collection
    {
        return $this->model
            ->query()
            ->with($with)
            ->orderBy($sortField, $order)
            ->get();
    }


    public function findData($column_value, string $column_name = 'id', bool $trashed = false): ?WithdrawalMethod
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }

    public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        if ($search) {
            return WithdrawalMethod::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        // Normal Eloquent Query
        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }




    // /* ================== ================== ==================
    // *                   Action Executions
    // * ================== ================== ================== */

    public function createData(array $data): ?WithdrawalMethod
    {
        return DB::transaction(function () use ($data) {

            // if ($data['icon']) {
            //     $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
            //     $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
            //     $data['icon'] = Storage::disk('public')->putFileAs('withdrawal-method-icons', $data['icon'], $fileName);
            // }
            if (isset($data['icon'])) {
                $uploaded = $this->cloudinaryService->upload($data['icon'], ['folder' => 'withdrawal-method-icons']);
                $data['icon'] = $uploaded->publicId;
            }
            $data['status'] = $data['status'] ?? ActiveInactiveEnum::ACTIVE;
            $data['fee_type'] = $data['fee_type'] ?? WithdrawalFeeType::FIXED;
            $data['required_fields'] = json_encode($data['required_fields']);


            $newData = $this->model->create($data);
            return $newData->fresh();
        });
    }

    public function updateData(int $id, array $data): ?WithdrawalMethod
    {
        return DB::transaction(function () use ($id, $data) {

            $model = $this->findData($id);
            if (!$model) {
                return null;
            }

            $data['status'] = $data['status'] ?? ActiveInactiveEnum::ACTIVE;
            $data['fee_type'] = $data['fee_type'] ?? WithdrawalFeeType::FIXED;
            $data['required_fields'] = json_encode($data['required_fields']);

            $newData = $data;


            $iconPath = $model->icon;
            if (isset($data['icon'])) {
                $uploaded = $this->cloudinaryService->upload($data['icon'], ['folder' => 'withdrawal-method-icons']);
                $iconPath = $this->handleSingleFileUpload(newFile: $data['icon'], oldPath: $model->icon, removeKey: $data['remove_icon'] ?? false, folderName: 'withdrawal-method-icons');
            }
            $newData['icon'] = $iconPath;
            // $oldImagePath = $model->icon;
            // $uploadedImage = Arr::get($data, 'icon');
            // $removeFile = Arr::get($data, 'remove_file', false);
            // $newSingleImagePath = null;

            // if ($uploadedImage instanceof UploadedFile) {

            //     if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            //         Storage::disk('public')->delete($oldImagePath);
            //     }

            //     $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
            //     $fileName = $prefix . '-' . $uploadedImage->getClientOriginalName();

            //     $newSingleImagePath = Storage::disk('public')
            //         ->putFileAs('withdrawal-method-icons', $uploadedImage, $fileName);

            //     $newData['icon'] = $newSingleImagePath;
            // } elseif ($removeFile) {

            //     if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            //         Storage::disk('public')->delete($oldImagePath);
            //     }

            //     $newData['icon'] = null;
            // } else {
            //     $newData['icon'] = $oldImagePath;
            // }


            unset($newData['remove_file']);

            $model->update($newData);

            return $model->fresh();
        });
    }


    public function deleteData(int $id): bool
    {
        return DB::transaction(function () use ($id) {
            $model = $this->findData($id);
            if (!$model) {
                return false;
            }
            $deleted = $model->delete();
            return $deleted;
        });
    }
}
