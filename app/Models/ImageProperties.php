<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImageProperties extends Model
{
    use HasFactory;
    
    //sad cu dodam ovde ovo da mogu json u i iz db
    protected $casts = [
        'image_name' => 'array',
        'image_editing_name' => 'array',
        'path' => 'array',
        'extension' => 'array',
        'edit_step_number' => 'array',        
        'action_made' => 'array',        
        'action_made_timestamp' => 'array',        
    ];

    protected $fillable = [
        'user_id',  
        'image_name',
        'image_editing_name',
        'path',
        'extension',
        'edit_step_number',        
        'action_made',        
        'action_made_timestamp',
        
    ];
    
    public function comments(){
        return $this->hasMany(Comment::class);
    }
}
