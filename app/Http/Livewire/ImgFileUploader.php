<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImgFileUploader extends Component
{
    use WithFileUploads;

    public $photo;

    public function updatedPhoto()
    {
        //IMAS VALIDACIJU I NA BLADE FILEU PRE TEMP UPLOADA!!
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);
    }

    public function savePhoto()
    {
        $this->validate([
            'photo' => 'image|max:1024', // 2MB Max
        ]);
        
        //u storage ce put novu pics u foldes photos
        $this->photo->store('photos');
    }


    public function render()
    {
        return view('livewire.img-file-uploader');
    }
}
