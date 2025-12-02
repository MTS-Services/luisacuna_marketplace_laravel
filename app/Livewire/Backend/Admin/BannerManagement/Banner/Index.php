<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Services\HeroService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;
    public $statusFilter = '';
    public $showDeleteModal = false;
    public $deleteCategoryId = null;
    public $bulkAction = '';
    public $showBulkActionModal = false;
    public $deleteId = null;

    protected HeroService $heroService;
    public function boot(HeroService $heroService)
    {
        $this->heroService = $heroService;
    }
    public function render()
    {
        $datas  = $this->heroService->getPaginatedData();
         $datas->load('creater_admin');

        $columns = [
          
              [
                'key' => 'banner_image',
                'label' => 'Banner Image',
                'format' => function ($data) {
                    return '<img src="' .storage_url($data->banner_image ). '" alt="' . $data->title . '" class="w-10 h-10 rounded-full object-cover shadow-sm">';

                }
            ],
            [
                'key' => 'title',
                'label' => 'Title',
                'sortable' => true
            ],
            [
                'key' => 'banner_content',
                'label' => 'Content',
                'sortable' => true
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'sortable' => true,
                'format' => function ($data) {
                    return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->status->color() . '">' .
                        $data->status->label() .
                        '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
            [
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->creater_admin?->name ?? 'System';
                }
            ],
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.bm.banner.view', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.bm.banner.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete'],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Activate'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];
        return view('livewire.backend.admin.banner-management.banner.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
            'statuses' => HeroStatus::options(),
        ]);
    }
}
