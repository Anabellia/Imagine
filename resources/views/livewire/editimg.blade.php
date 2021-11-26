<div>
    

<p>Hello from livewire bladea</p>

    

        <div class="container">        
            <div class="row justify-content-md-center">
            <input wire:model="newComment" type="text" class="form-control" placeholder="Comment" >
                <button wire:click="addComment" type="button" class="btn btn-primary">Primary</button>
            </div>
        </div>
        <br>
        <br>

    @foreach($comments as $comment)
        <div class="container">
            <div class="row justify-content-md-center">
                <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <h3 class="card-title">{{$comment['creator']}}</h3>
                        <h6 class="card-subtitle mb-2 text-muted">{{$comment['created_at']}}</h6>                    
                        <p class="card-text">{{$comment['body']}}</p>                    
                    </div>
                </div>
            </div>
        </div>
    @endforeach


</div>
