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

        $initialComments = Comment::all();
        $this->comments = $initialComments;
        
    }

    public function addComment(){

        if($this->newComment == ''){
            return;
        }

        array_unshift($this->comments, [            
            'body' => $this->newComment,
            'created_at' => Carbon::now()->diffForHumans(),
            'creator' => 'Mariska',
        ]);

        //to clear text input
        $this->newComment = "";

        /* $this->comments[] = [            
            'body' => 'Drugi body txt koji treba biti jooooos malo duzi jel',
            'created_at' => '1 min ago',
            'creator' => 'Mariska',
        ]; */
    }

    public function render()
    {
        return view('livewire.editimg');
    }
}
