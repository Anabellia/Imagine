<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Comment;


class Editimg extends Component
{

    public $newComment;
    public $comments;

    protected $rules = [
        'newComment' => 'required|max:6',
        
    ];

    public function mount(){

        $initialComments = Comment::latest()->get();
        $this->comments = $initialComments;
        
    }

    public function updated($field)
    {
        $this->validateOnly($field, ['newComment' => 'required|max:25']);
    }

    public function addComment(){

        

        $createdComment = Comment::create(
            [
                'body' => $this->newComment, 
                'user_id' => 1
            ]);

        $this->comments->prepend($createdComment);

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
