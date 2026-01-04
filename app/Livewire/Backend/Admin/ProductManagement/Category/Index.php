<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Category;

use Livewire\Component;
use App\Services\ProductService;
use App\Enums\ActiveInactiveEnum;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class Index extends Component
{
    use WithDataTable, WithNotification;

    public $statusFilter = '';


    public $categoryFilter = null;
    public $categorySlug = null;
    // public $categorySlug;



    protected ProductService $service;

    public function boot(ProductService $service)
    {
        $this->service = $service;
    }

    public function mount($categorySlug)
    {
        $this->categorySlug = $categorySlug;
    }


    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );


        // dd($datas);
        // $datas->load('creater_admin');

        $columns = [

            [
                'key' => 'slug',
                'label' => 'Game',
                'sortable' => false,
                'format' => fn($item) =>
                '<div class="flex items-center gap-3">
                    <img src="' . ($item->games->logo) . '" class="w-10 h-10 rounded-lg object-cover" alt="' . ($item->games->slug ?? 'Game') . '">
                    <span class="font-semibold text-text-white">' . ($item->games->slug ?? '-') . '</span>
                </div>'
            ],
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true,
                'format' => fn($item) =>
                '<a href="' . route('admin.am.admin.view', encrypt($item->id)) . '" class="font-semibold text-text-white">' . ($item->user->username ?? '-') . '</a>'
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'sortable' => true,
            ],
            [
                'key' => 'price',
                'label' => 'Price',
                'sortable' => true,
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
                'label' => 'Start Date',
                'sortable' => true,
                'format' => function ($data) {
                    return $data->created_at_formatted;
                }
            ],
        ];

        $actions = [
            [
                'key' => 'id',
                'label' => 'View',
                'route' => 'admin.pm.category.details',
                'encrypt' => true
            ],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Activate'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.product-management.category.index', [
            'categories' => $datas,
            'statuses' => ActiveInactiveEnum::options(),
            // 'layouts' => ::options(),
            'columns' =>  $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }


    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'perPage', 'sortField', 'sortDirection', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }


    protected function getFilters(): array
    {
        return [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField,
            'sort_direction' => $this->sortDirection,
            'categorySlug' => $this->categorySlug ?? null,
        ];
    }

    protected function getSelectableIds(): array
    {
        $data = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return array_column($data->items(), 'id');
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }
}
