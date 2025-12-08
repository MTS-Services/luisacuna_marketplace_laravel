<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;

class Product extends BaseModel implements Auditable
{
    use   AuditableTrait;
    //

    protected $fillable = [
        'sort_order',

        'user_id',
        'category_id',
        'game_id',

        'slug',
        'name',
        'description',
        'price',
        'name',
        'quantity',
        'minimum_offer_quantity',
        'delivery_method',
        'delivery_time',
        'status',
        'platform_id',
        

        'creater_id',
        'creater_type',
        'updater_id',
        'updater_type',
        'deleter_id',
        'deleter_type',
        'restorer_id',
        'restorer_type',
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        //
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    } 

    public function platform()
    {
        return $this->belongsTo(Platform::class);
    }

    public function games()
    {
        return $this->belongsTo(Game::class, 'game_id', 'id');
    }

    public function product_configs()
    {
        return $this->hasMany(ProductConfig::class, 'product_id', 'id');
    }


    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            //
        ]);
    }
}
