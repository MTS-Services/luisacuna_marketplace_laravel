<?php

namespace App\Livewire\Backend\Admin\Components\AdminManagement\Admin;

use App\Models\Admin;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Index extends Component
{

    #[Validate('int', 'min:1')]
    public $search = '';

    public function render()
    {
        $admin = Admin::all();
        $columns = [
            ['key' => 'name', 'label' => 'Name', 'width' => '20%'],
            ['key' => 'email', 'label' => 'Email', 'width' => '25%'],
            [
                'key' => 'status',
                'label' => 'Status',
                'width' => '10%',
                'format' => function ($admin) {
                    return '<span class="badge badge-soft ' . $admin->status_color . '">' . ucfirst($admin->status) . '</span>';
                }
            ],
            [
                'key' => 'created_at',
                'label' => 'Created',
                'width' => '15%',
                'format' => function ($admin) {
                    return $admin->created_at_formatted;
                }
            ],

            [
                'key' => 'created_by',
                'label' => 'Created By',
                'width' => '15%',
                'format' => function ($admin) {
                    return $admin->createdBy?->name ?? 'System';
                }
            ]
        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'method' => 'openDetailsModal'],
            ['key' => 'id', 'label' => 'Edit', 'method' => 'openEditModal'],
            ['key' => 'id', 'label' => 'Delete', 'method' => 'openForceDeleteModal'],
            
        ];
        return view('livewire.backend.admin.components.admin-management.admin.index',[
            'admins' => $admin,
            'columns' => $columns,
            'actions' => $actions
        ]);
    }
}
