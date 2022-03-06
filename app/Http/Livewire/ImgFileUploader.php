<?php

namespace App\Http\Livewire;

use Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\ImageProperties;
// import the Intervention Image Manager Class
use Intervention\Image\ImageManagerStatic;

class ImgFileUploader extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    use WithFileUploads;

    /* 'image_name' => 'array',
        'image_editing_name' => 'array',
        'path' => 'array',
        'extension' => 'array',
        'edit_step_number' => 'array',        
        'action_made' => 'array',        
        'action_made_timestamp' => 'array',  */

    /* ovaj ce da bude da pratim koji sam korak pa da mogu da pullam iz array */
    public $ed_st_no; //array

    //Name of single photo editing design
    public $newImgEditName; //array
    public $title;
    //single pic upload
    public $photo;
    //stored image u db
    public $imageUDb;
    // za prikaz img u blade
    public $iUDbPath;
    
    public $ext;
    public $width;
    public $height;

    //za multiple uploads
    public $photos = [];    

    protected $listeners = [        
        
        /*
         * 'fileUpload' => 'handleFileUpload',
         * ako imas isto ime funkcije i key value 
         * 'imgPropertieSelected' => 'imgPropertieSelected',
         *  mozes i ovako:
         */
        'imgCropped',
    ];

    public function imgCropped($cropedimageData){

        /* Ako nemamo cropp return null */
        if(!$cropedimageData){
            return null;
        }        
        /* grab user id */
        $user   = Auth::user();
        /* Give it a rand name */
        $name = Str::random();
        $folderPath = public_path('storage/photos/' . $user->id . '/');
        $image_parts = explode(";base64,", $cropedimageData);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);

        $myLastElement = end($this->imageUDb->extension);        
        dd($myLastElement);


        $imageName = $name . '.' . end($this->imageUDb->extension);
        $imageFullPath = $folderPath.$imageName;
        file_put_contents($imageFullPath, $image_base64);

        /* dd($this->imageUDb->edit_step_number); */
        /* ------------------------------------------ */
        /* Put it in a db for first */
        /* relative path: */
        $storePath = 'photos/' . $user->id . '/' . $imageName;
        /* old extension samo stavljam u vari */
        $extension = $this->imageUDb->extension;

        /* $doh = $this->imageUDb->edit_step_number + 1; */
        /* dd($doh); */
        $this->imageUDb = ImageProperties::create(
            [
                'image_name' => $name,
                'user_id' => auth()->user()->id,
                'path' => $storePath,
                'extension' => $extension,
                'image_editing_name' => $this->imageUDb->image_editing_name, //isto
                'edit_step_number' => $this->imageUDb->edit_step_number + 1, //+1 da pratim korake
                'action_made' => 'cropped',
                'edit_id' => $this->imageUDb->edit_id,
                
            ]);

            
        /* ------------------------------------------ */

        $this->iUDbPath = 'storage/' . $this->imageUDb->path;
        
        
        $interImage = ImageManagerStatic::make($this->iUDbPath);
        $this->ext = $interImage->extension;
        $this->width = $interImage->width();
        $this->height = $interImage->height();
        $exif = ImageManagerStatic::make($this->iUDbPath)->exif();
        //dd($exif);      
        //dd($pics->width());
        /* $this->photo = ""; */
        session()->flash('cropMess', 'Image successfully cropped!');
        $this->emit('cropMess_remove');
    }

    public function updatedPhoto()
    {
        //dd('sdfsdhfbd');
        //IMAS VALIDACIJU I NA BLADE FILEU PRE TEMP UPLOADA!!
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
            
        ]);

        $this->modalUploadingFire();
    }

    public function savePhoto()
    {      
        /* Validate da je photografija manja od 1mb - 
        ovo sam morao heavi da potkrepim u blade posto je
         ova validacija crap ali ostavljam je */
        
        $this->validate([
            'photo' => 'image|max:1024', // 1MB Max
            //'newImgEditName' => 'unique:image_properties,image_editing_name',
        ]);

        /* Ako nemamo img return null */
        if(!$this->photo){
            return null;
        } 

        //ovo prvo da pratimo na kom koraku smo u array
        $this->ed_st_no[0] = 0;
        $korak = $this->ed_st_no[0];
        /* Ako imamo image: */
        //dd($this->newImgEditName);
        /* grab user id */
        $user   = Auth::user();
        /* grab temp img path */
        $path = $this->photo->path();
        /* grab extension from path */
        $extension[$korak] = pathinfo($path, PATHINFO_EXTENSION);
        /* generate rand name */
        $name[$korak] = Str::random();

        if(!$this->newImgEditName){
            $this->newImgEditName = 'new project';
        }
        $nIEN[$korak] = $this->newImgEditName;
        
        //u storage put novu pics u folder photos / user id / randomName.extension 
        $sPath = $this->photo->storeAs('photos' . '/' .$user->id , $name[$korak] . '.' .  $extension[$korak]);
        
        $storePath[$korak] = $sPath;
        //dd($storePath);
        
        $action[$korak] = 'created';
        $tmstmp[$korak] = date('Y-m-d H:i:s');
        
        //dd($name . $nIEN . $storePath);
        /* ------------------------------------------ */
        /* Put it in a db for first time*/
        $this->imageUDb = ImageProperties::create(
            [
                'image_name' => $name, 
                'image_editing_name' => $nIEN,
                //'user_id' => 1,
                'user_id' => auth()->user()->id,
                'path' => $storePath, //array
                'extension' => $extension,                
                'edit_step_number' => [$korak],
                'action_made' => $action,                
                'action_made_timestamp' => $tmstmp,
                'unique_edit_id' => Str::random(),
                
            ]);
            
        /* ------------------------------------------ */
        //dd($this->imageUDb);
        $this->iUDbPath = 'storage/' . $this->imageUDb->path[$korak];

        //$path = storage_path();
        //dd($this->imageUDb->image_editing_name[$korak]);               
        $this->title = $this->imageUDb->image_editing_name[$korak];
            //dd($fuck);
        /* clear photo var */
        // \storage\photos\34\LdLDLncOq9SCZtaS.jpg
        $interImage = ImageManagerStatic::make($this->iUDbPath);
        //$interImage = ImageManagerStatic::make($this->iUDbPath);
        //dd('biucc');
        $this->ext = $interImage->extension;
        $this->width = $interImage->width();
        $this->height = $interImage->height();
        $exif = ImageManagerStatic::make($this->iUDbPath)->exif();
        //dd($exif);
        
        /* 'Image extension: ' $interImage->extension . 
            ' mime type: ' . $interImage->mime . 
            ' width: ' . $interImage->width() . 
            ' height: ' . $interImage->height()
         */
        //dd($pics->width());
        $this->photo = "";
        $this->newImgEditName = "";
        session()->flash('uploadMess', 'Image successfully uploaded!');
        $this->emit('uploadMess_remove');
        $this->dispatchBrowserEvent('hideModal-uploadingPhoto');
    }

    public function mount(){
        /* dd('Hey'); */
        $this->imageUDb = ImageProperties::where('user_id', (auth()->user()->id))->latest()->first();   
        if($this->imageUDb){
            /* dd($loadPic->path); */
            
            $this->iUDbPath = 'storage/' . $this->imageUDb->path;
            $this->title = $this->imageUDb->image_editing_name;

            $interImage = ImageManagerStatic::make($this->iUDbPath);
            $this->ext = $interImage->extension;
            $this->width = $interImage->width();
            $this->height = $interImage->height();
            $exif = ImageManagerStatic::make($this->iUDbPath)->exif();
        }
         
    }

    /* Reset formu da moze se ponovo druga upload (za temp photo kad uploading)*/
    public function removePhoto(){
        $this->reset();
    }

    /* da se sjebe sve na pocetak solo image editing */
    public function discharge(){
        /* Get pats od images da bi ih delete */
        $pathsForDeleting = ImageProperties::where('user_id', (auth()->user()->id))->where('edit_id', $this->imageUDb->edit_id)->get();  
        
        foreach($pathsForDeleting as $pathForDelete){
            /* dd($pathForDelete->path); */
            Storage::delete($pathForDelete->path);
        }
        ImageProperties::where('user_id', (auth()->user()->id))->where('edit_id', $this->imageUDb->edit_id)->delete();  
        $this->imageUDb = ""; 
        $this->iUDbPath = "";
        $this->title = "";
        $this->render();
        
        
        /* dd($test); */
    }

    //ovaj commentID to je ono sto dobijamo iz bledea i nemoramo ga definisati.
    //Removing one action from levo history
    public function removeFromHistory($editID){            
        $forHistoryDel = ImageProperties::where('id', $editID)->first();
        //dd($forHistoryDel->path);
        Storage::delete($forHistoryDel->path);        
        $forHistoryDel->delete();        
        //dd($comment);
        $this->reset();
        $this->mount();
        session()->flash('delFromHis', 'edit step deleted successfully :)');
        $this->emit('delFromHis_remove');
    }

    public function modalDiscardFire(){
        $this->dispatchBrowserEvent('show-discardAll');
    }

    public function modalUploadingFire(){        
            $this->dispatchBrowserEvent('show-uploadingPhoto');
        }

    /* Za multiple photos */
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

    /* Removing pojedine photose kad je multiple upload u pitanju */
    public function remove($index){
        array_splice($this->photos, $index, 1);
    }


    public function render()
    {
        return view('livewire.img-file-uploader', [
            'edits' => ImageProperties::where('user_id', (auth()->user()->id))->latest()->simplePaginate(4),
        ]);
    }
    /* {
        return view('livewire.img-file-uploader');
    } */
}
