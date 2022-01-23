<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <!-- Font koji je u stvari icone FONTAWESOME -->
    <script src="https://kit.fontawesome.com/08d6af9d9e.js" crossorigin="anonymous"></script>

    <!-- CROPPER.JS da moz crop photo -->
    <!-- VAZNO VAZAN JE I REDOSLED OVIH ISPOD!! -->  
    
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" </script> -->
    
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>




    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script> -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/2.0.0-alpha.2/cropper.min.css" rel="stylesheet" type="text/css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <livewire:styles />
    
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <!-- ovo commentiram i stavljam ga gore u head - hmmm ovo mi se ne svidja ali jbga ajd probam -->
    <livewire:scripts />



    <!-- -------------------------------------------- -->
    <!-- Ovaj event je za pics loading - listening for change sa editimage.bleda-->
    <script>
        window.livewire.on('fileChoosen', () => {
            let inputField = document.getElementById('image');
            let file = inputField.files[0];

            let reader = new FileReader();

            reader.onloadend = () => {
                window.livewire.emit('fileUpload', reader.result)
                
            }

            reader.readAsDataURL(file);
            
        })

        
    </script>

    <!-- -------------------------------------------- -->
        <!-- CROPPER>JS start -->
    <!-- -------------------------------------------- -->

        <!-- Ovo je moja funkcija iz eslingua mozda je upotrebim ove 
        pa je pastam (ima i button tamo da je pozove u view) -->
        

            <!-- stackowerflow!!!! -->
            <!-- <script>
            $(document).ready(function(){
                $('#MyButton').click(function(){
                CapacityChart();
                });
            });
            </script> -->           

            

            <!-- $("#button").on('click',function(){
                //do something
            }); -->
            <!-- END OF stackowerflow!!!! -->

        <!-- END OF Ovo je moja funkcija iz eslingua mozda je upotrebim ove 
        pa je pastam (ima i button tamo da je pozove u view) -->
        


        <script>
            var bs_modal = $('#modal');
            var image = document.getElementById('image');
            var cropper,reader,file;        

            /* alert(image); */
                    $("body").on("change", ".image", function(c) {                                         

                            /* $("#cropbtn").on("click" function(e){ */
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
                        });

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
                    width: 160,
                    height: 160,
                });

                canvas.toBlob(function(blob) {
                    url = URL.createObjectURL(blob);
                    var reader = new FileReader();
                    reader.readAsDataURL(blob);
                    reader.onloadend = function() {
                        var base64data = reader.result;

                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: "upload.php",
                            data: {image: base64data},
                            success: function(data) { 
                                bs_modal.modal('hide');
                                alert("success upload image");
                            }
                        });
                    };
                });
            });

        </script>
        <!-- cropper js end -->
</body>



</html>
