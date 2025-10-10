<?php

namespace App\Traits\Livewire;

trait WithDataTable
{
    

    public function getSortIcon(string $field): string
    {
        if ($this->sortField !== $field) {
            return '⇅';
        }

        return $this->sortDirection === 'asc' ? '↑' : '↓';
    }
}
