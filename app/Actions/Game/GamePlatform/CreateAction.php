<?php 
namespace App\Actions\Game\GamePlatform;

use App\Models\GamePlatform;
use App\Repositories\Contracts\GamePlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAction {
    public function __construct(protected GamePlatformRepositoryInterface $interface) {}
     public function execute(array $data): GamePlatform
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