<?php

namespace App\Models;

use App\Models\BaseModel;

class GameCategory extends BaseModel
{
    //

    protected $guarded = [];



    // Scope    
       public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
        });
    }

}
