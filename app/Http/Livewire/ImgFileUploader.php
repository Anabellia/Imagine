<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class ImgFileUploader extends Component
{
    use WithFileUploads;

    //single pic upload
    public $photo;

    //za multiple uploads
    public $photos = [];

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

        $this->photo = "";
        session()->flash('mess', 'uploadovanje zavrseno!');
    }

    public function removePhoto(){
        $this->reset();
    }

    public function savePhotos()
    {
        $this->validate([
            'photos.*' => 'image|max:1024', // 1MB Max
        ]);
 
        foreach ($this->photos as $photo) {
            $photo->store('photos');
        }

        $this->photos = [];
        session()->flash('message', 'uploadovanje zavrseno!');
    }

    public function remove($index){
        array_splice($this->photos, $index, 1);
    }


    public function render()
    {
        return view('livewire.img-file-uploader');
    }
}
