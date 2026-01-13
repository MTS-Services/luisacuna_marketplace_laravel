<?php

namespace App\Services;

use App\Models\Helpful;
use Illuminate\Support\Facades\DB;

class HelpfullService
{
    /**
     * Create a new class instance.
     */
    public function __construct(protected Helpful $model)
    {
        //
    }

    public function findData(string $column_value, string $column_name = 'ip_address')
    {
        return $this->model->find($column_value, $column_name);
    }
    public function createData(array $data): Helpful|false
    {
        if (!isset($data['user_id'])) {
            $data['user_id'] = user()?->id;
        }

        if (!isset($data['ip_address'])) {
            $data['ip_address'] = request()->ip();
        }

        $findData = $this->findData($data['ip_address']);


        if (!$findData) {
            return Helpful::create($data);
        }

        if ($findData->created_at->addHours(24)->isFuture()) {
            return false;
        }

        return Helpful::create($data);
    }
}
