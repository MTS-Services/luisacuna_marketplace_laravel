<?php 

namespace App\Services;

use App\Models\SellerProfile;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerProfileService{

    public function __construct(protected SellerProfile $model){
        
    }


    public function all(string $sortField = 'created_at', $order = 'desc'): Collection
    {

        $query = $this->model->query();

        return $query->orderBy($sortField, $order)->get();
    }

    public function findData($column_value, string $column_name = 'id', bool $trashed = false): ?SellerProfile
    {
        $model = $this->model;
        if ($trashed) {
            $model = $model->withTrashed();
        }
        return $model->where($column_name, $column_value)->first();
    }



    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */



    public function createData(array $data): SellerProfile
    {
       return DB::transaction(function () use ($data) {
            $categories = [];

            if (isset($data['identification'])) {

                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . basename($data['identification']);

                if (Storage::exists($data['identification'])) {

                    $fileName = uniqid('IMX') . '-' . time() . '-' . basename($data['identification']);

                    $finalPath = Storage::disk('public')->putFileAs(
                        'seller_kyc',
                        new \Illuminate\Http\File(storage_path('app/private/' . $data['identification'])),
                        $fileName
                    );
                   Storage::delete($data['identification']);

                    $data['identification'] = $finalPath;
                }
            }

            if (isset($data['selfie_image'])) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['selfie_image']->getClientOriginalName();
                $data['selfie_image'] = Storage::disk('public')->putFileAs('seller_profiles', $data['selfie_image'], $fileName);
            }
            if (isset($data['company_documents'])) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['company_documents']->getClientOriginalName();
                $data['company_documents'] = Storage::disk('public')->putFileAs('seller_profiles', $data['selfie_image'], $fileName);
            }

            if ($data['categories']) {
                $categories = $data['categories'];
                unset($data['categories']);
            }
            if (!isset($data['user_id'])) {
                $data['user_id'] = user()->id;
            }

            // dd($data); 
            $seller_profile = $this->model->create($data);

            $seller_profile->categories()->sync($categories);

            return $seller_profile->fresh();
        });
    }


}