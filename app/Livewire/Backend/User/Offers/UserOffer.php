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
    public $search = '';


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
                'key' => 'game',
                'label' =>  $this->categorySlug == 'top-up' ? 'Service' : 'Game',
                'sortable' =>  $this->categorySlug == 'top-up' ? true : false,
                'format' => function ($item) {
                    if ($this->categorySlug != 'top-up') {
                        return   '<div class="flex items-center gap-3">
                    <img src="' . ($item->games->logo) . '" class="w-10 h-10 rounded-lg object-cover" alt="' . ($item->games->name ?? 'Game') . '">
                    <span class="font-semibold text-text-white">' . ($item->games->name ?? '-') . '</span>
                </div>';
                    } else {
                        return ' <span class="font-semibold text-text-white">' . ($item->games->name ?? '-') . '</span>';
                    }
                }
            ],

            [
                'key' => 'quantity',
                'label' => 'Quantity',
            ],
            [
                'key' => 'price',
                'label' => 'Price',
                'format' => function ($item) {
                    return currency_symbol() . ' ' .  currency_exchange($item->price);
                }
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
                'key' => 'delivery_timeline',
                'label' => 'Delivery time',
            ],
        ];

        $actions = [
            [
                'icon' => 'pause-fill',
                'method' => 'pauseOffer',
                'label' => 'Pause',
                'condition' => fn($item) => $item->status->value === ActiveInactiveEnum::ACTIVE->value,
            ],
            [
                'icon' => 'play-fill',
                'method' => 'resumeOffer',
                'label' => 'Resume',
                'condition' => fn($item) => $item->status->value === ActiveInactiveEnum::INACTIVE->value,
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
            'pagination' => $datas,
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
            $this->error('Failed to update status: ' . $e->getMessage());
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
    public function copyItemLink($id)
    {

        $data = $this->service->findData($id)->load(['category', 'games']);
        $url = route('game.buy', ['gameSlug' => $data->games->slug, 'categorySlug' => $data->category->slug, 'productId' => encrypt($id)]);
        $this->url = $url;
    }
}
