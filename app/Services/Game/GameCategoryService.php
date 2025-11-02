<?php 

namespace App\Services\Game;

use App\Actions\Admin\CreateGameCategoryAction;
use App\Actions\Game\Category\BulkAction;
use App\Actions\Game\Category\DeleteAction;
use App\Actions\Game\Category\RestoreAction;
use App\DTOs\Game\CreateGameCategoryDTO;
use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;

class GameCategoryService
{
    public function __construct(
        protected GameCategoryRepositoryInterface $interface,
        protected CreateGameCategoryAction $gameCategoryAction,
        protected BulkAction $bulkAction,
        protected DeleteAction $deleteAction,
        protected RestoreAction $restoreAction,
    )
    {
      
    }

    public function getAll()
    {
        return $this->interface->all();
    }

    public function findData(int $id){

        return $this->interface->find($id);

    }

    public function create(CreateGameCategoryDTO $dto): GameCategory
    {
        return $this->gameCategoryAction->execute($dto);
    }

    public function update( $id, array $dto):bool
    {
        return $this->interface->update($id, $dto);
    }

    public function deleteData($id, ?int $actioner_id = null):bool
    {
        if($actioner_id == null){

            $actioner_id = admin()->id;

        }
        return $this->deleteAction->execute($id,  false, $actioner_id);
    }

    public function forceDeleteData($id, $force_delete = true, ?int $actioner_id = null):bool
    {
        return $this->deleteAction->execute($id, $force_delete, $actioner_id);
    }

    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->interface->paginate($perPage, $filters, $queries ?? []);
    }

    public function paginateOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->interface->paginateOnlyTrashed($perPage, $filters, $queries ?? []);
    }   

    public function restoreData($id, ?int $actioner_id):bool
    {
        return $this->restoreAction->execute($id, $actioner_id);
    }

    public function bulkDeleteData(array $ids, int $actioner_id):int
    {
        
        return $this->bulkAction->execute(ids: $ids, action: 'delete', status: null, actionerId: $actioner_id);

        
    }

    public function bulkForceDeleteData(array $ids):int
    {

        return $this->bulkAction->execute(ids: $ids, action: 'forceDelete', status: null, actionerId: null);
    }

    public function bulkRestoreData(array $ids , int $actioner_id):int        
    {
        return $this->bulkAction->execute($ids, 'restore', null, $actioner_id);    
    }
    public function bulkUpdateStatus(array $ids, GameCategoryStatus $status , ?int $actioner_id = null):int
    {
        if($actioner_id == null){
            $actioner_id = admin()->id;
        }   

      
        return $this->bulkAction->execute($ids, 'status', $status->value, $actioner_id);
    }

    public function findOrFail($id): GameCategory
    {
        return $this->interface->findOrFail($id);
    }   

    
}

