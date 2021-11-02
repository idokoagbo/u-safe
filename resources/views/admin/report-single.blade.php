@extends('layouts.admin.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Applications
      </h1>
      <ol class="breadcrumb">
        <li><a href="{{url('/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="{{url('/reports')}}">Reports</a></li>
        <li class="active">Single Report</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div id="alert-area"></div>

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Report #{{$report->id}}-{{strtotime($report->created_at)}}</h3>

          <div class="box-tools pull-right">
            <a href="#" onclick="PrintElem('print-here')" class="btn btn-warning btn-sm"><i class="fa fa-print"></i> Print Report</a>
          </div>
        </div>
        <div class="box-body" id="print-here">
            
            <div class="row"><div class="col-md-6 table-responsive">
                <table class="table table-bordered" cellspacing="10" style="width:100%">
                    <tbody>
                        <tr class="active"><td colspan="2"><b>Sender Information</b></td></tr>
                        <tr><td><b>Sender</b></td> <td>{{App\User::name($report->user_id)}}</td></tr>
                        <tr><td><b>Agency</b></td> <td>{{App\User::agency($sender->id)}}</td></tr>
                        <tr><td><b>Phone</b></td> <td>{{$sender->phone}}</td></tr>
                        <tr><td><b>Email</b></td> <td>{{$sender->email}}</td></tr>
                        <tr><td><b>Geolocation</b></td> <td>{!!App\User::beliefmedia_lat_lng($sender->latitude,$sender->longitude)!!}</td></tr>
                    </tbody>
                
                </table>
            </div>
            </div>
            
            <hr/>
            
            <div class="row"><div class="col-md-6 table-responsive">
                <table class="table table-bordered" cellspacing="10" style="width:100%">
                    <tbody>
                        <tr class="active"><td colspan="2"><b>Incidence Information</b></td></tr>
                        <tr><td><b>Incidence Type</b></td> <td>{{App\ResponseCode::code($report->response_code)}}</td></tr>
                        <tr><td><b>Description</b></td> <td>{!!nl2br($report->description)!!}</td></tr>
                        <?php $geolocation=explode(',',$report->geolocation); ?>
                        <tr><td><b>Geolocation</b></td> <td>{!!App\User::beliefmedia_lat_lng($geolocation[0],$geolocation[1])!!}</td></tr>
                        <tr><td><b>Date</b></td> <td>{{$report->created_at->format('d M, Y, H:i:s a')}}</td></tr>
                        <tr><td><b>Staff Members notified</b></td> <td>{{count($staffs)}}</td></tr>
                        <tr><td><b>Safe</b></td> <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',1)->get())}}</td></tr>
                        <tr><td><b>Danger</b></td> <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',2)->get())}}</td></tr>
                        <tr><td><b>Unknown</b></td> <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',0)->get())}}</td></tr>
                    </tbody>
                
                </table>
            </div></div>
            
            <div class="row">
                
                <div class="col-md-12"><p><b>Staff Members Notified (total: {{count($staffs)}})</b></p></div>
                <hr/>
                
                <div class="col-md-12 table-responsive">
                    <table class="table table-bordered table-striped" cellspacing="10" style="width:100%">
                        <thead><tr><th>S/N</th> <th>Name</th> <th>Agency</th> <th>Response</th></tr></thead>
                        
                        <tbody style="text-align:center">
                            <?php $x=1; ?>
                            @forelse($staffs as $staff)
                            <tr>
                                <td>{{$x++}}</td> <td>{{App\User::name($staff->user_id)}}</td> <td>{{App\User::agency($staff->user_id)}}</td> <td>
                                
                                @if($staff->status==1)
                                <label class="label label-success">Safe</label>
                                @elseif($staff->status==2)
                                <label class="label label-danger">Danger</label>
                                @else
                                <label class="label label-warning">Unknown</label>
                                @endif
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            
            
            
            
        </div>
        <!-- /.box-body 
        <div class="box-footer clearfix">
            <p><b>Update Scholarship Application Status: </b> 
                @if($report->status==0)
                <a href="{{url('/application/pending')}}/{{$report->id}}" onclick="return confirm('Are You Sure You want to update the status of this application?')" data-toggle="tooltip" title="Process Application" class="btn btn-warning">Start Processing</a>
                @elseif($report->status==2)
                <a href="{{url('/application/approve')}}/{{$report->id}}" onclick="return confirm('Are You Sure You want to update the status of this application?')" data-toggle="tooltip" title="Approve Scholarship" class="btn btn-success btn-inline">Approve</a> &nbsp;
                <a href="{{url('/application/reject')}}/{{$report->id}}" onclick="return confirm('Are You Sure You want to update the status of this application?')" data-toggle="tooltip" title="Reject Application" class="btn btn-danger btn-inline">Reject</a>
                @else
                <a href="#" class="btn btn-default btn-block disabled">No Further Action Required</a>
                @endif
            </p>
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

<script>
function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>
@endsection