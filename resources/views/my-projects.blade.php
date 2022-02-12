@extends('layouts.app')

@section('content')


    <h1>my-projects blade</h1>
    
    <!-- ---------------- -->
    <div>          
                <a href="{{ route('home') }}"><button class="btn btn-info">Dashboard</button></a>
                
                </div>   
                <br>

                <!-- ----------------- -->
    <hr>

    <div class="container">


    <div class="row">
    <!-- <div class="col-1"></div>    --> 
    <div class="col-12">col12</div>
    <!-- <div class="col-1"></div> -->
  </div>


  <hr>

    <div class="container">


    <div class="row">
    <div class="col-1">col1</div>
    <div class="col-5">col5</div>
    <div class="col-5">col5</div>    
    <div class="col-1">col1</div>
  </div>
        
            

    </div>


    

@endsection
