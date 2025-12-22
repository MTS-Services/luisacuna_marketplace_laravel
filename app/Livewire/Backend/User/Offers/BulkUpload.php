<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use Livewire\WithFileUploads;

class BulkUpload extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $uploadMethod = '';
    public $gameId;
    public $regionId;
    public $serverId;
    public $file;


    public function selectUploadMethod($method)
    {
        $this->uploadMethod = $method;
        $this->currentStep = 2;
    }



    public function selectGame()
    {
        $this->currentStep = 3;
    }

    public function selectServerAndRegion()
    {
        $this->currentStep = 4;
    }


    public function uploadFile()
    {
        session()->flash('success', 'Process completed!');
    }

    public function back()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
        }
    }


    public function render()
    {
        return view('livewire.backend.user.offers.bulk-upload');
    }
}
