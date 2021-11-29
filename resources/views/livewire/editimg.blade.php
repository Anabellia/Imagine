<div>
    

<p>Hello from livewire bladea</p>

    

        <form wire:submit.prevent="addComment"  class="container">   
            <div class="row justify-content-md-center">
                @error('newComment') <h4> <span class="error text-danger font-weight-normal" >{{ $message }}</span> </h4> @enderror
                <input wire:model.lazy="newComment" type="text" class="form-control" placeholder="Comment" >
                    
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>
        <br>
        <br>

    @foreach($comments as $comment)
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title">{{$comment->creator->name}}</h3>
                        <h6 class="card-subtitle mb-2 text-muted">{{$comment->created_at->diffForHumans()}}</h6>                    
                        <p class="card-text">{{$comment->body}}</p>                    
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
