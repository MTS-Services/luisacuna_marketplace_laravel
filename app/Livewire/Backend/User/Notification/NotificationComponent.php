<?php

namespace App\Livewire\Backend\User\Notification;

use Livewire\Component;
use Livewire\WithPagination;

class NotificationComponent extends Component
{
    use WithPagination;


    public $perPage = 4;
    public function render()
    {
        $allItems = collect(
            [
                [
                    'id' => 1,
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
                ],
                [
                    'id' => 2,
                    'title' => 'Fortnite Fresh Account ',
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
                ],
                [
                    'id' => 3,
                    'title' => 'Fortnite Fresh Account ',
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
                ],
                [
                    'id' => 4,
                    'title' => 'Fortnite Fresh Account ',
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
                ],
                [
                    'id' => 5,
                    'title' => 'Fortnite Fresh Account ',
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
                ],
                [
                    'id' => 6,
                    'title' => 'Fortnite Fresh Account ',
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
                ],
                [
                    'id' => 7,
                    'title' => 'Fortnite Fresh Account ',
                    'title' => 'Digimon Super Rumble is HERE!',
                    'subtitle' => 'Hello dear sellers, just now we added Digimon Super Rumble game to Accounts and Currency categories. You can start listing your offers any minute now ',
                    'uploaded_at' => '9min ago',
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

        return view('livewire.backend.user.notification.notification-component', [
            'allItems' => $allItems,
            'items' => $items,
            'pagination' => $pagination
        ]);
    }
}
