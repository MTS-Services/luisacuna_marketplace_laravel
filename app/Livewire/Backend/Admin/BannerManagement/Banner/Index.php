<?php

namespace App\Livewire\Backend\Admin\BannerManagement\Banner;

use App\Enums\HeroStatus;
use App\Livewire\Forms\BannerForm;
use App\Models\Hero;
use App\Services\Cloudinary\CloudinaryService;
use App\Services\HeroService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Livewire\WithFileUploads;

class Index extends Component
{
    use WithDataTable, WithNotification, WithFileUploads;

    public $showDeleteModal = false;
    public $deleteId = null;
    public $statusFilter = '';
  
    protected HeroService $heroService;

    protected CloudinaryService $cloudinaryService;

    public Hero $data;
    public function boot(HeroService $heroService, CloudinaryService $cloudinaryService)
    {
        $this->heroService = $heroService;
        $this->cloudinaryService = $cloudinaryService;
    }
    public function render()
    {
        $datas = $this->heroService->getPaginatedData(
            perPage: 12,
            filters: $this->getFilters()
        );

      
        $columns = [
            [
                'key' => 'image',
                'label' => 'Icon',
                'format' => function ($data){
                    if(!empty($data->image)){
                      return ' <img src="'. storage_url($data->image).' alt="" class="w-20 h-auto">';
                    }else{
                        return 'NO Image';
                    }
                    
                }
            ],
            [
                'key' => 'title',
                'label' => 'Title',
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

        ];

        $actions = [
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.bm.banner.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete', 'encrypt' => true],
        ];


        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];


        return view('livewire.backend.admin.banner-management.banner.index', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions
        ]);
    }
   

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete(): void
    {
        try {
            if (!$this->deleteId) {
                $this->warning('No data selected');
                return;
            }
            $this->heroService->deleteData(decrypt($this->deleteId));
            $this->reset(['deleteId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete data: ' . $e->getMessage());
        }
    }
    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
        ];
    }


    protected function getSelectableIds(): array
    {
         $data = $this->heroService->getPaginatedData(
            perPage: 12,
            filters: $this->getFilters()
        );
  
        return array_column($data->items(), 'id');
    }
}
