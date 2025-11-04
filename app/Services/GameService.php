<?php 

namespace App\Services\Game;


use App\Actions\Game\CreateAction;
use App\Actions\Game\UpdateAction;
use App\Actions\Game\DeleteAction;
use App\DTOs\Game\UpdateGameDTO;
use App\Enums\GameStatus;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;

class GameService
{
    public function __construct(
         protected GameRepositoryInterface $interface,
         protected CreateAction $createAction , 
         protected DeleteAction $deleteAction,
         protected UpdateAction $updateAction,
         )
    { }


    public function getAllDatas(){

        return $this->interface->all();

    }

    public function findData(int $id){

        return $this->interface->find($id);
    }
    public function getPaginateDatas(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->interface->paginate($perPage, $filters, $queries ?? []);
    }
    
    public function getTrashedPaginateData(int $perPage = 15, array $filters = [], ?array $queries = null) 
    {
        return $this->interface->trashPaginate($perPage, $filters, $queries ?? []);
    }

    public function deleteData($ids, ?int $actioner_id = null)
    {
        if($actioner_id == null){
            $actioner_id = admin()->id;
        }
        return $this->deleteAction->execute($id, $actioner_id);
    }

    public function bulkUpdateStatus($ids, GameStatus $status)
    {
        return $this->interface->bulkUpdateStatus($ids, $status);
    }

    public function bulkRestoreGame($ids) :bool
    {
        return $this->interface->bulkRestoreGame($ids);
    }

    public function restoreGame($id) :bool
    {
        return $this->interface->restoreGame($id);
    }
    public function findOrFail($id): Game
    {
        return $this->interface->findOrFail($id);
    }

    public function createData(array $data): ?Game
    {
        return $this->createAction->execute($data);
    }

    public function updateData($id, array $data, ?int $actioner_id = null): bool
    {
        if($actioner_id == null){
            $actioner_id = admin()->id;
        }
        return $this->updateAction->execute($id, $data, $actioner_id);
    }
}