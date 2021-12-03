<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;


class Editimg extends Component
{

    public $newComment;
    public $comments;

    

    public function mount(){

        $initialComments = Comment::latest()->get();
        $this->comments = $initialComments;
        
    }

    public function updated($newComment)
    {
        $this->validateOnly($newComment, ['newComment' => 'required|max:120']);
    }

    public function addComment(){

        $this->validate(['newComment' => 'required|max:120']);

        $createdComment = Comment::create(
            [
                'body' => $this->newComment, 
                //'user_id' => 1,
                'user_id' => auth()->user()->id
            ]);

        $this->comments->prepend($createdComment);

        //to clear text input
        $this->newComment = "";

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
        $this->comments = $this->comments->except($commentID);
        //dd($comment);
    }

    public function render()
    {
        return view('livewire.editimg');
    }
}
