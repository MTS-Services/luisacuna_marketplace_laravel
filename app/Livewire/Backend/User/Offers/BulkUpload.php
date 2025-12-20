<?php

namespace App\Livewire\Backend\User\Offers;

use Livewire\Component;
use Livewire\WithFileUploads;

class BulkUpload extends Component
{
    use WithFileUploads;

    public $currentStep = 1;
    public $uploadMethod = ''; // 'web' or 'csv'
    public $gameId;
    public $regionId;
    public $serverId;
    public $file;


    public function selectUploadMethod($method)
    {
        $this->uploadMethod = $method;
        
        if ($method === 'csv') {
            $this->currentStep = 4;
        } else {
            $this->currentStep = 2;
        }
    }

    public function selectGame()
    {
       

        $this->currentStep = 3;
    }

    public function selectServerAndRegion()
    {
        

        // Ei khane apnar logic - offer create kora etc
        session()->flash('success', 'Offers created successfully!');
        
        // Reset or redirect
        $this->reset();
    }

    public function uploadFile()
    {
      

        
        session()->flash('success', 'File uploaded successfully!');

        $this->reset();
    }

    public function back()
    {
        if ($this->currentStep > 1) {
            $this->currentStep--;
            
            if ($this->currentStep === 1) {
                $this->uploadMethod = '';
            }
        }
    }

    public function render()
    {
        return view('livewire.backend.user.offers.bulk-upload');
    }
}