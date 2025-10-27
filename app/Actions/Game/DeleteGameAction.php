<?php 

namespace App\Actions\Game;

use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class   DeleteGameAction {

    public function __construct(protected GameRepositoryInterface $gameRepository) {}

    public function execute(array $ids, bool $forceDelete = false): bool
    {


      return DB::transaction(function () use ($ids, $forceDelete) {
        
           return $this->gameRepository->deleteGame($ids, $forceDelete);

       });
    }
}