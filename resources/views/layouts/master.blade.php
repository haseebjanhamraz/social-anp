<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>@yield('Title','Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{asset('assets/css/app.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/bundles/morris/morris.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  <!-- Template CSS -->
  <link rel="stylesheet" href="{{asset('assets/bundles/bootstrap-social/bootstrap-social.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
  <link rel="stylesheet" href="{{asset('assets/css/components.css')}}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
  <link rel='shortcut icon' type='image/x-icon' href='{{asset('assets/img/favicon.ico')}}' />
  <link rel="stylesheet" href="{{asset('assets/bundles/pretty-checkbox/pretty-checkbox.min.css')}}">
  @yield('styles')
</head>

<body>
  <div id="loader"></div>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
          
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
     
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{asset('assets/img/user.png')}}"
                class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Salman Khan</div>
            
              <div class="dropdown-divider"></div>
              <a href="" class="dropdown-item has-icon text-danger" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                 <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="index.html"> <img alt="image" src="{{asset('assets/img/logo.png')}}" class="header-logo" /> <span
                class="logo-name">Otika</span>
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            @can('view admin dashboard')
            <li class="dropdown {{request()->routeIs('admin.dashboard') ? 'active' : ''}}">
              <a href="{{route('admin.dashboard')}}" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @endcan

            <li class="dropdown {{request()->routeIs('dashboard.users.all') ? 'active' : ''}}">
              <a href="{{route('dashboard.users.all')}}" class=" nav-link"><i
                  data-feather="users"></i><span>Users</span></a>
            </li>

            @can('view admin')
             <li class="dropdown {{request()->routeIs('dashboard.admins.all') ? 'active' : ''}}">
              <a href="{{route('dashboard.admins.all')}}" class=" nav-link"><i
                  data-feather="users"></i><span>Admins</span></a>
            </li>
            @endcan

            @can('view facebook posts')
             <li class="dropdown {{request()->routeIs('facebook.posts') ? 'active' : ''}}">
              <a href="{{route('facebook.posts')}}" class=" nav-link"><i
                  data-feather="facebook"></i><span>Facebook Posts</span></a>
            </li>
              <li class="dropdown {{request()->routeIs('twitter.posts') ? 'active' : ''}}">
              <a href="#" class=" nav-link"><i
                  data-feather="twitter"></i><span>Twitter Posts</span></a>
            </li>
              <li class="dropdown {{request()->routeIs('instagram.posts') ? 'active' : ''}}">
              <a href="#" class=" nav-link"><i
                  data-feather="instagram"></i><span>Instagram Posts</span></a>
            </li>
            @endcan

            @can('view user dashboard')
            <li class="dropdown {{request()->routeIs('users.dashboard') ? 'active' : ''}}">
              <a href="{{route('users.dashboard')}}" class=" nav-link"><i
                  data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            @endcan

            @can('view own posts')
            <li class="dropdown {{request()->routeIs('user.facebook.posts') ? 'active' : ''}}">
              <a href="{{route('user.facebook.posts')}}" class=" nav-link"><i
                  data-feather="book"></i><span>Facebook Posts</span></a>
            </li>
            @endcan

            @can('sync facebook')
             <li class="dropdown {{request()->routeIs('dashboard.posts.sync') ? 'active' : ''}}">
              <a href="{{route('dashboard.posts.sync')}}" class=" nav-link">
                <i data-feather="refresh-ccw"></i><span>Synchronization</span></a>
            </li>
            @endcan
          </ul>
        </aside>
      </div>
      <!-- Main Content -->
      <div class="main-content">
        @yield('content')
        <div class="settingSidebar">
          <a href="javascript:void(0)" class="settingPanelToggle"> <i class="fa fa-spin fa-cog"></i>
          </a>
          <div class="settingSidebar-body ps-container ps-theme-default">
            <div class=" fade show active">
              <div class="setting-panel-header">Setting Panel
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Select Layout</h6>
                <div class="selectgroup layout-color w-50">
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="1" class="selectgroup-input-radio select-layout" checked>
                    <span class="selectgroup-button">Light</span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="value" value="2" class="selectgroup-input-radio select-layout">
                    <span class="selectgroup-button">Dark</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Sidebar Color</h6>
                <div class="selectgroup selectgroup-pills sidebar-color">
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="1" class="selectgroup-input select-sidebar">
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Light Sidebar"><i class="fas fa-sun"></i></span>
                  </label>
                  <label class="selectgroup-item">
                    <input type="radio" name="icon-input" value="2" class="selectgroup-input select-sidebar" checked>
                    <span class="selectgroup-button selectgroup-button-icon" data-toggle="tooltip"
                      data-original-title="Dark Sidebar"><i class="fas fa-moon"></i></span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <h6 class="font-medium m-b-10">Color Theme</h6>
                <div class="theme-setting-options">
                  <ul class="choose-theme list-unstyled mb-0">
                    <li title="white" class="active">
                      <div class="white"></div>
                    </li>
                    <li title="cyan">
                      <div class="cyan"></div>
                    </li>
                    <li title="black">
                      <div class="black"></div>
                    </li>
                    <li title="purple">
                      <div class="purple"></div>
                    </li>
                    <li title="orange">
                      <div class="orange"></div>
                    </li>
                    <li title="green">
                      <div class="green"></div>
                    </li>
                    <li title="red">
                      <div class="red"></div>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="mini_sidebar_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Mini Sidebar</span>
                  </label>
                </div>
              </div>
              <div class="p-15 border-bottom">
                <div class="theme-setting-options">
                  <label class="m-b-0">
                    <input type="checkbox" name="custom-switch-checkbox" class="custom-switch-input"
                      id="sticky_header_setting">
                    <span class="custom-switch-indicator"></span>
                    <span class="control-label p-l-10">Sticky Header</span>
                  </label>
                </div>
              </div>
              <div class="mt-4 mb-4 p-3 align-center rt-sidebar-last-ele">
                <a href="#" class="btn btn-icon icon-left btn-primary btn-restore-theme">
                  <i class="fas fa-undo"></i> Restore Default
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <footer class="main-footer">
        <div class="footer-left">
          <a href="templateshub.net">Templateshub</a></a>
        </div>
        <div class="footer-right">
        </div>
      </footer>
    </div>
  </div>


  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

  <script>

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });


   function showLoader(){
    $('#loader').html(`<div class="loader"></div>`);
  }
  function hideLoader(){
    $('#loader').empty();
  }
  function showSwalMessage(icon,title,message,timeout = 3000){
    Swal.fire({
        icon: icon,
        title: title,
        timer: timeout,
        text: message,
    })
  }

  </script>

  <!-- General JS Scripts -->
  <script src="{{asset('assets/js/app.min.js')}}"></script>
  <!-- JS Libraies -->
  <script src="{{asset('assets/bundles/apexcharts/apexcharts.min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('assets/js/page/index.js')}}"></script>
  <!-- Template JS File -->
  <script src="{{asset('assets/js/scripts.js')}}"></script>
  <!-- Custom JS File -->
  <script src="{{asset('assets/js/custom.js')}}"></script>

  <!-- JS Libraies -->
  <script src="{{asset('assets/bundles/morris/morris.min.js')}}"></script>
  <script src="{{asset('assets/bundles/morris/raphael-min.js')}}"></script>
  <!-- Page Specific JS File -->
  <script src="{{asset('assets/js/page/chart-morris.js')}}"></script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</body>

@yield('scripts')
<!-- index.html  21 Nov 2019 03:47:04 GMT -->
</html>