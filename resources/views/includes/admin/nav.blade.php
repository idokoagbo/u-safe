<header class="main-header">
    <!-- Logo -->
    <a href="{{url('/admim/dashboard')}}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>UN</b>STT</span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">UNDSS<b> STT NEA</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <img src="{{asset('admin/dist/img/avatar.png')}}" class="user-image" alt="User Image">
              <span class="hidden-xs">{{Auth::user()->name}}</span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="{{asset('admin/dist/img/avatar.png')}}" class="img-circle" alt="User Image">

                <p>
                  {{Auth::user()->name}}
                </p>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <!--a href="#" class="btn btn-default btn-flat">Profile</a-->
                </div>
                <div class="pull-right">
                  <a href="{{url('/admin/logout')}}" class="btn btn-default btn-flat">Sign out</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>