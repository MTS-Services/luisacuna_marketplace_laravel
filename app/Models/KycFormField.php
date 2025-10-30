<?php

namespace App\Models;

use App\Enums\KycFormFieldsInputType;
use App\Models\BaseModel;
use App\Traits\AuditableTrait;
use OwenIt\Auditing\Contracts\Auditable;
class KycFormField extends BaseModel implements Auditable
{
    use  AuditableTrait;

    protected $fillable = [
        'sort_order',
        'section_id',
        'field_key',
        'label',
        'input_type',
        'is_required',
        'validation_rules',
        'options',
        'example',



        'created_type',
        'created_id',
        'updated_type',
        'updated_id',
        'deleted_type',
        'deleted_id',

        //here AuditColumns 
    ];

    protected $hidden = [
        //
    ];

    protected $casts = [
        'is_required' => 'boolean',
        'input_type' => KycFormFieldsInputType::class,
    ];

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                Start of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */

    public function section()
    {
        return $this->belongsTo(KycFormSection::class);
    }

    /* =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#=
                End of RELATIONSHIPS
     =#=#=#=#=#=#=#=#=#=#==#=#=#=#= =#=#=#=#=#=#=#=#=#=#==#=#=#=#= */







    /*
    |--------------------------------------------------------------------------
    | Query Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('label', 'like', "%{$search}%")
                ->orWhere('example', 'like', "%{$search}%");
        });
    }
    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['section_id'] ?? null, fn($q, $section_id) => $q->where('section_id', $section_id));
        $query->when($filters['search'] ?? null, fn($q, $search) => $q->search($search));

        return $query;
    }


    /*
    |--------------------------------------------------------------------------
    | Accessors
    |--------------------------------------------------------------------------
    */

    public function getInputTypeLabelAttribute(): string
    {
        return $this->input_type->label();
    }
    public function getInputTypeColorAttribute(): string
    {
        return $this->input_type->color();
    }


    /*
    |--------------------------------------------------------------------------
    | Methods
    |--------------------------------------------------------------------------
    */


    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->appends = array_merge(parent::getAppends(), [
            'input_type_label',
            'input_type_color',
        ]);
    }
}
