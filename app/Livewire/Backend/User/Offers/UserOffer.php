<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use App\Services\ProductService;
use App\Enums\ActiveInactiveEnum;
use App\Services\OfferItemService;
use App\Traits\Livewire\WithDataTable;
use App\Traits\Livewire\WithNotification;

class UserOffer extends Component
{

    use WithDataTable, WithNotification;

    public $categorySlug;
    public $showDeleteModal = false;
    public $deleteItemId;
    public $url;

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

        $columns = [
            [
                'key' => 'name',
                'label' => 'Game',
                'sortable' => true,
                'format' => fn($item) => '<div class="flex items-center gap-3"><img src="' . ($item->game_image ?? null) . '" class="w-10 h-10 rounded-lg object-cover" alt="' . ($item->name ?? 'Game') . '"><span class="font-semibold text-text-white">' . ($item->name ?? '-') . '</span></div>'
            ],
            [
                'key' => 'quantity',
                'label' => 'Quantity',
            ],
            [
                'key' => 'min_quantity',
                'label' => 'Minimum quantity',
            ],
            [
                'key' => 'price',
                'label' => 'Price',
            ],
            [
                'key' => 'status',
                'label' => 'Status',
                'badge' => true,
                'format' => fn($item) => '<span class="px-2 py-1 rounded-full text-xs text-white ' . ($item->status === ActiveInactiveEnum::ACTIVE->value ? 'bg-pink-500' : 'bg-status-paused') . '">' . ($item->status === ActiveInactiveEnum::ACTIVE->value ? 'Active' : 'Paused') . '</span>'

            ],
            [
                'key' => 'delivery_time',
                'label' => 'Delivery time',
            ],
        ];

        $actions = [
            [
                'icon' => 'pause-fill',
                'method' => 'pauseOffer',
                'label' => 'Pause',
                'condition' => fn($item) => $item->status === ActiveInactiveEnum::ACTIVE->value,
            ],
            [
                'icon' => 'play-fill',
                'method' => 'resumeOffer',
                'label' => 'Resume',
                'condition' => fn($item) => $item->status === ActiveInactiveEnum::INACTIVE->value,
            ],
            [
                'icon' => 'link-fill',
                'method' => 'copyItemLink',
                'label' => 'Link',
            ],
            [
                'icon' => 'pencil-simple-fill',
                'route' => 'user.offers',
                'label' => 'Edit',
            ],
            [
                'icon' => 'trash-fill',
                'method' => 'confirmDelete',
                'label' => 'Delete',
            ],
        ];

        return view('livewire.backend.user.offers.user-offer', [
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'statuses' => ActiveInactiveEnum::options(),
        ]);
    }
    public function pauseOffer(int $productId)
    {
        $this->changeStatus($productId, ActiveInactiveEnum::INACTIVE->value);
    }
    public function resumeOffer(int $productId)
    {
        $this->changeStatus($productId, ActiveInactiveEnum::ACTIVE->value);
    }

    public function changeStatus(int $productId, ?string $status = null)
    {
        try {
            $this->service->updateStatus($productId, $status);

            $this->success('Status updated successfully!');
            $this->dispatch('refreshDataTable');
        } catch (\Exception $e) {
            $this->error('Failed to update status!');
        }
    }

    public function confirmDelete($id): void
    {
        $this->deleteItemId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteProduct(): void
    {
        try {
            if (!$this->deleteItemId) {
                $this->warning('No data selected');
                return;
            }
            $this->service->deleteProduct($this->deleteItemId);
            $this->reset(['deleteItemId', 'showDeleteModal']);

            $this->success('Data deleted successfully');
            $this->emit('refreshDataTable');
        } catch (\Exception $e) {
            $this->error('Failed to delete product: ' . $e->getMessage());
        }
    }

    protected function getFilters(): array
    {
        return [
            'search' => $this->search ?? null,
            'sort_field' => $this->sortField ?? 'created_at',
            'sort_direction' => $this->sortDirection ?? 'desc',
            'user_id' => user()->id,
            'categorySlug' => $this->categorySlug,
        ];
    }
    // public function copyItemLink($id)
    // {
    //     $data = $this->service->findData($id)->load(['category', 'games']);
    //     $url = route('game.buy', [
    //         'gameSlug' => $data->games->slug,
    //         'categorySlug' => $data->category->slug,
    //         'productId' => encrypt($id)
    //     ]);

    //     $this->dispatchBrowserEvent('copy-link', ['url' => $url]);
    // }

    public function copyItemLink($id)
    {

        $data = $this->service->findData($id)->load(['category', 'games']);
        $url = route('game.buy', ['gameSlug' => $data->games->slug, 'categorySlug' => $data->category->slug, 'productId' => encrypt($id)]);
        $this->url = $url;
    }
}
