<?php 

namespace App\Services\Game;

use App\Actions\Admin\CreateGameCategoryAction;
use App\DTOs\GameCategory\CreateGameCategoryDTO;
use App\Enums\GameCategoryStatus;
use App\Models\GameCategory;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;

class GameCategoryService
{
    public function __construct(
        protected GameCategoryRepositoryInterface $gameCategoryRepository,
        protected CreateGameCategoryAction $gameCategoryAction
    )
    {
      
    }

    public function all()
    {
        return $this->gameCategoryRepository->all();
    }
    public function create(CreateGameCategoryDTO $dto)
    {
        return $this->gameCategoryAction->execute($dto);
    }

    public function update( $id, array $dto):bool
    {
        return $this->gameCategoryRepository->update($id, $dto);
    }

    public function deleteCategory($id, bool $force = false):bool
    {
        return $this->gameCategoryRepository->deleteCategory($id, $force);
    }
    public function paginate(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->gameCategoryRepository->paginate($perPage, $filters, $queries ?? []);
    }

    public function paginateOnlyTrashed(int $perPage = 15, array $filters = [], ?array $queries = null)
    {
        return $this->gameCategoryRepository->paginateOnlyTrashed($perPage, $filters, $queries ?? []);
    }   

    public function restoreDelete($id):bool
    {
        return $this->gameCategoryRepository->restoreDelete($id);
    }

    public function bulkDeleteCategories(array $ids, bool $forceDelete = false):bool
    {
        return $this->gameCategoryRepository->bulkDeleteCategories($ids, $forceDelete);
    }

    public function BulkCategoryRestore(array $ids):bool       
    {
        return $this->gameCategoryRepository->BulkCategoryRestore($ids);    
    }
    public function bulkUpdateStatus(array $ids, GameCategoryStatus $status):bool
    {
        return $this->gameCategoryRepository->bulkUpdateStatus($ids, $status);
    }

    public function findOrFail($id): GameCategory
    {
        return $this->gameCategoryRepository->findOrFail($id);
    }   
}

