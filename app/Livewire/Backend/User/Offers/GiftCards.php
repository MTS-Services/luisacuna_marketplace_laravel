<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\GameService;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;

class GiftCards extends Component
{

    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 4;

    public $itemStatuses = [];

    protected GameService $gameService;
    public function boot(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function mount()
    {
        $this->itemStatuses = [
            1 => 1,
            2 => 1,
            3 => 1,
            4 => 1,
            5 => 0,
            6 => 0,
            7 => 0,
            8 => 0,
        ];
    }



    public function render()
    {

        $games = $this->gameService->getAllDatas();

        $allItems = collect(
            [
                [
                    'id' => 1,
                    'name' => 'Cheapest Fresh Fortnite',
                    'subtitle' => 'Account with 135,000 V-Bud....',
                    'game_image' => asset('assets/images/item1.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$65',
                    'device' => 'PC',
                    'status' => $this->itemStatuses[1] ?? 1,
                    'delivery_time' => '1 h',
                ],
                [
                    'id' => 2,
                    'name' => 'Fortnite Fresh Account ',
                    'subtitle' => '(135,000 V-Bucks) | Works...',
                    'game_image' => asset('assets/images/item2.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$95',
                    'device' => 'Xbox',
                    'status' => $this->itemStatuses[2] ?? 1,
                    'delivery_time' => '10 min',
                ],
                [
                    'id' => 3,
                    'name' => '135,000 V-Bucks Fortnite ',
                    'subtitle' => 'Account | All Platforms Sup...',
                    'game_image' => asset('assets/images/item3.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$60',
                    'device' => 'PC',
                    'status' => $this->itemStatuses[3] ?? 0,
                    'delivery_time' => '15 min',
                ],
                [
                    'id' => 4,
                    'name' => 'Fresh Fortnite Account 135K',
                    'subtitle' => 'V-Bucks | All Platforms Sup...',
                    'game_image' => asset('assets/images/item4.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$65',
                    'device' => 'PC',
                    'status' => $this->itemStatuses[4] ?? 0,
                    'delivery_time' => '45 min',
                ],
                [
                    'id' => 5,
                    'name' => 'Fresh Fortnite Account 135K',
                    'subtitle' => 'V-Bucks | All Platforms Sup...',
                    'game_image' => asset('assets/images/item4.png'),
                    'quantity' => '1',
                    'min_quantity' => '1',
                    'price' => '$65',
                    'device' => 'PC',
                    'status' => $this->itemStatuses[5] ?? 1,
                    'delivery_time' => '45 min',
                ],
            ]
        )->map(fn($item) => (object)$item);

        $currentPage = $this->getPage();
        $items = $allItems->slice(($currentPage - 1) * $this->perPage, $this->perPage)->values();

        $pagination = [
            'total' => $allItems->count(),
            'per_page' => $this->perPage,
            'current_page' => $currentPage,
            'last_page' => ceil($allItems->count() / $this->perPage),
            'from' => (($currentPage - 1) * $this->perPage) + 1,
            'to' => min($currentPage * $this->perPage, $allItems->count()),
        ];

        // Table columns configuration
        $columns =
            [
                [
                    'key' => 'name',
                    'label' => 'Game',
                    'sortable' => true,
                    'format' => fn($item) => '
                      <div class="flex items-center gap-3">
                        <img src="' . storage_url($item->game_image) . '" 
                            class="w-14 h-14 rounded-lg object-cover flex-shrink-0" 
                            alt="' . e($item->name ?? 'Game') . '">
                        <div class="flex flex-col">
                            <span class="font-semibold text-text-white text-sm sm:text-base leading-tight"
                                title="' . e($item->name ?? '-') . '">'
                        . e(Str::limit($item->name ?? '-', 30)) .
                        '</span>
                        <span class="text-text-muted text-xs sm:text-sm"
                            title="' . e($item->subtitle ?? '(No details)') . '">'
                        . e(Str::limit($item->subtitle ?? '(No details)', 28)) .
                        '</span>
                    </div>
                </div>'
                ],
                [
                    'key' => 'quantity',
                    'label' => 'Quantity',
                ],
                [
                    'key' => 'price',
                    'label' => 'Price',
                ],
                [
                    'key' => 'device',
                    'label' => 'Device',
                ],
                [
                    'key' => 'status',
                    'label' => 'Status',
                    'badge' => true,
                    'format' => fn($item) => '<span class="px-2 py-1 rounded-full text-xs text-white ' . ($item->status === 1 ? 'bg-pink-500' : 'bg-status-paused') . '">' . ($item->status === 1 ? 'Active' : 'Paused') . '</span>'
                ],
                [
                    'key' => 'delivery_time',
                    'label' => 'Delivery time',
                ],
            ];

        $actions = [
            [
                'icon' => 'pause-fill',
                'method' => 'pauseItem',
                'label' => 'Pause',
                'condition' => fn($item) => $item->status === 1,
            ],
            [
                'icon' => 'play-fill',
                'method' => 'resumeItem',
                'label' => 'Resume',
                'condition' => fn($item) => $item->status === 0,
            ],
            [
                'icon' => 'link-fill',
                'method' => 'copyItemLink',
                'label' => 'Link',
                'alpine' => true,
                'click' => "
                        navigator.clipboard.writeText('" . route('user.gift-cards', ['id' => '{id}']) . "')
                            .then(() => {
                                \$dispatch('notify', {type: 'success', message: 'Link copied!'})
                            })
                    ",
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

        return view('livewire.backend.user.offers.gift-cards', [
            'items' => $items,
            'games' => $games,
            'columns' => $columns,
            'actions' => $actions,
            'pagination' => $pagination,
        ]);
    }

    public function pauseItem($id)
    {
        $this->itemStatuses[$id] = 0;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item #{$id} paused successfully"
        ]);
    }

    public function resumeItem($id)
    {
        $this->itemStatuses[$id] = 1;

        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item #{$id} resumed successfully"
        ]);
    }

    public function editItem($id)
    {
        // edit logic
        return redirect()->route('routeName', $id);
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function deleteItem()
    {
        if (!$this->deleteItemId) {
            return;
        }

        unset($this->itemStatuses[$this->deleteItemId]);

        $this->showDeleteModal = false;
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => "Item deleted successfully"
        ]);

        $this->deleteItemId = null;
    }
    public function copyItemLink($id)
    {
        $url = route('user.gift-cards') . '?id=' . $id;

        $this->dispatch('copyToClipboard', [
            'url' => $url
        ]);

        // Success message
        $this->dispatch('notify', [
            'type' => 'success',
            'message' => 'Link copied to clipboard!'
        ]);
    }
}
