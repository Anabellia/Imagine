<div>
    <p>Hello from img-file-uploader bledea</p>

    

    <hr>
    <!-- =============================================================================== -->
    <!-- container za singe image: levo mislim properties of image a desno sam image za obradu -->
    <!-- =============================================================================== -->
    <div class="container">
        <div class="row">
        <div class="col-1"></div>

        <div class="col-3">
            <h3>Singe photo uploading</h3>            
            <form wire:submit.prevent="savePhoto">
                        @error('photo')
                            <h4> 
                                <span class="error text-danger font-weight-normal" >{{ $message }}</span> 
                            </h4> 
                        @enderror

                        @error('newImgEditName')
                            <h4> 
                                <span class="error text-danger font-weight-normal" >{{ $message }}</span> 
                            </h4> 
                        @enderror

                        <!-- Success upload message -->
                        <div>
                            @if (session()->has('mess'))
                                <div class="alert alert-success">
                                    {{ session('mess') }}
                                </div>
                            @endif
                        </div>
                                
                                <div>
                                    <input wire:model.debounce.500ms="newImgEditName" type="text" class="form-control" placeholder="Image Edit Name" >
                                </div>

                        @if($photo)
                                <!-- Iconica x -->            
                                        <!-- Ovaj comment id kako je se dobio je 
                                        interesantan ako hoces da capis nesto iz bledea mora biti double bracess
                                        A ovaj fas fa-times je iconica iz fontawesome!!!
                                        -->                                      
                                        <i wire:click="removePhoto"                                         
                                            class="fas fa-times-circle fa-2x" 
                                            onmouseover="this.style.color='red'" 
                                            onmouseout="this.style.color='grey'" 
                                            style="cursor: pointer; color: grey" ></i>                                                        
                                <!--kraj za Iconica x -->                    
                                <img src="{{ $photo->temporaryUrl() }}"  alt="" width="200" >
                                <button type="submit">Save Photo</button>
                        @endif

                    <!-- Image Edit Name --> 
                    
                    @if(!$photo)
                    <!-- Picture uploading -->
                    <div>
                        <!-- 100mb = 100000000 ; 1mb=1000000 -->
                        <input type="file" 
                            onchange="if(!this.files[0].name.match(/.(jpg|jpeg|gif|png|bmp|svg|svgz|cgm|djv|djvu|ico|ief|jpe|pbm|pgm|pnm|ppm|ras|rgb|tif|tiff|wbmp|xbm|xpm|xwd)$/i))
                                        {alert('not an image');}
                                      else if(this.files[0].size > '10000000'){ 
                                        event.stopImmediatePropagation();                    
                                        alert('File uploads cannot be larger than 1MB.');
                                        this.form.reset();
                                        }" 
                            wire:model="photo" />
                    </div>
                    @endif

                            <!-- Ovo sta znam mozda ti zatreba pa ostavljam ispise text dok nesto radi -->
                            <!-- <div wire:loading wire:target="photo">Uploading...</div>

                            <div wire:loading wire:target="savePhoto">Saving photo...</div> -->
                            <br>
                </form>
        </div>


        <!-- Sama photografija ovde -->
        <!-- ------------------------------------------------------------ -->
        
        
        <div class="col-7">

            <div><p>@if($title)Title: {{$title}} @else Utitled @endif</p></div>
            <div>
                <img src="{{ asset($imageUDb)}}" class="img-fluid" alt="Responsive image" width="200">
            </div>
        <!-- ------------------------------------------------------------- -->

            
            
        </div>    
        <div class="col-1"></div>
    </div>   

    <!-- --------------------------------------------------------------------------------- -->
    <hr>

    <!-- =============================================================================== -->
    <!-- container za singe image: levo mislim properties of image a desno sam image za obradu -->
    <!-- =============================================================================== -->
    <div class="container">


            <div class="row">
                <div class="col-1"></div>
                <div class="col-5">
                <h3>multiple photos uploading</h3>
    
        <form wire:submit.prevent="savePhotos">

            <!-- Error messagess -->
            @error('photos.*')
                <h4> 
                    <span class="error text-danger font-weight-normal" >{{ $message }}</span> 
                </h4> 
            @enderror

            <!-- Success upload message -->
            <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div>

            <!-- prevew images -->
            @if($photos)
                @foreach($photos as $photo)      
                        <div wire:key="{{$loop->index}}">
                            <!-- Iconica x -->            
                                <!-- Ovaj comment id kako je se dobio je 
                                interesantan ako hoces da capis nesto iz bledea mora biti double bracess
                                A ovaj fas fa-times je iconica iz fontawesome!!!
                                -->                                            
                                <i wire:click="remove({{$loop->index}})"                                         
                                    class="fas fa-times-circle fa-2x" 
                                    onmouseover="this.style.color='red'" 
                                    onmouseout="this.style.color='grey'" 
                                    style="cursor: pointer; color: grey" ></i>                                                        
                            <!--kraj za Iconica x -->

                            <img src="{{ $photo->temporaryUrl() }}"  alt="" width="200" >
                        </div>
                @endforeach

                <br>
                <button wire:loading.remove type="submit">Save Photos</button>
                
                <!-- Ovo je ko bojagi button koji je samo spiner mada bzvze je ovo reseno ali ajde -->
                <button wire:loading target="savePhotos"><i class="fas fa-spinner fa-spin"></i></button>
            @endif

                <div>
                    <!-- Prevent uploading big files -->
                    <!-- 100mb = 100000000 ; 1mb=1000000 -->
                    <!-- VAZNO OVO ZA MULTIPLE FILES NISAM ZADOVOLJAN KAKO RADI TREBACE FIX -->
                    <input type="file" 
                        onchange="if(this.files[0].size > '10000000'){ 
                            event.stopImmediatePropagation();                    
                            alert('File uploads cannot be larger than 1MB.');
                            this.form.reset();
                        }" 
                        wire:model="photos" multiple />
                </div>

                    <!-- Ovo sta znam mozda ti zatreba pa ostavljam ispise text dok nesto radi -->
                    <!-- Idikators showing progress -->
                    <!-- <div wire:loading wire:target="photos">Uploading...</div>
                        <div wire:loading wire:target="savePhotos">Saving photo...</div> -->
    
    </form>


                </div>
                <div class="col-5">
                            <!-- photografije ovde -->
                            <p>multiple Photos here</p>
                </div>    
                <div class="col-1"></div>
            </div>
    

</div>
