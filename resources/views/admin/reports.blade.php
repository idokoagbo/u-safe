@extends('layouts.admin.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Incidence Report
        <small>{{Request::segment(3)==null?"All":ucwords(Request::segment(3))}} Reports</small>
      </h1>
      <!--ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Examples</a></li>
        <li class="active">Blank page</li>
      </ol-->
    </section>

    <!-- Main content -->
    <section class="content">
        
        <div id="alert-area"></div>
        
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">{{Request::segment(3)==null?"All":ucwords(Request::segment(3))}} Reports</h3>
            
            <div class="box-tools pull-right">
            <a href="#myModal" data-toggle="modal" data-target="#myModal" class="btn btn-primary btn-sm"><i class="fa fa-clock-o"></i> Filter by Date</a> 
          </div>
        </div>
        <div class="box-body table-responsive" id="print-area">
          <table class="table table-bordered" id="example1" border>
              <thead>
                <tr>
                    <th>S/N</th>    
                    <th>Sender</th>
                    <th>Type</th>  
                    <!--th>Description</th-->
                    <th>Geolocation</th>
                    <th>Staff members Notified</th>
                    <th>Safe</th>
                    <th>Danger</th>
                    <th>Unknown</th>
                    <th>Status</th>
                    <th>Created At</th>  
                    <th>Action</th>  
                </tr>
              </thead>
              <tbody>
                  <?php $x=1; ?>
                @forelse($reports as $report)
                  <tr>
                    <td>{{$x++}}</td>
                    <td><a href="{{url('/users/view')}}/{{$report->user_id}}">{{App\User::name($report->user_id)}}</a></td>
                    <td><label class="label label-info">{{App\ResponseCode::code($report->response_code)}}</label></td>
                    <!--td>{{$report->description}}</td-->
                    <?php $geolocation=explode(',',$report->geolocation); ?>
                    <td>{!!App\User::beliefmedia_lat_lng($geolocation[0],$geolocation[1])!!}</td>
                    <td>{{count(App\Notification::where('incident_id',$report->id)->get())}}</td>
                    <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',1)->get())}}</td>
                    <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',2)->get())}}</td>
                    <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',0)->get())}}</td>
                    <td>
                        @if($report->status==1)
                        <label class="label label-success">seen</label>
                        @else
                        <label class="label label-danger">new</label>
                        @endif
                      
                    </td>
                    <td>{{$report->created_at}}</td>
                    <td><a href="{{url('/admin/report')}}/{{$report->id}}" class="btn btn-primary btn-sm">View</a></td>
                  </tr>
                @empty
                  <tr><td colspan="15"><center class="callout callout-info">No Reports!</center></td></tr>
                @endforelse
              </tbody>
          </table>
        </div>
        <!-- /.box-body -->
        <div class="box-footer">
          
        </div>
        <!-- /.box-footer-->
      </div>
      <!-- /.box -->

    </section>
    <!-- /.content -->
  </div>

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Filter Reports by Date </h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <form method="post" action="{{url('admin/reports/filtered')}}">
                      @csrf
                      
                      <div class="row text-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">Start Date</label>
                                <div>
                                    <input name="start_date" placeholder="dd-mm-yyyy" type="date" class="form-control text-center" required/>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label">End Date</label>
                                <div>
                                    <input name="end_date" placeholder="dd-mm-yyyy" type="date" class="form-control text-center" required/>
                                    
                                </div>
                            </div>
                        </div>
                          
                        <div class="col-md-12">
                            <button class="btn btn-block btn-primary" type="submit">Generate Report</button>  
                        </div>
                      </div>
                  </form>
              </div>
          </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
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