<div>

        <div class="container">
        <div class="row justify-content-start">

            <div class="col-4">
            <p>Hello from img-file-uploader bledea</p>
            </div>

            <div class="col-4">
            @error('photo')
                            <h4><span class="error text-danger font-weight-normal" >{{ $message }}</span></h4> 
            @enderror    
                       
                    <!-- Delete from History successuful message -->
                    @if(session()->has('delFromHis'))
                        <span class="alert alert-success" >{{ session('delFromHis') }}</span>                           
                    @endif
                        <script>
                            $(document).ready(function(){
                                window.livewire.on('delFromHis_remove',()=>{
                                    setTimeout(function(){ $(".alert-success").fadeOut('fast');
                                    }, 2000); // 2 secs
                                });
                            });
                        </script>
                    <!-- End of Delete from History successuful message -->

                    <!-- Upload successuful message -->
                    @if(session()->has('uploadMess'))
                        <span class="alert alert-success">{{ session('uploadMess') }}</span>                            
                    @endif
                        <script>
                            $(document).ready(function(){
                                window.livewire.on('uploadMess_remove',()=>{
                                    setTimeout(function(){ $(".alert-success").fadeOut('fast');
                                    }, 2000); // 2 secs
                                });
                            });
                        </script>
                    <!-- End of Upload successuful message -->

                    <!-- Cropping successuful message -->
                    @if(session()->has('cropMess'))
                        <span class="alert alert-success">{{ session('cropMess') }}</span>                            
                    @endif
                        <script>
                            $(document).ready(function(){
                                window.livewire.on('cropMess_remove',()=>{
                                    setTimeout(function(){ $(".alert-success").fadeOut('fast');
                                    }, 2000); // 2 secs
                                });
                            });
                        </script>
                    <!-- End of Cropping successuful message -->
            </div>
        </div>
    
    
    <hr>
    <!-- =============================================================================== -->
    <!-- container za singe image: levo mislim properties of image a desno sam image za obradu -->
    <!-- =============================================================================== -->
    <div class="container">
        <div class="row">


        <!-- ***************************************************** -->
        <!-- Levo history of editing -->
            <div class="col-2">            
                <h5>History:</h5>
                    @foreach($edits as $edit)  
                    <!-- ovaj dflex ce da rasporedi ova dole dva diva jedan levo drugi desno -->    
                    <div class="d-flex">
                        <!-- mr-2 znaci space margin desno 2 -->
                        <div class="mr-2">
                            @foreach($edit->edit_step_number as $steps)
                            @if($edit->edit_step_number[$steps] == 0) <h6>{{$edit->action_made[$steps]}}</h6>@else <p>{{$edit->action_made[$steps]}}</p>@endif
                            @endforeach
                        </div>
                                             
                        <div class="ml-auto">
                            <!-- Iconica x -->            
                                    <!-- Ovaj edit id kako je se dobio je 
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
                    
                    <hr>
                    @endforeach
                    {{ $edits->links() }}
            </div>
            <!-- End of Levo history of editing -->
            <!-- ***************************************************** -->


        <!-- DROP ZONE -->            

                <style>
                    .dragged-over {
                        border : #ccc 45px;
                        }   
                        
                    #img {
                        position: absolute;
                        top: 0;
                        left: 0;
                        opacity: 0;
                        width: 100%;
                        height: 100%;
                        display: block;
                        }
                    #blisa {
                        position: relative;
                        background-color : #f9f9f9;
                        border :  4px dashed #ccc;
                        line-height : 150px;
                        padding : 12px;
                        font-size : 24px;
                        text-align : center;
                        }
                    #blisa.dragged-over {
                        border: 5px dashed black;
                        }
                </style>

        <div class="col-3" style="text-align:center">
            <h6>Singe photo uploading</h6>     

                

                <!-- Modal za upload formu-->
                    <div class="modal" id="photoUploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" wire:ignore.self>
                        <div class="modal-dialog modal-dialog-centered" role="document" >
                            <form wire:submit.prevent="savePhoto" >
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                        <div class="modal-body">                                        
                                                    @if($photo)            
                                                            <img src="{{ $photo->temporaryUrl() }}"  alt="" width="300" >
                                                            <br>
                                                            <div>
                                                                <input wire:model.defer.debounce.500ms="newImgEditName" type="text" placeholder="add project name - *optional" >
                                                            </div>                                                            
                                                    @endif                                            
                                        </div>
                                <div class="modal-footer">
                                    <button wire:click="removePhoto" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary" >Upload image</button>
                                </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <script>
                        window.addEventListener('show-uploadingPhoto', event => {
                            $('#photoUploadModal').modal('show');
                        })
                    </script>

                    <script>
                        window.addEventListener('hideModal-uploadingPhoto', event => {
                            $('#photoUploadModal').modal('hide');
                        })
                    </script>
                <!-- End of Modal za upload formu-->
                            
                    @if($imageUDb)                    
                        <h6>Image properties:</h6>
                        <p>extension: {{$ext}}</p>
                        <p>width: {{$width}}</p>
                        <p>height: {{$height}}</p>                        
                    @endif
                            <!-- Ovo sta znam mozda ti zatreba pa ostavljam ispise text dok nesto radi -->
                            <div wire:loading wire:target="photo">Uploading...</div>
                            <div wire:loading wire:target="savePhoto">Saving photo...</div>
                            <br>
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

            @if(!$photo)
                <div id="blisa"    >                        
                        <label for="img"  name="image-event-label">Drag & Drop File Here or <button class="btn btn-primary" > click here to upload image</button></label>
                            <input type="file" id="img" name="img"
                                onchange="if(!this.files[0].name.match(/.(jpg|jpeg|gif|png|bmp|svg|svgz|cgm|djv|djvu|ico|ief|jpe|pbm|pgm|pnm|ppm|ras|rgb|tif|tiff|wbmp|xbm|xpm|xwd)$/i))
                                        {alert('not an image');}
                                      else if(this.files[0].size > '10000000'){ 
                                        event.stopImmediatePropagation();                    
                                        alert('File uploads cannot be larger than 1MB.');
                                        this.form.reset();
                                        }
                                        " 
                            wire:model="photo" />
                    </div>
                    
                @endif       

                <script>
                            // only to show where is the drop-zone:
                        $('#blisa').on('dragenter dragover', function() {
                        this.classList.add('dragged-over');
                        })
                        .on('dragend drop dragexit dragleave', function() {
                        this.classList.remove('dragged-over');
                        });
                    </script>

                <!-- ******************************************************** -->                

            <!-- End of DROP ZONE -->

            <!-- <div>
                <img src="{{ asset('photos\ImgPlaceholder\placeholder.png')}}" class="img-fluid" alt="2Responsive image" width="400">
            </div> -->
            @endif
            <!-- Buttons za Save/Download/Discharge -->
            <br>
            <div>
                <button type="button" class="btn btn-outline-dark" data-target="#modal" data-toggle="modal" @if(!$iUDbPath) disabled @endif>Crop</button>
                &nbsp;&nbsp;&nbsp;
                <button wire:click.prevent="modalDiscardFire" class="btn btn-outline-danger" @if(!$iUDbPath) disabled @endif>Discard</button>
            </div>
                        <br>
            <!-- Button za save this project -->
            <button wire:click="saveProject" type="button" class="btn btn-outline-dark" >Save project</button>
            &nbsp;&nbsp;&nbsp;
            <!-- Button za dovnload image -->
            <button wire:click="downloadImage" type="button" class="btn btn-outline-dark">Download image</button>




            

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
            <!-- <div>
                @if (session()->has('message'))
                    <div class="alert alert-success">
                        {{ session('message') }}
                    </div>
                @endif
            </div> -->

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




        <!-- Modal za discard and start over warning-->
        <div class="modal" id="discardAll" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6 class="modal-title" id="exampleModalLongTitle">Are you sure you want to reset the current project?</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <i                                         
                                            class="fas fa-times-circle" 
                                            onmouseover="this.style.color='red'" 
                                            onmouseout="this.style.color='grey'" 
                                            style="cursor: pointer; color: grey" ></i>
                        
                        </button>
                    </div>
                    <div class="modal-body " style="text-align:center">
                        <button wire:click="discharge" class="btn btn-outline-danger" data-dismiss="modal">Discard all</button>
                        &nbsp;&nbsp;&nbsp;
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>                                    
                </div>
            </div>
        </div>
        
        <script>
            window.addEventListener('show-discardAll', event => {
                $('#discardAll').modal('show');
            })
        </script>
        <!-- End of Modal discharge and start over warning-->


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

        <div class="modal fade" id="modal" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
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
                                background: false,
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
