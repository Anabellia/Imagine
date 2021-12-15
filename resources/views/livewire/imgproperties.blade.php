<div>

    <p>hello from livewire imgproperties bledea</p>

    @foreach($imgproperties as $imgpropertie)    
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="card" style="width: 18rem;">
                    <div class="card-body ">
                        <!-- ovaj dflex ce da rasporedi ova dole dva diva jedan levo drugi desno -->
                        <div class="d-flex">
                            
                            <div wire:click="$emit('imgPropertieSelected', {{$imgpropertie->id}})" class="ml-auto">
                                <p class="card-text">{{$imgpropertie->question}}</p> 
                            </div>
                        </div>

                        
                         
                             
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endforeach


    
</div>
