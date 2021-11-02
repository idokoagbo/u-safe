@extends('layouts.admin.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Dashboard
        <small>Welcome {{Auth::user()->username}}</small>
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
        
        <!-- Small boxes (Stat box) -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-group"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Users</span>
              <span class="info-box-number">{{count(App\User::all())}}</span> 
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
            <a href="{{route('user.export')}}" class="btn bg-aqua btn-sm btn-block"><i class="fa fa-download"></i> Export Users' Data</a><br/>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-pie-chart"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Incidents</span>
              <span class="info-box-number">{{count(App\IncidentResponse::all())}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
            <a href="{{route('incident.export')}}" class="btn bg-green btn-sm btn-block"><i class="fa fa-download"></i> Export Incident Reports</a><br/>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-bell"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Notification Sent</span>
              <span class="info-box-number">{{count(App\Notification::all())}}</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
            <a href="{{route('response.export')}}" class="btn bg-red btn-sm btn-block"><i class="fa fa-download"></i> Export Headcount Report</a><br/>
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-user-secret"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Admins</span>
              <span class="info-box-number">##</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
        <div class="col-md-12">
          <div class="box">

            <div class="box-header with-border">
              <h3 class="box-title">Report Graph</h3>
            </div>
          
            <div  class="box-body"><div id="trending" style="height: 350px;"></div></div>
          </div>
          
          
        </div>
      </div>

      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Recent Users</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
          <table class="table">
              <thead>
                <tr>
                    <th>S/N</th>    
                    <th>Name</th>
                    <th>Email</th>  
                    <th>Phone</th>  
                    <th>Role</th>  
                    <th>Created At</th>  
                </tr>
              </thead>
              <tbody>
                  <?php $x=1; ?>
                @forelse(App\User::orderBy('id','DESC')->limit(5)->get() as $user)
                  <tr>
                    <td>{{$x++}}</td>
                    <td><a href="{{url('/users/view')}}/{{$user->id}}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>
                    @if($user->role==1)
                        Staff
                    @elseif($user->role==2)
                        Dealer
                    @elseif($user->role==3)
                        Admin
                    @endif
                    </td>
                    <td>{{$user->created_at}}</td>
                  </tr>
                @empty
                  <tr><td colspan="6"><center class="callout callout-info">No Users!</center></td></tr>
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
      <!-- Default box -->
      <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Recent Reports</h3>

          <div class="box-tools pull-right">
            <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip" title="Collapse">
              <i class="fa fa-minus"></i></button>
            <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
              <i class="fa fa-times"></i></button>
          </div>
        </div>
        <div class="box-body table-responsive">
          <table class="table">
              <thead>
                <tr>
                    <th>S/N</th>    
                    <th>Sender</th>
                    <th>Response Code</th>  
                    <th>Description</th>  
                    <th>Geolocation</th>  
                    <th>Responded</th>  
                    <th>Status</th>
                    <th>Created At</th>  
                </tr>
              </thead>
              <tbody>
                  <?php $x=1; ?>
                @forelse(App\IncidentResponse::orderBy('id','DESC')->limit(5)->get() as $report)
                  <tr>
                    <td>{{$x++}}</td>
                    <td><a href="{{url('/users/view')}}/{{$report->user_id}}">{{App\User::name($report->user_id)}}</a></td>
                    <td>{{App\ResponseCode::code($report->response_code)}}</td>
                    <td>{!!SUBSTR($report->description,0,160)!!}</td>
                      <?php $geolocation=explode(',',$report->geolocation); ?>
                    <td>{!!App\User::beliefmedia_lat_lng($geolocation[0],$geolocation[1])!!}</td>
                    <td>{{count(App\Notification::where('incident_id',$report->id)->where('status',1)->get())}}</td>
                    <td>
                        @if($report->status==1)
                        <label class="label label-success">Seen</label>
                        @else
                        <label class="label label-danger">New</label>
                        @endif
                      
                    </td>
                    <td>{{$report->created_at}}</td>
                  </tr>
                @empty
                  <tr><td colspan="6"><center class="callout callout-info">No Adverts!</center></td></tr>
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
  </div>@endsection