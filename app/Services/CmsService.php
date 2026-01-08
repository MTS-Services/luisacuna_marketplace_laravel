<?php

namespace App\Services;

use App\Models\Cms;
use App\Enums\CmsType;
use Illuminate\Support\Facades\Log;

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

            $oldData = $cms;
            $contentChange = isset($data['content']) && $data['content'] !== $oldData['content'];
            // Update existing
            $newData = $cms->update([
                'content' => $data['content'],
                'sort_order' => $data['sort_order'] ?? $cms->sort_order,
                'updated_by' => $data['updated_by'] ?? $this->adminId,
            ]);

            $freshData = $cms->fresh();

         if ($contentChange) {
             Log::info('Cms Translationsd Created', [
            'cms_id' => $freshData->id,
            'content' => $freshData->content
            ]);

            $freshData->dispatchTranslation(
                defaultLanguageLocale: 'en',
                targetLanguageIds: null
            );
        }
        } else {
            // Create new if not exists
            $cms = $this->model->create([
                'type' => $typeValue,
                'content' => $data['content'],
                'sort_order' => $data['sort_order'] ?? 0,
                'created_by' => $data['updated_by'] ?? $this->adminId,
                'updated_by' => $data['updated_by'] ?? $this->adminId,
            ]);

            $freshData = $cms->fresh();

            Log::info('Cms Translation Created', [
            'cms_id' => $freshData->id,
            'content' => $freshData->content
            ]);

            $freshData->dispatchTranslation(
                defaultLanguageLocale: 'en',
                targetLanguageIds: null
            );
            return $freshData;

        }

        return $cms->fresh();
    }
}
