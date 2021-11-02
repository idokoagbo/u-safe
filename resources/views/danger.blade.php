@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Incidence Type</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    
                    
                    <form method="post" id="response_form" enctype="multipart/form-data" action="{{route('response',['type'=>'2'])}}">
                        @csrf
                        
                        
                        <input name="lat" id="lat" type="hidden" value="{{Auth::user()->latitude}}"/>
                        <input name="lng" id="lng" type="hidden" value="{{Auth::user()->longitude}}"/>
                        
                        <div>
                            <button class="btn btn-primary btn-block" name="incidence" value="Active Shooter">Active Shooter</button>
                        </div>
                        <hr/>
                        <div>
                            <button class="btn btn-primary btn-block" name="incidence" value="VBID">VBID</button>
                        </div>
                        <hr/>
                        <div>
                            <button class="btn btn-primary btn-block" name="incidence" value="PBID">PBID</button>
                        </div>
                        <hr/>
                        <div>
                            <button class="btn btn-primary btn-block" name="incidence" value="Civil Unrest">Civil Unrest</button>
                        </div>
                        <hr/>
                        <div>
                            <button class="btn btn-primary btn-block" name="incidence" value="Complex">Complex</button>
                        </div>
                        
                        <div style="display:none;">
                            <button class="btn btn-success" id="location_btn" onclick="getLocation()" type="button" name="incidence" value="Complex">Get Location</button>
                        </div>
                        
                        <!--div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="incidence" value="Active Shooter">Active Shooter
                          </label>
                        </div>
                        <div class="form-check">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="incidence" value="VBID">VBID
                          </label>
                        </div>
                        <div class="form-check disabled">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="incidence" value="PBID">PBID
                          </label>
                        </div>
                        <div class="form-check disabled">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="incidence" value="Civil Unrest">Civil Unrest
                          </label>
                        </div>
                        <div class="form-check disabled">
                          <label class="form-check-label">
                            <input type="radio" class="form-check-input" name="incidence" value="Complex">Complex
                          </label>
                        </div>
                        
                        <hr/>
                        <div>
                            <button class="btn btn-success">Next</button>
                        </div-->
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script>
    
    $(document).ready(function(){
        $("#location_btn").click();
    });

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        x.innerHTML = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    document.getElementById('lat').value=position.coords.latitude;
    document.getElementById('lng').value=position.coords.longitude;
}

</script>

@endsection
