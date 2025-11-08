<?php


namespace App\Actions\Role;

use App\Repositories\Contracts\RoleRepositoryInterface;
use Illuminate\Support\Facades\DB;

class RestoreAction
{
  public function __construct(public RoleRepositoryInterface $interface)
  {

  }

  public function execute(int $id, ?int $actionerId)
  {
    return DB::transaction(function () use ($id, $actionerId) {
      return $this->interface->restore($id, $actionerId);
    });
  }
}
