<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

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
        $user   = Auth::user();
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);

          
        
        $path = $this->photo->path();
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        /* dd($extension); */

        /* Ako nemamo img return null */
        if(!$this->photo){
            return null;
        } 
        /* Ako imamo image: */
        
        $name = Str::random();
                        
        //u storage ce put novu pics u folder photos / user id
        $this->photo->storeAs('photos' . '/' .$user->id . '/' , $name . '.' .  $extension);
            
        $this->photo = "";
        session()->flash('mess', 'uploadovanje zavrseno!');

        dd($name . '.' .  $extension);
    }

    public function removePhoto(){
        $this->reset();
    }

    public function savePhotos()
    {
        $user   = Auth::user();
        $this->validate([
            'photos.*' => 'image|max:1024', // 1MB Max
        ]);
 
        foreach ($this->photos as $photo) {
            $photo->store('photos' . '/' .$user->id . '/' );
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
