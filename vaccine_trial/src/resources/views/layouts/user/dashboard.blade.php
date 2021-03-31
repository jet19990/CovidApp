<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>User dashboard | Vaccine Administration</title>
  <link rel="shortcut icon" href="{{asset('/images/logo/Logo.png')}}" type="image/x-icon">

   <link rel="stylesheet" href="{{ asset('css/app.css') }}">
   <link rel="shortcut icon" href="{{asset('/img/logo/MK.png')}}" type="image/x-icon">
    
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}">
   Ionicons -->
  
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
   <!-- Left navbar links -->
   <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link">Welcome, {{Auth::user()->name}}</a>
      </li>
      @can('isVaccineMaker')
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link"><span class="badge badge-success p-1">Current Treshhold: <strong> {{App\Threshold::first()->threshhold}}</strong></span></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link btn btn-primary text-white" data-toggle="modal" data-target="#model-threshhold">set threshold</a>
      </li>
      @endcan
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
    
      <li class="nav-item">
      <a href="#" class="nav-link" data-toggle="modal" data-target="#modelId"> <i class="fas fa-power-off  text-danger  "></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Set threshold modal -->

  <div class="modal fade" id="model-threshhold" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Cases threshold</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <thresh-hold />
      </div>
    </div>
  </div>

  <!-- Logout modal -->
  
  <!-- Modal -->
  <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title text-danger"><i class="fas fa-lock  mr-3  "></i> <strong>End session</strong></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
            </div>
         <form action="{{ route('logout') }}" method="post">
           @csrf
         <div class="modal-body">
          <div class="container-fluid">
            <strong class="text-info">Are you sure you want to logout ?</strong>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" data-dismiss="modal">No, close</button>
          <button type="submit" class="btn btn-danger">Yes,Logout</button>
        </div>
         </form>
      </div>
    </div>
  </div>
   <!-- Logout modal -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar bg-color indigo elevation-1">
   <!-- Brand Logo -->
   <a href="" class="brand-link">
      <img src="{{asset('/images/logo/logo.png')}}" class="brand-imag img-circl elevation-0"
           style="width:50px; height: auto;">
      <span class="brand-text font-weight-light text-info">MEDITEST</span>
    </a>
    <div class="dropdown-divider"></div>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex ">
        <div class="image">
        
          <img src="{{asset('images/avatar/default.jpeg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <router-link to="/profile" class="d-block">{{Auth::user()->name}}</router-link>
          <span class="badge badge-success">{{App\Role::where('id', Auth::user()->role)->value('role')}}</span>
        </div>
      </div>
      <div class="dropdown-divider"></div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <!-- <li class="nav-item has-treeview menu-open">
            <router-link to="/" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt cyan"></i>
              <p>
                <b class="blue">MEDITEST DASH</b>
                <i class="right fas fa-angle-left"></i>
              </p>
            </router-link>
          </li> -->
          <!-- <div class="dropdown-divider"></div> -->
          @can('isVaccineMaker')
          <li class="nav-item">
            <router-link to="/" class="nav-link" class="d-block">
               <i class="fas  blue nav-icon fa-chart-bar    "></i>
              <p>
                Medical Stats
                <span class="right badge badge-success">New</span>
              </p>
            </router-link >
          </li>
         
          <li class="nav-item">
            <router-link to="/volunteers" class="nav-link" class="d-block">
               <i class="fas fa-users purple nav-icon"></i>
              <p>
                 Volunteers
                <span class="right badge badge-info">{{\App\User::all()->count()}}</span>
              </p>
            </router-link >
          </li>

          <li class="nav-item">
            <router-link to="/apirequests" class="nav-link" class="d-block">
               <i class="fab fa-quinscape   nav-icon orange "></i>
              <p>
                 Api Requests
                <span class="right badge badge-info">{{\App\ApiKey::where('status',0)->get()->count()}}</span>
              </p>
            </router-link >
          </li>

          <li class="nav-item">
            <router-link to="/charts" class="nav-link" class="d-block">
               <i class="fas fa-chart-area nav-icon pink "></i>
              <p>
                 Charts
                <span class="right badge badge-info"></span>
              </p>
            </router-link >
          </li>
          @endcan
          <li class="nav-item">
            <router-link to="/test" class="nav-link" class="d-block">
              <i class="fas fa-file-medical  nav-icon teal  "></i>
              <p>
                  Test
                <span class="right badge badge-info"></span>
              </p>
            </router-link >
          </li>
          <li class="nav-item">
            <router-link to="/api" class="nav-link" class="d-block">
              <i class="fas fa-wifi nav-icon  indigo  "></i>
              <p>
                 Api
                <span class="right badge badge-info"></span>
              </p>
            </router-link >
          </li>

          @if(Gate::check('isRegulator') || Gate::check('isVaccineMaker'))
          <li class="nav-item">
            <a href="https://documenter.getpostman.com/view/6602490/TVsydjc1"
             target="blank"
             class="nav-link" class="d-block">
               <i class="fab fa-readme  nav-icon blue  "></i>
              <p>
                 Documentation
                <span class="right badge badge-info"></span>
              </p>
            </a>
          </li>
          @endif
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper cntnt">
   
  <router-view></router-view>
  <vue-progress-bar></vue-progress-bar>
    
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2020<!-- <script>document.write(new Date().getFullYear());</script> --> All rights reserved | Developed with <i class="fas green fa-heart    "></i> by <a href="" target="_blank">MEDITEST</a>
    <div class="float-right d-none d-sm-inline-block">
      <b class="green">MEDITEST</b>
    </div>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@auth 
  <script>
      window.user = @json(auth()->user())
  </script>
@endauth

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>

<script>
</script>
</body>
</html>