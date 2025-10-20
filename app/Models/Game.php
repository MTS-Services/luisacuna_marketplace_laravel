<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{
    //

    protected $fillable = [

        'name',
        'slug',
        'description',
        'developer',
        'publisher',
        'release_date',
        'platfrom',
        'logo',
        'banner',
        'thumbnail',
        'is_featured',
        'is_trending',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'status',   
        'game_category_id',
        'sort_order',


        'creater_type',
        'updater_type',
        'deleter_type',
        'creater_id',
        'updater_id',
        'deleter_id',

    ];
}
