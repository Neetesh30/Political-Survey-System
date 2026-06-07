<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Project Manager Dashboard</title>
		
		<!-- Favicon -->
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="#">
                
        <!-- Bootstrap CSS -->
        <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/bootstrap.min.css') }}">

        <!-- Fontawesome CSS -->
        <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/font-awesome.min.css') }}">

        <!-- Feathericon CSS -->
        <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/feathericon.min.css') }}">

        <link rel="stylesheet" href="{{ asset('admin_assets/assets/plugins/morris/morris.css') }}">

        <!-- Datatables CSS -->
		<link rel="stylesheet" href="{{ asset('admin_assets/assets/plugins/datatables/datatables.min.css') }}">

        <!-- Main CSS -->
        <link rel="stylesheet" href="{{ asset('admin_assets/assets/css/style.css') }}">
		
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.min.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->

    </head>
    <body>
        <!-- Main Wrapper -->
        <div class="main-wrapper">

            <!-- Header -->
            <div class="header">
            
                <!-- Logo -->
                <div class="header-left">
                    <a href="" class="logo">
                        <img src="{{ asset('homepgast/') }}/images/a1-logo.png" 
                        style="width:90px;" alt="company logo">
                        <img src="{{ asset('homepgast/') }}/images/a1-logo.png" 
                        style="width:90px;" alt="company logo">
                    </a>
                    <a href="" class="logo logo-small">
                        <img src="{{ asset('homepgast/') }}/images/a1-logo.png" height="30">
                        <img src="{{ asset('homepgast/') }}/images/a1-logo.png" height="30">
                    </a>
                </div>
                <!-- /Logo -->
                
                <a href="javascript:void(0);" id="toggle_btn">
                    <i class="fe fe-text-align-left"></i>
                </a>
             
                
                <!-- Mobile Menu Toggle -->
                <a class="mobile_btn" id="mobile_btn">
                    <i class="fa fa-bars"></i>
                </a>
                <!-- /Mobile Menu Toggle -->
                
                <!-- Header Right Menu -->
                <ul class="nav user-menu">
                    
                    <!-- User Menu -->
                    <li class="nav-item dropdown has-arrow">
                        <a href="#" class="dropdown-toggle nav-link" data-toggle="dropdown">
                            <span class="user-img"><img class="rounded-circle" src="{{ asset('/assets/img/profile/')}}/{{auth()->user()->imagepath == NULL ? 'dummy-profile.png': auth()->user()->imagepath}}" width="31" alt="User"></span>
                        </a>
                        <div class="dropdown-menu">
                            <div class="user-header">
                                <div class="avatar avatar-sm">
                                    <img src="{{ asset('/assets/img/profile/')}}/{{auth()->user()->imagepath == NULL ? 'dummy-profile.png': auth()->user()->imagepath}}" alt="User Image" class="avatar-img rounded-circle">
                                </div>
                                <div class="user-text">
                                    <h6>{{auth()->user()->name }}</h6>
                                    <p class="text-muted mb-0">Project Manager</p>
                                </div>
                            </div>
                            <a class="dropdown-item" href="{{ route('projectleader.profile') }}">My Profile</a>
                            
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                        </div>
                    </li>
                    <!-- /User Menu -->
                    
                </ul>
                <!-- /Header Right Menu -->
                
            </div>
            <!-- /Header -->
            
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-inner slimscroll">
                    <div id="sidebar-menu" class="sidebar-menu">
                        <ul>
                            <li class="menu-title"> 
                                <span>Main</span>
                            </li>
                            <li class="{{ 'projectleader' == request()->path() ? 'active':''}}">
                                <a href="{{ route('projectleader.home') }}"><i class="fe fe-home"></i> <span>Dashboard</span></a>
                            </li>
                            <li> 
                                <a href="{{ route('projectleader.manageuserslist') }}"><i class="fe fe-layout"></i> <span>Manage Users</span></a>
                            </li>
                            <li> 
                                <a href="{{ route('projectleader.resources') }}"><i class="fe fe-layout"></i> <span>Resources</span></a>
                            </li>
                            <li> 
                                <a href="{{ route('projectleader.quizs') }}"><i class="fe fe-layout"></i> <span>Courses/Quiz</span></a>
                            </li>
                            <li> 
                                <a href="{{ route('projectleader.feedbacks') }}"><i class="fe fe-layout"></i> <span>Feedbacks</span></a>
                            </li>
                            <li class="submenu"> 
                                <a href="#"><i class="fe fe-layout"></i> <span>Appointment</span><span class="menu-arrow"></span></a>
                                <ul style="display: none;">
									<li><a href="{{ route('projectleader.appointment-scheduling') }}">Appointment Scheduling</a></li>
									<li><a href="{{ route('projectleader.bookedappointmentuserslist') }}">Appointment Booked List</a></li>
								</ul>
                            </li>
                            <li class="submenu">
								<a href="#"><i class="fe fe-document"></i> <span> Reports</span> <span class="menu-arrow"></span></a>
								<ul style="display: none;">
									<li><a href="{{ route('projectleader.masterreport') }}">Master Report</a></li>
								</ul>
							</li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- /Sidebar -->
            
            @yield('content')
            
        </div>
         <!-- /Main Wrapper -->
        


<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
		
<!-- Bootstrap Core JS -->
<script src="{{ asset('admin_assets/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/js/bootstrap.min.js') }}"></script>

<!-- Slimscroll JS -->
<script src="{{ asset('admin_assets/assets/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('admin_assets/assets/plugins/raphael/raphael.min.js') }}"></script>    
<script src="{{ asset('admin_assets/assets/plugins/morris/morris.min.js') }}"></script>  
<script src="{{ asset('admin_assets/assets/js/chart.morris.js') }}"></script>

<!-- Datatables JS -->
<script src="{{ asset('admin_assets/assets/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('admin_assets/assets/plugins/datatables/datatables.min.js') }}"></script>


<!-- Custom JS -->
<script src="{{ asset('admin_assets/assets/js/script.js') }}"></script>

</body>
</html>