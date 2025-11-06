<?php 

namespace App\Actions\Game\Category;

use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class DeleteAction
{
    public function __construct(
        protected GameCategoryRepositoryInterface $interface
    ){}    

    public function execute($id, $forceDelete = false , ?int $actionerId = null)
    {
       return DB::transaction(function () use ($id, $forceDelete, $actionerId) {
            $category = null;

            if ($forceDelete) {
                $category = $this->interface->findTrashed($id);
            } else {
                $category = $this->interface->find($id);
            }

            if (!$category) {
                throw new \Exception('Category not found');
            }

            // Dispatch event before deletion
            //  event(new CategoryDeleted($category));

            if ($forceDelete) {
                return $this->interface->forceDelete($id);
            }
            
            return $this->interface->delete($id, $actionerId);
        });
    }

}