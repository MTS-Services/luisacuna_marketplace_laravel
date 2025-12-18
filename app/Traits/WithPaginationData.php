<?php 


namespace App\Traits;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Livewire\WithPagination;

trait WithPaginationData
{
    use  WithPagination;
    
    public $pagination = [];

    protected $perPage = 15;

    protected  $queryString = 1;
    protected function paginationData(LengthAwarePaginator $paginator): array
    {
        return [
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'per_page'     => $paginator->perPage(),
            'total'        => $paginator->total(),
            'from'         => $paginator->firstItem(),
            'to'           => $paginator->lastItem(),
        ];
    }


}