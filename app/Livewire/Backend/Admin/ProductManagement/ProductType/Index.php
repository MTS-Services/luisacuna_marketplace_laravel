<?php

namespace App\Livewire\Backend\Admin\ProductManagement\ProductType;

use Livewire\Component;
use App\Enums\ProductTypeStatus;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use App\Services\Product\ProductTypeService;

class Index extends Component
{

    use WithDataTable, WithNotification;


    protected ProductTypeService $service;

    public function boot(ProductTypeService $service)
    {
        $this->service = $service;
    }
    public function render()
    {
        $datas = $this->service->getAll(
            // $this->search,
        );

        $columns = [
            [
                'key' => 'name',
                'label' => 'Name',
                'sortable' => true
            ],
            [
                'key' => 'description',
                'label' => 'Description',
                'sortable' => true
            ],
            [
                'key' => 'comission_rate',
                'label' => 'Comission Rate',
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
                'key' => 'created_by',
                'label' => 'Created By',
                'format' => function ($data) {
                    return $data->createdBy?->name ?? 'System';
                }
            ],
        ];
        return view('livewire.backend.admin.product-management.product-type.index', [
            'datas' => $datas,
            'columns' => $columns,
            'statuses' => ProductTypeStatus::options(),
        ]);
    }
}
