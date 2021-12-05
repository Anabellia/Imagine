<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;
use Livewire\WithPagination;


class Editimg extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    public $newComment;
    //public $comments;

    

    /* public function mount(){

        $initialComments = Comment::latest()->get();
        $this->comments = $initialComments;
        
    } */

    public function updated($newComment)
    {
        $this->validateOnly($newComment, ['newComment' => 'required|max:120']);
    }

    public function addComment(){

        $this->validate(['newComment' => 'required|max:120']);

        $createdComment = Comment::create(
            [
                'body' => $this->newComment, 
                'user_id' => 1
            ]);

        //$this->comments->prepend($createdComment);

        //to clear text input
        $this->newComment = "";

        session()->flash('message', 'comment added successfully :)');

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
        session()->flash('message', 'comment deleted successfully :)');
    }

    public function render()
    {
        return view('livewire.editimg', [
            'comments' => Comment::paginate(3),
        ]);
    }
}
