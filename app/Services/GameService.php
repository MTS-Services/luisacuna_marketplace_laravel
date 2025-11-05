<?php

namespace App\Services;

use App\Actions\game\BulkAction;
use App\Actions\Game\CreateAction;
use App\Actions\Game\UpdateAction;
use App\Actions\Game\DeleteAction;
use App\Actions\Game\RestoreAction;
use App\Enums\GameStatus;
use App\Models\Game;
use App\Repositories\Contracts\GameRepositoryInterface;

class GameService
{
    public function __construct(
        protected GameRepositoryInterface $interface,
        protected CreateAction $createAction,
        protected DeleteAction $deleteAction,
        protected UpdateAction $updateAction,
        protected RestoreAction $restoreAction,
        protected BulkAction $bulkAction,
    ) {}


    public function getAllDatas()
    {

        return $this->interface->all();
    }

    public function findData(int $id)
    {

        return $this->interface->find($id);
    }
    public function getPaginateDatas(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->interface->paginate($perPage, $filters, $queries ?? []);
    }

    public function getTrashedPaginateDatas(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->interface->trashPaginate($perPage, $filters, $queries ?? []);
    }

    public function deleteData($id, $forceDelete = false, ?int $actioner_id = null)
    {
        if ($actioner_id == null) {
            $actioner_id = admin()->id;
        }
        return $this->deleteAction->execute($id, $forceDelete, $actioner_id);
    }

    public function forceDeleteData($id, $force_delete = true, ?int $actioner_id = null): bool
    {

        return $this->deleteAction->execute($id, $force_delete, $actioner_id);
    }

    public function bulkDelete($ids, $actioner_id = null): int
    {
        if ($actioner_id == null) {
            $actioner_id = admin()->id;
        }

        return  $this->bulkAction->execute($ids, 'delete', null, $actioner_id);
    }

    public function bulkForceDelete($ids)
    {

        return  $this->bulkAction->execute($ids, 'forceDelete',);
    }
    public function bulkUpdateStatus($ids, GameStatus $status, $actioner_id = null): int
    {
        if ($actioner_id == null) {
            $actioner_id = admin()->id;
        }
        return $this->bulkAction->execute($ids, 'status', $status->value, $actioner_id);
    }

    public function bulkRestore($ids, ?int $actioner_id = null): int
    {
        if ($actioner_id == null) {
            $actioner_id = admin()->id;
        }
        return $this->bulkAction->execute($ids, 'restore', null, $actioner_id);
    }

    public function restoreData($id, $actioner_id): bool
    {
        return $this->restoreAction->execute($id, $actioner_id);
    }

    public function createData(array $data): ?Game
    {
        return $this->createAction->execute($data);
    }

    public function updateData($id, array $data, ?int $actioner_id = null): bool
    {
        if ($actioner_id == null) {
            $actioner_id = admin()->id;
        }
        return $this->updateAction->execute($id, $data, $actioner_id);
    }
}
