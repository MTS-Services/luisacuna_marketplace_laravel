<?php

namespace App\Livewire\Backend\Admin\Components\Language;

use Livewire\Component;
use App\Enums\LanguageStatus;
use Livewire\WithFileUploads;
use App\Enums\LanguageDirection;
use App\DTOs\Language\CreateLanguageDTO;
use App\Traits\Livewire\WithNotification;
use App\Services\Language\LanguageService;
use App\Livewire\Forms\Backend\Admin\Language\LanguageForm;

class Create extends Component
{
   use WithNotification, WithFileUploads;

   public LanguageForm $form;
   protected LanguageService $languageService;

   public function boot(LanguageService $languageService)
   {
       $this->languageService = $languageService;
   }
   public function mount()
   {
       $this->form->status = LanguageStatus::ACTIVE->value;
       $this->form->direction = LanguageDirection::LTR->value;
   }
    public function render()
    {
        return view('livewire.backend.admin.components.language.create', [
            'statuses' => LanguageStatus::options(),
            'dirations' => LanguageDirection::options(),
        ]);
    }
    public function save()
    {
        $this->form->validate();
        try {
            $dto = CreateLanguageDTO::fromArray([
                'locale' => $this->form->locale,
                'name' => $this->form->name,
                'native_name' => $this->form->native_name,
                'status' => $this->form->status,
                'is_active' => $this->form->is_active,
                'default_direction' => $this->form->direction,
            ]);

            $language = $this->languageService->CreateLanguage($dto);

            $this->dispatch('Language Created');
            $this->success('Language created successfully');
            return $this->redirect(route('admin.language.index'), navigate: true);
        } catch (\Exception $e) {
            $this->error('Failed to create language: ' . $e->getMessage());
        }
    }
}
