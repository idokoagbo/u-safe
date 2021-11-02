@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Upload Images</div>

                <div class="card-body">
                    @if (session('status'))
                        <script>
                            swal('Done','Successful','success');
                        </script>
                    @endif
                    
                    
                    <form method="post" enctype="multipart/form-data" action="{{route('upload',['incidence'=>$event->id])}}">
                        @csrf
                        
                        <input name="incidence_id" type="hidden" value="{{$event->id}}"/>
                        
                        <div class="row">
                            <div class="col-6">
                                <a href="#" onclick="document.getElementById('file1').click()" ><img src="{{asset('/img/bb.jpeg')}}" id="preview1" class="img-fluid img-thumbnail"/></a>
                                <input name="file_1" type="file" id="file1" accept="image/*" style="display:none">
                            </div>
                            <div class="col-6">
                                <a href="#" onclick="document.getElementById('file2').click()" ><img src="{{asset('/img/bb.jpeg')}}" id="preview2" class="img-fluid img-thumbnail"/></a>
                                <input name="file_2" type="file" id="file2" accept="image/*" style="display:none">
                            </div>
                        </div>
                        <hr/>
                        <div class="row">
                            <div class="col-6">
                                <a href="#" onclick="document.getElementById('file3').click()" ><img src="{{asset('/img/bb.jpeg')}}" id="preview3" class="img-fluid img-thumbnail"/></a>
                                <input name="file_3" type="file" id="file3" accept="image/*" style="display:none">
                            </div>
                            <div class="col-6">
                                <a href="#" onclick="document.getElementById('file4').click()" ><img src="{{asset('/img/bb.jpeg')}}" id="preview4" class="img-fluid img-thumbnail"/></a>
                                <input name="file_4" type="file" id="file4" accept="image/*" style="display:none">
                            </div>
                        </div>
                        
                        <hr/>
                        <div>
                            <button class="btn btn-success">Upload</button>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>
</div>


<script>

</script>

@endsection
