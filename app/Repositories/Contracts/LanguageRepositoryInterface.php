<?php

namespace App\Repositories\Contracts;

use App\Models\Language;

interface LanguageRepositoryInterface
{
    public function all();
    
    public function create(array $data): Language;
}
