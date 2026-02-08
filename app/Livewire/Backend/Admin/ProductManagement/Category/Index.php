<?php

namespace App\Livewire\Backend\Admin\ProductManagement\Category;

use Livewire\Component;
use App\Services\ProductService;
use App\Enums\ActiveInactiveEnum;
use App\Services\Cloudinary\CloudinaryService;
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
    public $bulkAction = null;



    protected ProductService $service;

    protected CloudinaryService $cloudinaryService;
    public function boot(ProductService $service, CloudinaryService $cloudinaryService)
    {
        $this->service = $service;
        $this->cloudinaryService = $cloudinaryService;
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
                    <img src="' . storage_url($item->games?->logo) . '" class="w-10 h-10 rounded-lg object-cover" alt="' . ($item->games->slug ?? 'Game') . '">
                    <span class="font-semibold text-text-white">' . ($item->games->name ?? '-') . '</span>
                </div>'
            ],
            [
                'key' => 'name',
                'label' => 'Product Title',
                'sortable' => true,
            ],
            [
                'key' => 'username',
                'label' => 'Name',
                'sortable' => true,
                'format' => fn($item) =>
                '<a href="' . ($item->user ? route('profile', ['username' => $item->user->username]) : '#') . '" target="_blank" class="font-semibold text-text-white">' .
                    ($item->user->username ?? '-') .
                    '</a>'
            ],

            [
                'key' => 'quantity',
                'label' => 'Quantity',
                'sortable' => true,
                'format' => function ($item) {
                    $qty = $item->quantity;

                    if ($qty >= 1000000000) {
                        return round($qty / 1000000000, 1) . 'B';
                    } elseif ($qty >= 1000000) {
                        return round($qty / 1000000, 1) . 'M';
                    } elseif ($qty >= 1000) {
                        return round($qty / 1000, 1) . 'K';
                    }

                    return $qty;
                },
            ],
            [
                'key' => 'grand_total',
                'label' => 'Price',
                'format' => fn($item) => '<span class="text-text-white font-semibold text-xs sm:text-sm">' . currency_symbol() . $item->price  . '</span>'
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
