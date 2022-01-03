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
    ];
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
