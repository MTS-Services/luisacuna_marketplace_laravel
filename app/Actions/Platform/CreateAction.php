<?php 
namespace App\Actions\Platform;

use App\Models\Platform;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAction {
    public function __construct(protected GamePlatformRepositoryInterface $interface) {}
     public function execute(array $data): Platform
    {
        return DB::transaction(function () use ($data) {

            if(! isset($data['slug'])){

                $data['slug'] = Str::slug($data['name']);
                
            }

            if(isset($data['icon'])) {
                
                $data['icon'] = Storage::disk('public')->putFile('icons', $data['icon']);

            }

            $newData = $this->interface->create($data);
            
            return $newData->fresh();
        });
    }
}