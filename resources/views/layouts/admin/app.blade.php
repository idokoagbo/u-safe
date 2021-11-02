<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>{{ucwords(str_replace('-',' ',Request::segment(2)))}} | {{ config('app.name', 'Laravel') }}</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/Ionicons/css/ionicons.min.css')}}">

    <link rel="stylesheet" href="{{asset('admin/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
    
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('admin/dist/css/skins/_all-skins.min.css')}}">
  <!-- Morris chart -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/morris.js/morris.css')}}">
  <!-- jvectormap -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/jvectormap/jquery-jvectormap.css')}}">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
    
    <link href="{{asset('jsmaps/jsmaps.css')}}" rel="stylesheet" type="text/css" />
    
  <link rel="stylesheet" href="{{asset('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css')}}">  

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      #floating-panel {
        position: absolute;
        top: 10px;
        left: 25%;
        z-index: 5;
        background-color: #fff;
        padding: 5px;
        border: 1px solid #999;
        text-align: center;
        font-family: 'Roboto','sans-serif';
        line-height: 30px;
        padding-left: 10px;
      }
      #floating-panel {
        background-color: #fff;
        border: 1px solid #999;
        left: 25%;
        padding: 5px;
        position: absolute;
        top: 10px;
        z-index: 5;
      }
    </style>
    
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="{{route('admin.dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="{{asset('img/un-logo.png')}}" class="img-fluid" style="height:50px"/></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><h3>UNDSS STT NEA</h3></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Notifications: style can be found in dropdown.less -->
          <!--li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{count(App\Notification::where('user_id',Auth::user()->id)->get())}}</span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <ul class="menu">   
              @forelse(App\Notification::where('user_id',Auth::user()->id)->get() as $pending)
                    
                <li>
                  <a href="#">
                      <i class="fa fa-warning text-yellow"></i> {{$pending->message}}
                  </a>
                </li>  
                
              @empty
                
              <li class="header">You have {{count(App\Notification::where('user_id',Auth::user()->id)->get())}} notifications</li>
              @endforelse
              <li class="footer"><a href="#">View all</a></li>
                </ul>
              </li>
            </ul>
          </li-->
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{App\User::photo(Auth::user()->id)}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{App\User::photo(Auth::user()->id)}}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}} - Administrator
                  <small>Member since {{Auth::user()->created_at->format('M. Y')}}</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--a href="#" class="btn btn-default btn-flat">Profile</a-->
                </div>
                <div class="pull-right">
                  <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Sign out</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>                                    
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{App\User::photo(Auth::user()->id)}}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->name}}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li class="@if(Request::segment(2)=='dashboard'||Request::segment(2)=='') active @endif")><a href="{{url('/admin/dashboard')}}"><i class="fa fa-desktop"></i> <span>Dashboard</span></a></li>
        <li class="@if(Request::segment(2)=='users') active @endif"><a href="{{url('/admin/users')}}"><i class="fa fa-users"></i> <span>Users</span></a></li>
        <li class="treeview @if(Request::segment(2)=='reports') active @endif">
          <a href="{{url('/admin/reports')}}">
            <i class="fa fa-comments"></i> <span>Reports</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="@if(Request::segment(2)=='reports' && Request::segment(3)=='') active @endif"><a href="{{url('/admin/reports')}}"><i class="fa fa-circle-o"></i> All Reports</a></li>
            <li class="@if(Request::segment(3)=='new') active @endif"><a href="{{url('/admin/reports/new')}}"><i class="fa fa-circle-o"></i> New Reports</a></li>
            <li class="@if(Request::segment(3)=='seen') active @endif"><a href="{{url('/admin/reports/seen')}}"><i class="fa fa-circle-o"></i> Old Reports</a></li>
          </ul>
        </li>
        <!--li><a href="{{url('/admin/transactions')}}"><i class="fa fa-map-marker"></i> <span>Head Count</span></a></li-->
        <li class="@if(Request::segment(2)=='headcount') active @endif"><a href="{{url('/admin/headcount')}}"><i class="fa fa-users"></i> <span>Headcount</span></a></li>
        <li class="@if(Request::segment(2)=='staff-location') active @endif"><a href="{{url('/admin/staff-location')}}"><i class="fa fa-map-marker"></i> <span>Staff Members Location</span></a></li>
        <li class="@if(Request::segment(2)=='heatmap') active @endif"><a href="{{url('/admin/heatmap')}}"><i class="fa fa-fire"></i> <span>Heat Map</span></a></li>
        <li><a href="#importModal" data-toggle="modal" data-target="#importModal"><i class="fa fa-upload"></i> <span>Upload Staff List</span></a></li>
        <!--li class="header">LABELS</li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Loan Types</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Logout</span></a></li-->
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
    @yield('content')
    
    <!-- Modal -->
