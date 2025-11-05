<?php 

namespace App\Actions\Game\Category;

use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class UpdateAction{

    public function __construct(protected GameCategoryRepositoryInterface $interface){}
    public function execute(?int $id, array $data, ?int $actionerId){
      
        return DB::transaction(function () use ($id, $data, $actionerId) {

            $category = $this->interface->find($id);

            if (!$category) {
                throw new \Exception('Category not found');
            }

            if(! isset($data['updater_id'])){

                $data['updater_id'] = $actionerId ?? admin()->id;

            }

            if(! isset($data['slug'])){
                $data['slug'] = Str::slug($data['name']);
            }



            return $this->interface->update($id, $data);

        });
    }
}