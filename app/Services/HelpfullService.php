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

    public function createData(array $data): Helpful|false
    {
        if (!isset($data['user_id'])) {
            $data['user_id'] = user()?->id;
        }

        if (!isset($data['ip_address'])) {
            $data['ip_address'] = request()->ip();
        }
        $recentEntry = $this->model->where('ip_address', $data['ip_address'])
            ->where('cms_id', $data['cms_id'])
            ->latest()
            ->first();

        if ($recentEntry && $recentEntry->created_at->addHours(24)->isFuture()) {
            return false;
        }

        return Helpful::create($data);
    }
}