<div id="importModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Import Staff List </h4>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-10 col-md-offset-1">
                  <form method="post" action="{{ route('import') }}" enctype="multipart/form-data">
                      @csrf
                      
                      <div class="row text-center">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="control-label">Choose your xls/csv File</label>
                                <div>
                                    <input name="file" type="file" class="form-control text-center" required/>
                                    
                                </div>
                            </div>
                        </div>
                          
                        <div class="col-md-12">
                            <button class="btn btn-block btn-primary" type="submit">Upload Staff List</button>  
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
    
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.0.0
    </div>
    <strong>Copyright &copy; {{date('Y')}} <a href="#">UNDSS</a>.</strong> All rights
    reserved.
  </footer>
    
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="{{asset('admin/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('admin/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('admin/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Morris.js charts -->
<script src="{{asset('admin/bower_components/raphael/raphael.min.js')}}"></script>
<script src="{{asset('admin/bower_components/morris.js/morris.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('admin/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js')}}"></script>
<!-- jvectormap -->
<script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('admin/bower_components/jquery-knob/dist/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('admin/bower_components/moment/min/moment.min.js')}}"></script>
<script src="{{asset('admin/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>
<!-- datepicker -->
<script src="{{asset('admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{asset('admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
    
<!-- DataTables -->
<script src="{{asset('admin/bower_components/datatables.net/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('admin/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('admin/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('admin/bower_components/fastclick/lib/fastclick.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.min.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/dist/js/demo.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
    
<script src="{{asset('jsmaps/jsmaps-libs.js')}}" type="text/javascript"></script>
<script src="{{asset('jsmaps/jsmaps-panzoom.js')}}" type="text/javascript"></script>
<script src="{{asset('jsmaps/jsmaps.min.js')}}" type="text/javascript"></script>
<script src="{{asset('maps/nigeria.js')}}" type="text/javascript"></script>
    
<script src="{{asset('//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js')}}"></script>
<script src="{{asset('//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js')}}"></script>

<script type="text/javascript">
    
    $(document).ready(function(){
        
        var host="https://undss.sls.ng";
        
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', '{{asset("sounds/sound1.mp3")}}');

        audioElement.addEventListener('ended', function() {
            this.play();
        }, false);

        audioElement.addEventListener("canplay",function(){
            $("#length").text("Duration:" + audioElement.duration + " seconds");
            $("#source").text("Source:" + audioElement.src);
            $("#status").text("Status: Ready to play").css("color","green");
        });

        audioElement.addEventListener("timeupdate",function(){
            $("#currentTime").text("Current second:" + audioElement.currentTime);
        });
        
        var url=host+'/api/get-new-notifications/';
        
        var counter=1;
        
        setInterval(function(){
            $.ajax({url: url, success: function(result){
            
                var display='';

                if(result!=null){
                    
                    /*if(counter==1){
                        audioElement.play();
                        
                        counter++;
                    }else{
                        audioElement.pause();
                    }*/
                    
                    

                    $(result).each(function(index,item){
                        
                        var res=item.description.split('-');
                        
                        display+="<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button><h4><i class='icon fa fa-warning'></i> Alert! - "+res[0]+"</h4> "+item.description+"<hr/> <a href='"+host+"/admin/report/"+item.id+"'>View incidence report</a> </div>";


                    });

                    $("#alert-area").html(display);

                }else{
                    audioElement.pause();
                    counter=1;
                }                

            }});
        },1000);
        
        $('#play').click(function() {
            audioElement.play();
            $("#status").text("Status: Playing");
        });

        $('#pause').click(function() {
            audioElement.pause();
            $("#status").text("Status: Paused");
        });

        $('#restart').click(function() {
            audioElement.currentTime = 0;
        });
    });
    
  </script>
    
<!-- page script -->
<script type="text/javascript">
  $(function () {
    $('#example1').DataTable()
    $('#example2').DataTable({
      'paging'      : true,
      'lengthChange': false,
      'searching'   : false,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : false
    })
  });

  Morris.Bar({
  element: 'trending',
  data: [

    @foreach(App\ResponseCode::all() as $trend)
    { y: '{!!$trend->name!!}', a: {{count(App\IncidentResponse::where('response_code',$trend->id)->get())}} },
    @endforeach
  ],
  xkey: 'y',
  ykeys: ['a'],
  labels: ['Reports'],
  barRatio: 100,
  xLabelAngle: 35,
  yLabelFormat: function(y){return y != Math.round(y)?'':y;},
});
    
    // This example requires the Visualization library. Include the libraries=visualization
      // parameter when you first load the API. For example:
      // <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&libraries=visualization">

      var map, map2, heatmap, checker=0;

      function initMap() {
          
          @if(Request::segment(2)=='staff-location')
          initMap2();
          @endif
          
          /*heatmap*/
          
          map = new google.maps.Map(document.getElementById('map'), {
          zoom: 7,
          center: {lat: 9.037427, lng: 7.497793},
          mapTypeId: 'roadmap',
          gestureHandling: "auto"  
            
        });

        heatmap = new google.maps.visualization.HeatmapLayer({
          data: getPoints(),
          map: map
        });
          
        var locations = [
            
            <?php $marker_counter=1; ?>
            @foreach(App\IncidentResponse::all() as $marker)
            
            <?php $geo_arr=explode(',',$marker->geolocation); ?>
            
            ['<b>{{$marker->description}} [{{$marker->created_at}}]</b>', {{$geo_arr[0]}}, {{$geo_arr[1]}}, {{$marker_counter}}],
            
            @endforeach
        ];
    
        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map
          });

          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map, marker);
            }
          })(marker, i));
        }
        
          
      }
      
      function initMap2(){
          
          var icon = {
            url: "{{asset('/img/map-marker.png')}}", // url
            scaledSize: new google.maps.Size(25, 25), // scaled size
        };
          
          /*people near by*/
        map2 = new google.maps.Map(document.getElementById('people-nearby'), {
          zoom: 7,
          center: {lat: 9.037427, lng: 7.497793},
          mapTypeId: 'roadmap',
          gestureHandling: "auto"  
            
        });
          
        var locations = [
            
            <?php $marker_counter=1; ?>
            @foreach(App\User::all() as $marker)
            
            ['<b>{{$marker->name}} {{$marker->phone}} [{{$marker->staff_code}}]</b>', {{$marker->latitude}}, {{$marker->longitude}}, {{$marker_counter++}}],
            
            @endforeach
        ];
    
        var infowindow = new google.maps.InfoWindow();

        var marker, i;

        for (i = 0; i < locations.length; i++) {  
          marker = new google.maps.Marker({
            position: new google.maps.LatLng(locations[i][1], locations[i][2]),
            map: map2,
          });

          google.maps.event.addListener(marker, 'click', (function(marker, i) {
            return function() {
              infowindow.setContent(locations[i][0]);
              infowindow.open(map2, marker);
            }
          })(marker, i));
        }
      }

      function toggleHeatmap() {
        heatmap.setMap(heatmap.getMap() ? null : map);
      }
    
      function toggleMarkers() {
          
          marker.setVisible(false);
          
      }

      function changeGradient() {
        var gradient = [
          'rgba(0, 255, 255, 0)',
          'rgba(0, 255, 255, 1)',
          'rgba(0, 191, 255, 1)',
          'rgba(0, 127, 255, 1)',
          'rgba(0, 63, 255, 1)',
          'rgba(0, 0, 255, 1)',
          'rgba(0, 0, 223, 1)',
          'rgba(0, 0, 191, 1)',
          'rgba(0, 0, 159, 1)',
          'rgba(0, 0, 127, 1)',
          'rgba(63, 0, 91, 1)',
          'rgba(127, 0, 63, 1)',
          'rgba(191, 0, 31, 1)',
          'rgba(255, 0, 0, 1)'
        ]
        heatmap.set('gradient', heatmap.get('gradient') ? null : gradient);
      }

      function changeRadius() {
        heatmap.set('radius', heatmap.get('radius') ? null : 20);
      }

      function changeOpacity() {
        heatmap.set('opacity', heatmap.get('opacity') ? null : 0.2);
      }

      // Heatmap data: 500 Points
      function getPoints() {
        return [
            
            @foreach(App\IncidentResponse::all() as $incident_response)
            
            <?php $geo_arr=explode(',',$incident_response->geolocation); ?>
            
            new google.maps.LatLng({{$geo_arr[0]}}, {{$geo_arr[1]}}),
            
            @endforeach
            
        ];
      }
    
    
    </script>
    

<script async defer
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBJFgs3x_JMVh4lvBcqRD42uW7vBohkavY&libraries=visualization&callback=initMap">
    </script>
</body>
</html>
