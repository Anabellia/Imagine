<div>
    

<p>Hello from livewire editimg bladea</p>

                


        <div>
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
        </div>    

        <section>
            
            <input type="file" id="image" wire:change="$emit('fileChoosen')">
                @if($image)
                <img src="{{$image}}" alt="" width="200" >
                @endif
        </section>

        <form wire:submit.prevent="addComment"  class="container">   
            <div class="row justify-content-md-center">
                @error('newComment') <h4> <span class="error text-danger font-weight-normal" >{{ $message }}</span> </h4> @enderror
                
                <div>
                    <input wire:model.debounce.500ms="newComment" type="text" class="form-control" placeholder="Comment" >
                </div>
                <div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
                    
                
            </div>
        </form>
        <br>

    @foreach($comments as $comment)    
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="card" style="width: 18rem;">
                    <div class="card-body ">
                        <!-- ovaj dflex ce da rasporedi ova dole dva diva jedan levo drugi desno -->
                        <div class="d-flex">
                            <div>
                                <h3 class="card-title">{{$comment->creator->name}}</h3>
                            </div>
                            <div class="ml-auto">
                            <!-- Iconica x -->            
                                    <!-- Ovaj comment id kako je se dobio je 
                                    interesantan ako hoces da capis nesto iz bledea mora biti double bracess
                                    A ovaj fas fa-times je iconica iz fontawesome!!!
                                    -->                                            
                                <i wire:click="remove({{$comment->id}})"                                         
                                        class="fas fa-times" 
                                        onmouseover="this.style.color='red'" 
                                        onmouseout="this.style.color='grey'" 
                                        style="cursor: pointer; color: grey" ></i>                                                        
                            <!--kraj za Iconica x -->
                            </div>
                        </div>

                        <h6 class="card-subtitle mb-2 text-muted">{{$comment->created_at->diffForHumans()}}</h6>                    
                        <p class="card-text">{{$comment->body}}</p>  
                        @if($comment->image)
                        
                        <img src="{{$comment->imagePath}}" alt="" width="200" >          
                        @endif        
                    </div>
                </div>
            </div>
        </div>
        <br>
    @endforeach

    {{ $comments->links() }}


</div>

