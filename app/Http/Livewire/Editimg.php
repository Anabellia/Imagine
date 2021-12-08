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


class Editimg extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $newComment;

    use WithFileUploads;
    public $image;

    protected $listeners = ['fileUpload' => 'handleFileUpload'];

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
                'image' => $image
            ]);

        //to clear text input
        $this->newComment = "";
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
        $comment->delete();
        /* Ovde resetujemo commentse da bi izbacili upravo obrisanog */
        //$this->comments = $this->comments->except($commentID);
        //dd($comment);
        $this->resetPage();
        session()->flash('message', 'comment deleted successfully :)');

    }

    public function storeImage(){

        if(!$this->image){
            return null;
        } 

        $img = ImageManagerStatic::make($this->image)->encode('jpg');
        Storage::disk('public')->put('image.jpg', $img);

    }

    public function render()
    {
        return view('livewire.editimg', [
            'comments' => Comment::latest()->simplePaginate(2),
        ]);
    }
}
