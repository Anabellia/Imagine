@extends('layouts.app')

@section('content')


    <h1>Holla!! from image-editor bleada</h1>
    
    <!-- ---------------- -->
    <div>          
                <a href="{{ route('home') }}"><button class="btn btn-info">Dashboard</button></a>
                
                </div>   
                <br>

                <!-- ----------------- -->
    <hr>

    <div class="container">


    <div class="row">
    <div class="col-1"></div>
    <div class="col-4"><livewire:imgproperties /></div>
    <div class="col-6"><livewire:editimg /></div>
    <div class="col-1"></div>
  </div>
        
            

    </div>


    

@endsection
