<?php

namespace App\Repositories\Eloquent;

use App\Models\Language;
use App\Repositories\Contracts\LanguageRepositoryInterface;

class LanguageRepository implements LanguageRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected Language $model
    )
    {}

    public function all()
    {
        return $this->model->orderBy('created_at', 'desc')->get();
    }
    public function create(array $data): Language
    {
        return $this->model->create($data);
    }
}
