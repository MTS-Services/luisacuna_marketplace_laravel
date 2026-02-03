<?php 

namespace App\Services;

use App\Models\SellerProfile;
use App\Services\Cloudinary\CloudinaryService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SellerProfileService{

    public function __construct(protected SellerProfile $model, protected CloudinaryService $cloudinaryService) {
        
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


      public function getPaginatedData(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        return $this->model->query()
            ->filter($filters)
            ->paginate($perPage);
    }
    /* ================== ================== ==================
     *                    Data Modification Methods
     * ================== ================== ================== */



    public function createData(array $data): SellerProfile
    {
       return DB::transaction(function () use ($data) {
            $categories = [];

        
            if (isset($data['selfie_image'])) {

                $uploadedFile = $this->cloudinaryService->upload($data['selfie_image'], ['folder' => 'seller_profiles']);

                $data['selfie_image'] = $uploadedFile->publicId;

            }
            if (isset($data['company_documents'])) {

                $uploadedFile = $this->cloudinaryService->upload($data['company_documents'], ['folder' => 'seller_profiles']);
                $data['company_documents'] = $uploadedFile->publicId;
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

    //Verify Data

    public function verifyData($id) : bool
    {
        return DB::transaction(function () use ($id) {
            $sellerProfile = $this->findData($id);

            if (!$sellerProfile) {
                throw new \Exception('Seller profile not found.');
            }

            return $sellerProfile->update([
                'seller_verified' => 1,
                'seller_verified_at' => now(),
            ]);
        });
    }
        public function unverifyData($id) : bool
    {
        return DB::transaction(function () use ($id) {

           
            $sellerProfile = $this->findData($id);

            if (!$sellerProfile) {
                throw new \Exception('Seller profile not found.');
            }

            return $sellerProfile->update([
                'seller_verified' => 0, 
            ]);

            
        });
    }

}