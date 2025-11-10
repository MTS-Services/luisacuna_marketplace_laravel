<?php

    namespace App\Livewire\Backend\Admin\AdminManagement\Role;

    use App\Models\Role;
    use Livewire\Component;

    class View extends Component
    {

        public Role $data;
        public function mount(Role $data): void
        {
            $this->data = $data;
        }
        public function render()
        {

            return view('livewire.backend.admin.admin-management.role.view');
        }

    }
