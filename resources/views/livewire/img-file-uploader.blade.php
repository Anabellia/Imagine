<div>
    <p>Hello from img-file-uploader bledea</p>

    <hr>

    <div>
        <form wire:submit.prevent="savePhoto">
            @error('photo')
                <h4> <span class="error text-danger font-weight-normal" >{{ $message }}</span> </h4> 
            @enderror
            <!-- 100mb = 100000000 ; 1mb=1000000 -->
            <input type="file" 
                onchange="if(this.files[0].size > '1000000'){ 
                    event.stopImmediatePropagation();                    
                    alert('File uploads cannot be larger than 1MB.');
                    this.form.reset();
                }" 
                wire:model="photo" />
    </div>
    <br>

    <button type="submit">Save Photo</button>
    </form>
        
    
    


</div>
