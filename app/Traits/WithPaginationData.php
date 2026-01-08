<?php


namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

trait WithPaginationData
{

    use  WithPagination;

    public $pagination = [];
    #[Url()]
    protected $perPage = 12;

    protected  $queryString = 1;
    public function paginationData(LengthAwarePaginator $paginator): void
    {
        $this->pagination =  [
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'per_page'     => $paginator->perPage(),
            'total'        => $paginator->total(),
            'from'         => $paginator->firstItem(),
            'to'           => $paginator->lastItem(),
        ];
    }
}
