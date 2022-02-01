<div>
    <p>Hello from img-file-uploader bledea
            @error('photo')
                            <h4><span class="error text-danger font-weight-normal" >{{ $message }}</span></h4> 
            @enderror
    
            @if(session()->has('delFromHis'))
                <span class="alert alert-success">
                    {{ session('delFromHis') }}
                </span>
            @endif
            <!-- OVO JE MESSAGE KOJI NESTANE POSLE 3 S!!! 
                    Success upload message alert -->
                    
                        @if(session()->has('mess'))
                            <span class="alert alert-success">                                    
                                {{ session('mess') }}
                            </span>

                            <script>
                                var timeout = 3000; // in miliseconds (3*1000)
                                $('.alert').delay(timeout).fadeOut(500);
                            </script>
                        @endif
                    
        </p>   

    
    <hr>
    <!-- =============================================================================== -->
    <!-- container za singe image: levo mislim properties of image a desno sam image za obradu -->
    <!-- =============================================================================== -->
    <div class="container">
        <div class="row">

            <!-- Levo history of editing -->
            <div class="col-2">            
                <h5>History:</h5>
                    @foreach($edits as $edit)  
                    <!-- ovaj dflex ce da rasporedi ova dole dva diva jedan levo drugi desno -->    
                    <div class="d-flex">
                        <div>
                            @if($edit->edit_step_number == 0) <h6>{{$edit->action_made}}</h6>@else <p>{{$edit->action_made}}</p>@endif
                        </div>
                                             
                        <div class="ml-auto">
                            <!-- Iconica x -->            
                                    <!-- Ovaj comment id kako je se dobio je 
                                    interesantan ako hoces da capis nesto iz bledea mora biti double bracess
                                    A ovaj fas fa-times je iconica iz fontawesome!!!
                                    -->                                            
                                <i wire:click="removeFromHistory({{$edit->id}})"                                         
                                        class="fas fa-trash" 
                                        onmouseover="this.style.color='red'" 
                                        onmouseout="this.style.color='grey'" 
                                        style="cursor: pointer; color: grey" ></i>                                                        
                            <!--kraj za Iconica x -->
                        </div>
                    </div>   
                    
                    <p class="small">{{$edit->created_at->diffForHumans()}}</p>                    
                     
                    
                    
                    <!-- <img src="{{asset('storage/' . $edit->path)}}" alt="" width="80" > -->
                    <hr>
                    @endforeach
                    {{ $edits->links() }}
            </div>
            <!-- End of Levo history of editing -->



        <div class="col-3" style="text-align:center">
            <h6>Singe photo uploading</h6>            
            <form wire:submit.prevent="savePhoto" enctype='multipart/form-data'>
                        
                        
                        
                        
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
                                <div>
                                <input wire:model.debounce.500ms="newImgEditName" type="text" placeholder="Image Edit Name" >
                            </div>
                                <button type="submit">Save Photo</button>
                        @endif

                    <!-- Image Edit Name --> 
                    
                    @if(!$photo)
                    <!-- Picture uploading -->
                    <div>
                        <!-- 100mb = 100000000 ; 1mb=1000000 -->
                        <label for="img" class="btn btn-info">Upload Image</label>
                        



                        <input type="file" id="img" style="display:none"
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
                            
                    @if($imageUDb)
                    
                        <h6>Image properties:</h6>
                        <p>extension: {{$ext}}</p>
                        <p>width: {{$width}}</p>
                        <p>height: {{$height}}</p>
                        
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
            <div>
                <p>@if($title)Title: {{$title}} @else Untitled @endif</p>
                
            </div>
            @if($iUDbPath)
            <div style="text-align:center">
                <img style="max-height:400px;"  src="{{ asset($iUDbPath)}}" id="placedImg" class="img-fluid">
            </div>
            <!-- <button onclick="saveFunction();"  ></button> -->
            @else
            <!-- ovde bih voleo da probam drag and drop here -->
            <div>
                <img src="{{ asset('photos\ImgPlaceholder\placeholder.png')}}" class="img-fluid" alt="2Responsive image" width="400">
            </div>
            @endif
            <!-- Buttons za Save/Download/Discharge -->
            <br>
            <div><button wire:click="discharge" class="btn btn-outline-danger" @if(!$iUDbPath) disabled @endif>Discharge all & start new</button>
            &nbsp;&nbsp;&nbsp;
            <button type="button" class="btn btn-outline-dark" data-target="#modal" data-toggle="modal" @if(!$iUDbPath) disabled @endif>Crop</button>
            </div>

            

        </div>   
        
        <div class="col-0"></div>
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





            <!-- =============================================================================== -->
    <!-- CROPPER . JS START -->
    <!-- =============================================================================== -->
    <style type="text/css">
        img {
            display: block;
            max-width: 100%;
        }
        .preview {
            overflow: hidden;
            width: 160px; 
            height: 160px;
            margin: 10px;
            border: 1px solid red;
        }
        
    </style>

        <div class="modal" id="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="img-container">
                            <div class="row">
                                <div class="col-md-8">  
                                    <!--  default image where we will set the src via jquery-->
                                    <img id="image" src="{{ asset($iUDbPath)}}">
                                </div>
                                <div class="col-md-4">
                                    <div class="preview"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary" id="crop" data-dismiss="modal">Crop</button>
                    </div>
                </div>
            </div>
        </div>

<!-- ================================================================================================================= -->
            <!-- -------------------------------------------- -->
        <!-- CROPPER>JS start -->
    <!-- -------------------------------------------- -->

        <script>
            var bs_modal = $('#modal');
            var image = document.getElementById('image');
            var cropper;        

            /* alert(image); */
                    /* $("body").on("change", ".image", function(c) {
                            var files = c.target.files;
                            var done = function(url) {
                                image.src = url;
                                bs_modal.modal('show');
                            };

                            if (files && files.length > 0) {
                                file = files[0];

                                if (URL) {
                                    done(URL.createObjectURL(file));
                                } else if (FileReader) {
                                    reader = new FileReader();
                                    reader.onload = function(e) {
                                        done(reader.result);
                                    };
                                    reader.readAsDataURL(file);
                                }
                            }                    
                        }); */

                        bs_modal.on('shown.bs.modal', function() {    
                                                  
                            cropper = new Cropper(image, {
                                autoCropArea: 0.7,
                                viewMode: 1,
                                center: true,
                                dragMode: 'move',
                                movable: true,
                                scalable: true,
                                guides: true,
                                zoomOnWheel: true,
                                cropBoxMovable: true,
                                wheelZoomRatio: 0.1,
                                preview: '.preview'
                            });
                        }).on('hidden.bs.modal', function() {
                            cropper.destroy();
                            cropper = null;
                        });

                        

            $("#crop").click(function() {
                canvas = cropper.getCroppedCanvas({
                    /* width: 160,
                    height: 160, */
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        window.livewire.emit('imgCropped', reader.result);
                        
                    };
                });
            });

        </script>
        
        <!-- cropper js end -->


    <!-- =============================================================================== -->
    <!-- CROPPER . JS KRAJ -->
    <!-- =============================================================================== -->
    

</div>
