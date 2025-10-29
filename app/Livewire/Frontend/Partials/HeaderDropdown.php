<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class HeaderDropdown extends Component
{
    public $dropdownType = '';
    public $search = '';
    
    public function mount($dropdownType)
    {
        $this->dropdownType = $dropdownType;
    }
    
    // Get content based on dropdown type
    public function getContentProperty()
    {
        return match($this->dropdownType) {
            'currency' => $this->getCurrencyGames(),
            'boosting' => $this->getBoostingServices(),
            'items' => $this->getGameItems(),
            'accounts' => $this->getAccounts(),
            'topups' => $this->getTopUps(),
            'coaching' => $this->getCoachingServices(),
            'gift-cards' => $this->getGiftCardServices(),
            default => [],
        };
    }
    
    private function getCurrencyGames()
    {
        return [
            'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }
    
    private function getBoostingServices()
    {
        return [
            'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }
    
    private function getGameItems()
    {
        return [
           'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }
    
    private function getAccounts()
    {
        return [
           'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }
    
    private function getTopUps()
    {
        return [
            'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }
    
    private function getCoachingServices()
    {
        return [
            'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }

    private function getGiftCardServices()
    {
        return [
            'popular' => [
                ['name' => 'New World Coins', 'icon' => 'Frame 100.png'],
                ['name' => 'Worldforge Legends', 'icon' => 'Frame 94.png'],
                ['name' => 'Exilecon Official Trailer', 'icon' => 'Frame 93.png'],
                ['name' => 'Echoes of the Terra', 'icon' => 'Frame 96.png'],
                ['name' => 'Path of Exile 2 Currency', 'icon' => 'Frame 103.png'],
                ['name' => 'Epochs of Gaia', 'icon' => 'Frame 102.png'],
                ['name' => 'Throne and Liberty Lucent', 'icon' => 'Frame 105.png'],
                ['name' => 'Titan Realms', 'icon' => 'Frame 98.png'],
                ['name' => 'Blade Ball Tokens', 'icon' => 'Frame 97.png'],
                ['name' => 'Kingdoms Across Skies', 'icon' => 'Frame 99.png'],
                ['name' => 'EA Sports FC Coins', 'icon' => 'Frame1001.png'],
                ['name' => 'Realmwalker: New Dawn', 'icon' => 'Frame 111.png'],
            ],
            'all' => [
                'EA Sports FC Coins',
                'Albion Online Silver',
                'Animal Crossing: New Horizons Bells',
                'Black Desert Online Silver',
                'Blade & Soul NEO Divine Gems',
                'Blade Ball Tokens',
            ]
        ];
    }
    
    public function render()
    {
        return view('livewire.frontend.partials.header-dropdown');
    }
}
