<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface ProductTypeRepositoryInterface
{

    /* ================== ================== ==================
    *                      Find Methods 
    * ================== ================== ================== */
    public function all(string $sortField = 'created_at', $order = 'desc'): Collection;

    /* ================== ================== ==================
    *                    Data Modification Methods 
    * ================== ================== ================== */
    public function create(array $data);
}
