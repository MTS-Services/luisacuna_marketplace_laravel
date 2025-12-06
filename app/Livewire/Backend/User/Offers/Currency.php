<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\GameService;
use Livewire\Component;
use Livewire\WithPagination;

class Currency extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 7;

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

        $allItems = collect([
            [
                'id' => 1,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '1B',
                'min_quantity' => '100k',
                'price' => '$6.5 (100k)',
                'status' => $this->itemStatuses[1] ?? 1,
                'delivery_time' => '1 h',
            ],
            [
                'id' => 2,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2B',
                'min_quantity' => '200K',
                'price' => '$9.5 (200k)',
                'status' => $this->itemStatuses[2] ?? 1,
                'delivery_time' => '10 min',
            ],
            [
                'id' => 3,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2M',
                'min_quantity' => '1K',
                'price' => '$6 (1k)',
                'status' => $this->itemStatuses[3] ?? 1,
                'delivery_time' => '15 min',
            ],
            [
                'id' => 4,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '10M',
                'min_quantity' => '10K',
                'price' => '$6.5 (10k)',
                'status' => $this->itemStatuses[4] ?? 1,
                'delivery_time' => '45 min',
            ],
            [
                'id' => 5,
                'name' => 'Call of Duty Skin',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '20M',
                'min_quantity' => '20K',
                'price' => '$9.5 (20k)',
                'status' => $this->itemStatuses[5] ?? 0,
                'delivery_time' => '1 h',
            ],
            [
                'id' => 6,
                'name' => 'Apex Legends',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '10M',
                'min_quantity' => '50K',
                'price' => '$5.5 (50k)',
                'status' => $this->itemStatuses[6] ?? 0,
                'delivery_time' => '1 h',
            ],
            [
                'id' => 7,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2.5B',
                'min_quantity' => '100K',
                'price' => '$6.5 (100k)',
                'status' => $this->itemStatuses[7] ?? 0,
                'delivery_time' => '1 h',
            ],
            [
                'id' => 8,
                'name' => 'Fortnite',
                'game_image' => asset('assets/images/order.png'),
                'quantity' => '2.5B',
                'min_quantity' => '100K',
                'price' => '$6.5 (100k)',
                'status' => $this->itemStatuses[8] ?? 0,
                'delivery_time' => '1 h',
            ],
        ])->map(fn($item) => (object)$item);

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
                        navigator.clipboard.writeText('" . route('user.currency', ['id' => '{id}']) . "')
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

        return view('livewire.backend.user.offers.currency', [
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
        $url = route('user.currency') . '?id=' . $id;

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
