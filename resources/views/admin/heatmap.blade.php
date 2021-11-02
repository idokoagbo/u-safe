@extends('layouts.admin.app')


@section('content')

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Heatmap
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
          <h3 class="box-title">Heatmap</h3>
            
        </div>
        <div class="box-body">
             <div id="floating-panel">
              <button onclick="toggleHeatmap()">Toggle Heatmap</button>
              <button onclick="changeGradient()">Change gradient</button>
              <button onclick="changeRadius()">Change radius</button>
              <button onclick="changeOpacity()">Change opacity</button>
            </div>
            <div id="map" style="min-height:500px"></div>
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


@endsection