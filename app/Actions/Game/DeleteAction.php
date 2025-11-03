<?php 

namespace App\Actions\Game;

use App\Repositories\Contracts\GameRepositoryInterface;
use Illuminate\Support\Facades\DB;

class   DeleteAction {

    public function __construct(protected GameRepositoryInterface $interface) {}

    public function execute($id,  ?int $actionerId = null ): bool
    {
      return DB::transaction(function () use ($id, $actionerId) {

           return $this->interface->delete($id, $actionerId);

       });
    }
}