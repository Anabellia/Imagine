<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\ImageProperties;

class Imgproperties extends Component
{
    public function render()
    {
        return view('livewire.imgproperties', ['imgproperties' => ImageProperties::all(),]);
    }
}
