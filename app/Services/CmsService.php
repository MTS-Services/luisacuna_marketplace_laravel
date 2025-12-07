<?php

namespace App\Services;

use App\Models\Cms;
use App\Enums\CmsType;

class CmsService
{
    protected $adminId;
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Cms $model,
    ) {
        $this->adminId ??= admin()?->id;
    }


    public function getByType(CmsType|string $type): ?Cms
    {
        $typeValue = $type instanceof CmsType ? $type->value : $type;

        return $this->model->where('type', $typeValue)->first();
    }

    public function updateByType(CmsType|string $type, array $data): Cms
    {
        $typeValue = $type instanceof CmsType ? $type->value : $type;

        $cms = $this->model->where('type', $typeValue)->first();

        if ($cms) {
            // Update existing
            $cms->update([
                'content' => $data['content'],
                'sort_order' => $data['sort_order'] ?? $cms->sort_order,
                'updated_by' => $data['updated_by'] ?? $this->adminId,
            ]);
        } else {
            // Create new if not exists
            $cms = $this->model->create([
                'type' => $typeValue,
                'content' => $data['content'],
                'sort_order' => $data['sort_order'] ?? 0,
                'created_by' => $data['updated_by'] ?? $this->adminId,
                'updated_by' => $data['updated_by'] ?? $this->adminId,
            ]);
        }

        return $cms->fresh();
    }
}
