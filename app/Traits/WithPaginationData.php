<?php

namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

/**
 * Provides pagination metadata only (no items) for the pagination UI component.
 * Run the paginated query once in render(), then call paginationData($paginator).
 */
trait WithPaginationData
{
    use WithPagination;

    /** @var array Pagination metadata only: current_page, last_page, per_page, total, from, to */
    public $pagination = [];

    #[Url()]
    protected $perPage = 12;

    protected $queryString = 1;

    public function paginationData(LengthAwarePaginator $paginator): void
    {
        $this->pagination = [
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'per_page'     => $paginator->perPage(),
            'total'        => $paginator->total(),
            'from'         => $paginator->firstItem(),
            'to'           => $paginator->lastItem(),
        ];
    }
}
