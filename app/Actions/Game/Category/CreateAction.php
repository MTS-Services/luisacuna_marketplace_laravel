<?php 

namespace App\Actions\Game\Category;

use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
class CreateAction{

    public function __construct(protected GameCategoryRepositoryInterface $interface){}
    public function execute(array $data){
      
        return DB::transaction(function () use ($data) {

            if(! isset($data['creater_id'])){
                $data['creater_id'] = admin()->id;
            }
            if(! isset($data['slug'])){
                $data['slug'] = Str::slug($data['name']);
            }

   
            return $this->interface->create($data);

        });
    }
}