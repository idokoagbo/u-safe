@extends('layouts.admin.app')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>All users</small>
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
          <h3 class="box-title">All Users</h3>
        </div>
        <div class="box-body table-responsive">
          <table class="table" id="example1">
              <thead>
                <tr>
                    <th>S/N</th>    
                    <th>Name</th>
                    <th>Email</th>  
                    <th>Phone</th>
                    <th>Geolocation</th>
                    <th>Status</th>
                    <th>Created At</th>  
                </tr>
              </thead>
              <tbody>
                  <?php $x=1; ?>
                @forelse(App\User::all() as $user)
                  <tr>
                    <td>{{$x++}}</td>
                    <td><a href="{{url('/users/view')}}/{{$user->id}}">{{$user->name}}</a></td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{!!App\User::beliefmedia_lat_lng($user->latitude,$user->longitude)!!}</td>
                    <td>
                        @if($user->status==1)
                        <label class="label label-success">Active</label>
                        @else
                        <label class="label label-danger">Inactive</label>
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

    </section>
    <!-- /.content -->
  </div>@endsection