<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;
use Livewire\WithPagination;
use Auth;
use Livewire\WithFileUploads;
use Intervention\Image\ImageManagerStatic;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class Editimg extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $newComment;

    use WithFileUploads;
    public $image;

    public $imagePropertiesId = 1;

    protected $listeners = [
        
            'fileUpload' => 'handleFileUpload',

            //ako imas isto ime funkcije i key value 
            //'imgPropertieSelected' => 'imgPropertieSelected',
            //mozes i ovako:
            'imgPropertieSelected',


        ];

    //ovaj imgPropertieId capam from bledea id od selected properties
    public function imgPropertieSelected($imgPropertiesId){

        $this->imagePropertiesId = $imgPropertiesId;

    }

    public function handleFileUpload($imageData){
        $this->image = $imageData;
    }
    
    public function updated($newComment)
    {
        $this->validateOnly($newComment, ['newComment' => 'required|max:120']);
    }

    public function addComment(){        

        if(Auth::user()){

        $this->validate(['newComment' => 'required|max:120']);

        $image = $this->storeImage();

        $createdComment = Comment::create(
            [
                'body' => $this->newComment, 
                //'user_id' => 1,
                'user_id' => auth()->user()->id,
                'image' => $image,
                'image_properties_id' => $this->imagePropertiesId,
            ]);

        //to clear text input
        $this->newComment = "";
        $this->image = "";
        $this->resetPage();

        session()->flash('message', 'comment added successfully :)');
        }
        else {
            session()->flash('message', 'you need to be loged in to make comments');
        }
        

        //Ovo je primer kako mozes da pass array o nekom varu
        /* $this->comments[] = [            
            'body' => 'Drugi body txt koji treba biti jooooos malo duzi jel',
            'created_at' => '1 min ago',
            'creator' => 'Mariska',
        ]; */
    }

    //ovaj commentID to je ono sto dobijamo iz bledea i nemoramo ga definisati
    public function remove($commentID)
    {
        /* ovde nadjemo commentar iz db po onom sto nam je klick na x u bladeu poslao id od tog commentara */
        $comment = Comment::find($commentID);
        Storage::disk('public')->delete($comment->image);
        $comment->delete();
        /* Ovde resetujemo commentse da bi izbacili upravo obrisanog */
        //$this->comments = $this->comments->except($commentID);
        //dd($comment);
        $this->resetPage();
        session()->flash('message', 'comment deleted successfully :)');

    }

    public function storeImage(){

        /* Ako nemamo img return null */
        if(!$this->image){
            return null;
        } 

        /* Ako imamo image: */
        /* encoded to jpg */
        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        /* Give it a rand name */
        $name = Str::random() . '.jpg';
        /* Store it into public dir */
        Storage::disk('public')->put($name, $img);
        return $name;

    }

    public function render()
    {
        return view('livewire.editimg', [
            'comments' => Comment::where('image_properties_id', $this->imagePropertiesId)->latest()->simplePaginate(2),
        ]);
    }
}
