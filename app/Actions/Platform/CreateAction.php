<?php 
namespace App\Actions\Platform;

use App\Events\Platform\PlatformCreated;
use App\Models\Platform;
use App\Repositories\Contracts\PlatformRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CreateAction {
    public function __construct(protected PlatformRepositoryInterface $interface) {}
     public function execute(array $data): Platform
    {
        return DB::transaction(function () use ($data) {

           if ($data['icon']) {
                $prefix = uniqid('IMX') . '-' . time() . '-' . uniqid();
                $fileName = $prefix . '-' . $data['icon']->getClientOriginalName();
                $data['icon'] = Storage::disk('public')->putFileAs('admins', $data['icon'], $fileName);
            }

            $newData = $this->interface->create($data);
            
            event(new PlatformCreated($newData));

            return $newData->fresh();
        });
    }
}