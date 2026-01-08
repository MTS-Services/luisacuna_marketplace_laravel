<?php

namespace App\Livewire;

use App\Models\CloudinaryFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class CloudinaryUpload extends Component
{
    use WithFileUploads;
    
    public $photo;

    public function render()
    {
        $photos = CloudinaryFile::all();
        return view('livewire.cloudinary-upload', [
            'photos' => $photos
        ]);
    }
}
