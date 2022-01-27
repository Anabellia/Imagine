<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProperties extends Model
{
    use HasFactory;

    

    protected $fillable = [
        'user_id',
        'image_name',
        'path',
        'extension',
        'image_editing_name',
        'edit_step_number',
        'action_made',
        'edit_id',
    ];
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
