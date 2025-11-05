<?php

namespace App\Actions\PageView;

use App\Repositories\Contracts\PageViewRepositoryInterface;

class ResotreAction
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PageViewRepositoryInterface $interface
    ) {}


    public function execute(int $id, int $actionerId)
    {
        return $this->interface->restore($id, $actionerId);
    }
}
