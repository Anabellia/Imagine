<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;
use App\Models\ImageProperties;

class ImgFileUploader extends Component
{
    use WithFileUploads;

    //single pic upload
    public $photo;
    //stored image u db
    public $imageUDb;

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
        

        /* Validate da je photografija manja od 1mb - 
        ovo sam morao heavi da potkrepim u blade posto je
         ova validacija crap ali ostavljam je */
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
        ]);          
        
        /* Ako nemamo img return null */
        if(!$this->photo){
            return null;
        } 

        /* Ako imamo image: */

        

        /* grab user id */
        $user   = Auth::user();
        /* grab temp img path */
        $path = $this->photo->path();
        /* grab extension from path */
        $extension = pathinfo($path, PATHINFO_EXTENSION);
        /* generate rand name */
        $name = Str::random();

        //u storage put novu pics u folder photos / user id / randomName.extension 
        $fuck = $this->photo->storeAs('photos' . '/' .$user->id . '/' , $name . '.' .  $extension);

        /* ------------------------------------------ */
        /* Put it in a db for first */
        $this->imageUDb = ImageProperties::create(
            [
                'image_name' => $name, 
                //'user_id' => 1,
                'user_id' => auth()->user()->id,
                'path' => $fuck,
                'extension' => $extension,
            ]);
        /* ------------------------------------------ */
        $this->imageUDb = $this->imageUDb->path;
        // dd($this->imageUDb);               
        
            //dd($fuck);
        /* clear photo var */
        $this->photo = "";
        session()->flash('mess', 'uploadovanje zavrseno!');

        /*  */
    }

    public function mount(){
        $loadPic = ImageProperties::where('user_id', (auth()->user()->id))->latest()->first();   
        $this->imageUDb = $loadPic->path;  
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
