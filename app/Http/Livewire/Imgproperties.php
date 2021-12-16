<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ImageProperties;

class Imgproperties extends Component
{
    //ovde slusam kad je activ ono levo da mogu da grab id od toga
    //btw ovo je drugi listener za istu stvar
    public $active;

    protected $listeners = [
        /*
         * ako imas isto ime funkcije i key value 
         * 'imgPropertieSelected' => 'imgPropertieSelected',
         *  mozes i ovako:
         */
        'imgPropertieSelected',
    ];

    public function imgPropertieSelected($imgPropertiesId){

        $this->active = $imgPropertiesId;

    }

    public function render()
    {
        return view('livewire.imgproperties', ['imgproperties' => ImageProperties::all(),]);
    }
}
