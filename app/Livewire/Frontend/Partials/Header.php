<?php

namespace App\Livewire\Frontend\Partials;

use Livewire\Component;

class Header extends Component
{

    public $activeDropdown; // Track which dropdown is open
    
    // Toggle dropdown
    public function toggleDropdown($type)
    {
        if ($this->activeDropdown === $type) {
            $this->activeDropdown = ''; // Close if already open
        } else {
            $this->activeDropdown = $type; // Open selected dropdown
        }
    }
    
    // Close dropdown
    public function closeDropdown()
    {
        $this->activeDropdown = '';
    }

    public function render()
    {
        return view('livewire.frontend.partials.header');
    }
}
