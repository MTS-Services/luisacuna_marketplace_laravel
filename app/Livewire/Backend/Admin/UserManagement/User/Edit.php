<?php

namespace App\Livewire\Backend\Admin\UserManagement\User;

use App\Models\User;
use App\Models\Country;
use Livewire\Component;

use App\DTOs\User\UpdateUserDTO;
use App\Enums\UserAccountStatus;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;
use App\Traits\Livewire\WithNotification;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use App\Livewire\Forms\Backend\Admin\UserManagement\UserForm;
use App\Services\CurrencyService;
use App\Services\LanguageService;

class Edit extends Component
{

    use WithFileUploads, WithNotification;

    public $countries;
    public $languases;
    public UserForm $form;
    public User $data;
    public $dataId;
    public $existingFile;


    public bool $showReasonField = false;



    protected UserService $service;

    protected CurrencyService $currencyService;
    protected LanguageService $languageService;
    public function boot(UserService $service, LanguageService $languageService, CurrencyService $currencyService)
    {
        $this->service = $service;
        $this->languageService = $languageService;
        $this->currencyService = $currencyService;
    }
    public function mount(User $data): void
    {
        $this->data = $data;
        $this->dataId = $data->id;

        $this->form->setData($data);
        $this->existingFile = $this->data->avatar;
        // $this->form->date_of_birth->format('Y-m-d');

        $this->languases();
        $this->countries();
    }


    public function updatedFormAccountStatus()
    {
        $this->showReasonField = $this->form->shouldShowReasonField();
    }

    public function languases(): void
    {

        $this->languases = $this->languageService->getAllDatas();
    }

    public function countries(): void
    {

        $this->countries = Country::orderBy('name', 'asc')->get();
    }

    public function render()
    {
        return view('livewire.backend.admin.user-management.user.edit', [
            'statuses' => UserAccountStatus::options(),
            'countries' => $this->countries,
            'languages' => $this->languases,
            'currencies' => $this->currencyService->getAllDatas(),
        ]);
    }

    public function save()
    {


        $data =   $this->form->validate();
        //  dd($data);

        try {

            $data['updater_id'] = admin()->id;

            $this->service->updateData($this->data->id, $data);

            Log::info('Data updated successfully', ['data_id' => $this->data->id]);

            $this->success('Data updated successfully');

            return redirect()->route('admin.um.user.index');
        } catch (\Exception $e) {
            Log::error('Failed to update User', [
                'user_id' => $this->dataId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->error('Failed to update User: ' . $e->getMessage());
        }
    }
    // public function removeAvatar(): void
    // {
    //     Log::info('removeAvatar called', ['user_id' => $this->userId]);
    //     $this->form->remove_avatar = true;
    //     $this->existingFile = null;
    //     $this->form->avatar = null;
    // }

    public function cancel(): void
    {
        $this->redirect(route('admin.um.user.index'), navigate: true);
    }

    public function resetForm()
    {
        $this->form->reset();
        $this->form->setData($this->data);

        $this->showReasonField = false;
        // Reset existing files display
        $this->existingFile = $this->data->avatar;
        $this->dispatch('file-input-reset');
    }
}
