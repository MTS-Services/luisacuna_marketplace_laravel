<?php

namespace App\Actions\Admin;

use App\DTOs\Game\CreateGameCategoryDTO;
use App\Models\GameCategory;
use App\Repositories\Contracts\GameCategoryRepositoryInterface;
use Illuminate\Support\Facades\DB;

class CreateGameCategoryAction
{

    public function __construct(
        protected GameCategoryRepositoryInterface $gameCategoryRepository
    ) {}

    public function execute(CreateGameCategoryDTO $dto): GameCategory
    {
       return DB::transaction(function () use ($dto) {

            $dto = $dto->toArray();

            $gameCategory =  $this->gameCategoryRepository->create($dto);

            return $gameCategory->fresh();
        });
    }
}
