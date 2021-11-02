@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Welcome {{Auth::user()->name}}</div>

                <div class="card-body">
                    @if (session('status'))
                        <script>
                            swal('Done','Successful','success');
                        </script>
                    @endif

                    <div class="row">
                        <div class="col text-center">
                            <a href="{{route('response',['type'=>1])}}" class="btn btn-success btn-block">SAFE</a>
                        </div>
                        <div class="col text-center">
                            <a href="{{route('response',['type'=>2])}}" class="btn btn-danger btn-block">Danger</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <hr/>
            
            <div class="row">
                <div class="col-12 text-center">
                                    
                    <img src="{{asset('img/splash.jpg')}}"/>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<script>
var x = document.getElementById("demo");

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + 
    "<br>Longitude: " + position.coords.longitude;
}

</script>

@endsection
