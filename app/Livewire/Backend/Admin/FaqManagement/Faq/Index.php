<?php

namespace App\Livewire\Backend\Admin\FaqManagement\Faq;
use App\Enums\FaqType;

use App\Enums\FaqStatus;
use App\Services\FaqService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Index extends Component
{
    use WithDataTable, WithNotification;
    public $typeses = [];
    public $statusFilter = '';
    public $selectedIds = [];
    public $selectAll = false;
    public $deleteId = null;
    public $bulkAction = '';
    public $showDeleteModal = false;
    public $showBulkActionModal = false;

    protected FaqService $service;

    public function boot(FaqService $service)
    {
        $this->service = $service;
    }

    public function render()
    {
        $datas = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        )->load('creater_admin');


        $columns = [



            [
                'key' => 'question',
                'label' => 'Question',
                'format' => fn($data) => $data->question ?? 'System'
            ],


            [
                'key' => 'answer',
                'label' => 'Answer',
                'format' => fn($data) => $data->answer ?? 'System'
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


            // [
            //     'key' => 'type',
            //     'label' => 'Type',
            //     'format' => fn($data) => $data->type ?? 'System'
            // ],

            //  [
            //     'key' => 'type',
            //     'label' => 'Type',
            //     'sortable' => true,
            //     'format' => function ($data) {
            //         return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium badge badge-soft ' . $data->type->color() . '">' .
            //             $data->type->label() .
            //             '</span>';
            //     }
            // ],


        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.flm.faq.show', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.flm.faq.edit', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'confirmDelete', 'encrypt' => true],
        ];

         $this->typeses = [
             ['value' => 1, 'label' => 'Buyer'],
             ['value' => 2, 'label' => 'Seller'],
        ];

        $bulkActions = [
            ['value' => 'delete', 'label' => 'Delete'],
            ['value' => 'active', 'label' => 'Active'],
            ['value' => 'inactive', 'label' => 'Inactive'],
        ];

        return view('livewire.backend.admin.faq-management.faq.index', [
            'datas' => $datas,
            'statuses' => FaqStatus::options(),
            'typeses' => FaqType::options(),
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => $bulkActions,
        ]);
    }

    // ----------------- Single Delete -----------------
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
            $this->service->deleteData(decrypt($this->deleteId));
            $this->reset(['deleteId', 'showDeleteModal']);
            $this->success('Data deleted successfully');
        } catch (\Exception $e) {
            $this->error('Failed to delete data: ' . $e->getMessage());
        }
    }

    // ----------------- Filters -----------------
    public function resetFilters(): void
    {
        $this->reset(['search', 'statusFilter', 'selectedIds', 'selectAll', 'bulkAction']);
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search ?? '',
            'status' => $this->statusFilter,
            'sort_field' => $this->sortField ?? 'id',
            'sort_direction' => $this->sortDirection ?? 'asc',
        ];
    }

    // ----------------- Status Update -----------------
    public function changeStatus($id, $status): void
    {
        try {
            $dataStatus = FaqStatus::from($status);

            match ($dataStatus) {
                FaqStatus::ACTIVE => $this->service->updateStatusData($id, FaqStatus::ACTIVE),
                FaqStatus::INACTIVE => $this->service->updateStatusData($id, FaqStatus::INACTIVE),
                default => null,
            };

            $this->success('Data status updated successfully');
        } catch (\Exception $e) {
            $this->error('Failed to update status: ' . $e->getMessage());
        }
    }

    // ----------------- Bulk Actions -----------------
    public function confirmBulkAction(): void
    {
        if (empty($this->selectedIds) || empty($this->bulkAction)) {
            $this->warning('Please select data and an action');
            Log::info('No data selected or no bulk action selected');
            return;
        }

        $this->showBulkActionModal = true;
    }

    public function executeBulkAction(): void
    {
        $this->showBulkActionModal = false;

        try {
            match ($this->bulkAction) {
                'delete' => $this->bulkDelete(),
                'active' => $this->bulkUpdateStatus(FaqStatus::ACTIVE),
                'inactive' => $this->bulkUpdateStatus(FaqStatus::INACTIVE),
                default => null,
            };

            $this->selectedIds = [];
            $this->selectAll = false;
            $this->bulkAction = '';
        } catch (\Exception $e) {
            $this->error('Bulk action failed: ' . $e->getMessage());
        }
    }

    protected function bulkDelete(): void
    {
        $count = $this->service->bulkDeleteData($this->selectedIds);
        $this->success("{$count} data deleted successfully");
    }

    protected function bulkUpdateStatus(FaqStatus $status): void
    {
        $count = count($this->selectedIds);
        $this->service->bulkUpdateStatus($this->selectedIds, $status);
        $this->success("{$count} data updated successfully");
    }

    protected function getSelectableIds(): array
    {
        $data = $this->service->getPaginatedData(
            perPage: $this->perPage,
            filters: $this->getFilters()
        );

        return array_column($data->items(), 'id');
    }
}
