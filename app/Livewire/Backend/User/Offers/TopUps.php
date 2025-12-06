<?php

namespace App\Livewire\Backend\User\Offers;

use App\Services\GameService;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class TopUps extends Component
{
    use WithPagination;

    public $showDeleteModal = false;
    public $deleteItemId = null;
    public $perPage = 3;
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
                'name' => 'Genshin Impact - Genesis ',
                'subtitle' => 'Crystals top up',
                'service' => 'Genshin Impact - Genesis Crystals top up',
                'amount' => '5000 Crystals',
                'quantity' => '1',
                'min_quantity' => '1',
                'price' => '$35',
                'device' => 'PC',
                'status' => $this->itemStatuses[1] ?? 1,
                'delivery_time' => '15 minutes',
            ],
            [
                'id' => 2,
                'name' => 'Fortnite - 10,000 V-Bucks',
                'amount' => '10,000 V-Bucks',
                'price' => '$50',
                'status' => $this->itemStatuses[2] ?? 1,
                'delivery_time' => 'Instant',
            ],
            [
                'id' => 3,
                'name' => 'FIFA Coins - 1,000,000',
                'amount' => '1,000,000 coins',
                'price' => '$30',
                'status' => $this->itemStatuses[3] ?? 1,
                'delivery_time' => '30 minutes',
            ],
            [
                'id' => 4,
                'name' => 'Cheapest Fresh Fortnite',
                'amount' => '135,000 V-Bucks',
                'price' => '$65',
                'status' => $this->itemStatuses[4] ?? 0,
                'delivery_time' => '1 h',
            ],
            [
                'id' => 5,
                'name' => 'Fortnite Fresh Account',
                'amount' => '135,000 V-Bucks',
                'price' => '$95',
                'status' => $this->itemStatuses[5] ?? 0,
                'delivery_time' => '10 min',
            ],
            [
                'id' => 6,
                'name' => '135,000 V-Bucks Fortnite',
                'amount' => '135,000 V-Bucks',
                'price' => '$60',
                'status' => $this->itemStatuses[6] ?? 0,
                'delivery_time' => '15 min',
            ],
            [
                'id' => 7,
                'name' => 'Fresh Fortnite Account 135K',
                'amount' => '135,000 V-Bucks',
                'price' => '$65',
                'status' => $this->itemStatuses[7] ?? 0,
                'delivery_time' => '45 min',
            ],
            [
                'id' => 8,
                'name' => 'Call of Duty Skin',
                'amount' => '20M Credits',
                'price' => '$9.5 (20k)',
                'status' => 'paused',
                'delivery_time' => '1 h',
            ]
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
        $columns =
            [
                [
                    'key' => 'name',
                    'label' => 'Game',
                    'sortable' => true,
                    'format' => fn($item) => '
                <div class="flex items-center gap-3">
                    <div class="flex flex-col">
                        <span class="font-semibold text-text-white text-sm sm:text-base leading-tight"
                            title="' . e($item->name ?? '-') . '">'
                        . e(Str::limit($item->name ?? '-', 30)) .
                        '</span>
                        <span class="text-text-muted text-xs sm:text-sm"
                            title="' . e($item->subtitle ?? '') . '">'
                        . e(Str::limit($item->subtitle ?? '', 28)) .
                        '</span>
                    </div>
                </div>'
                ],
                [
                    'key' => 'amount',
                    'label' => 'Amount',
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

        return view('livewire.backend.user.offers.top-ups', [
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
