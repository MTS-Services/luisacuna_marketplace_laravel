<?php

namespace App\Livewire\Backend\Admin\EmailTemplate;

use Livewire\Component;
use Livewire\WithPagination;
use App\Services\EmailTemplateService;

class Index extends Component
{
    use WithPagination;
   public $selectedIds = [];
    protected EmailTemplateService $emailTemplate;
    public function boot(EmailTemplateService $emailTemplate){
        $this->emailTemplate = $emailTemplate;
    }

    public function render()
    {
        $datas = $this->emailTemplate->paginateDatas(10);
    
        $columns = [



            [
                'key' => 'key',
                'label' => 'Key',
            ],


            [
                'key' => 'name',
                'label' => 'Name',
            ],

        ];

        $actions = [
            ['key' => 'id', 'label' => 'View', 'route' => 'admin.email-template.show', 'encrypt' => true],
            ['key' => 'id', 'label' => 'Edit', 'route' => 'admin.email-template.edit', 'encrypt' => true],
        ];

        return view('livewire.backend.admin.email-template.index',[
            'datas' => $datas,
            'columns' => $columns,
            'actions' => $actions,
            'bulkActions' => [],
            'bulkAction' => [],
            'statuses' => [],
        ]);
    }
}
