<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Carbon\Carbon;

class Editimg extends Component
{

    public $newComment;
    public $comments = [

            [
                'body' => 'Prvi body txt koji treba bit malo duzi jel',
                'created_at' => '3 min ago',
                'creator' => 'Keljmenc',
            ]
        ];

    public function addComment(){

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
