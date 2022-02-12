@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <!-- ---------------- -->
                <div>          
                <a href="{{ route('image-editor') }}"><button class="btn btn-info">Edit image</button></a>

                <a href="{{ route('my-projects') }}"><button class="btn btn-info">My Saved Projets</button></a>
                
                </div>   
                <br>

                <!-- ----------------- -->
            </div>
        </div>
    </div>
</div>
@endsection
