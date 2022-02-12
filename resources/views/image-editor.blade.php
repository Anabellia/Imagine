@extends('layouts.app')

@section('content')


    <h1>Holla!! from image-editor bleada</h1>
    
    <!-- ---------------- -->
    <div>          
                <a href="{{ route('home') }}"><button class="btn btn-info">Dashboard</button></a>
                <a href="{{ route('my-projects') }}"><button class="btn btn-info">My Saved Projets</button></a>
                
                </div>   
                <br>

                <!-- ----------------- -->
    <hr>

    <div class="container">


    <div class="row">
    <!-- <div class="col-1"></div>    --> 
    <div class="col-12"><livewire:img-file-uploader /></div>
    <!-- <div class="col-1"></div> -->
  </div>


  <hr>

    <div class="container">


    <div class="row">
    <div class="col-1"></div>
    <div class="col-5"><livewire:imgproperties /></div>
    <div class="col-5"><livewire:editimg /></div>    
    <div class="col-1"></div>
  </div>
        
            

    </div>


    

@endsection
