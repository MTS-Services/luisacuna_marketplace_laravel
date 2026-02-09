<?php 

namespace App\Services;

use App\Models\EmailTemplate;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;


class EmailTemplateService{

 public function __construct(protected EmailTemplate $model){}

    public function paginateDatas(int $perPage = 15, array $filters = []): LengthAwarePaginator
    {
        $search = $filters['search'] ?? null;
        $sortField = $filters['sort_field'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';


        if ($search) {
            // Scout Search

            return EmailTemplate::search($search)
                ->query(fn($query) => $query->filter($filters)->orderBy($sortField, $sortDirection))
                ->paginate($perPage);
        }

        return $this->model->query()
            ->filter($filters)
            ->orderBy($sortField, $sortDirection)
            ->paginate($perPage);
    }
    public function find($id, $column = 'id'):EmailTemplate
    {

        return $this->model->where($column, $id)->first();

    }

    public function update(int $id, $data){

        $this->model->updateOrCreate(['id'=>$id],$data);
        
    }
}

