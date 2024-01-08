<!DOCTYPE html>

@php
	use App\Http\Controllers\NotificationController;
	
	$isunreadAny = NotificationController::hasUnreadNotifications();
	
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Armora</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/images/favicon.ico') }}">

    <!-- Yielded stack for page-specific CSS -->
    @stack('page-css')

    <!-- App css -->
    <link href="{{ asset('admin/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('admin/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />
    <link href="{{ asset('admin/assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />



</head>

<body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid"
    data-rightbar-onstart="true">
    <!-- Begin page -->
    <div class="wrapper">
        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-light">
                <span class="logo-lg">
                    <img src="{{ asset('admin/assets/images/logo.png') }}" alt="" height="30">
                </span>
                <span class="logo-sm">
                    <img src="{{ asset('admin/assets/images/logo_sm.png') }}" alt="" height="30">
                </span>
            </a>

            <!-- LOGO -->
            <a href="index.html" class="logo text-center logo-dark">
                <span class="logo-lg">
                    <img src="admin/assets/images/logo-dark.png" alt="" height="30">
                </span>
                <span class="logo-sm">
                    <img src="admin/assets/images/logo_sm_dark.png" alt="" height="30">
                </span>
            </a>

            <div class="h-100" id="leftside-menu-container" data-simplebar>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title side-nav-item">Navigation</li>


                    <li class="side-nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="side-nav-link">
                            <i class="uil-home-alt"></i>
                            <span> Dashboard </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarIconsvulnerabilities" aria-expanded="true"
                            aria-controls="sidebarIcons" class="side-nav-link">
                            <i class="mdi mdi-fire-circle"></i>
                            <span> vulnerabilities </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarIconsvulnerabilities" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('admin.vulnerability') }}">All</a>
                                </li>
                                <li>
                                    <a href=" {{ route('admin.systems') }}">System</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.scan-reports') }}">Report</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarIcons" aria-expanded="true"
                            aria-controls="sidebarIcons" class="side-nav-link">
                            <i class=" mdi mdi-desktop-mac"></i>
                            <span> Devices </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarIcons" style="">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a id="btn-new-client-1">Add Device</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.devices') }}">All Devices</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <!-- Info message -->
                    <!--
<a class="btn btn-info" onclick="toastr.info('Hi! I am info message.');">Info message</a>
<a class="btn btn-warning" onclick="toastr.warning('Hi! I am warning message.');">Warning message</a>
<a class="btn btn-success" onclick="toastr.success('Hi! I am success message.');">Success message</a>
<a class="btn btn-danger" onclick="toastr.error('Hi! I am error message.');">Error message</a>
-->
                </ul>

                <div class="clearfix"></div>

            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">
                <!-- Topbar Start -->
                <div class="navbar-custom">
                    <ul class="list-unstyled topbar-menu float-end mb-0">
                       

                         <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false" id="notification-button">
                                <i class="dripicons-bell noti-icon"></i>
								
								@if($isunreadAny)
									<span class="noti-icon-badge"></span>
								@endif
                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg">

                                <!-- item-->
                                <div class="dropdown-item noti-title px-3">
                                    <h5 class="m-0">
                                        <span class="float-end">
                                            <a href="javascript: void(0);" class="text-dark" id="mark-as-unread">
                                                <small>Unread All</small>
                                            </a>
                                        </span>Notification
                                    </h5>
                                </div>

                                <div class="px-3" style="max-height: 300px;" data-simplebar >
									<div id='notification-menu'>
									</div>
                                </div>

                                <!-- All-->
                                <a href="javascript:void(0);" class="dropdown-item text-center text-primary notify-item border-top border-light py-2" id="mark-as-read">
                                    Mark as Read
                                </a>

                            </div>
                        </li>

                        <li class="notification-list" >
                            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                                <i class="dripicons-gear noti-icon"></i>
                            </a>
                        </li>

                        <li class="dropdown notification-list">
                            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown"
                                href="#" role="button" aria-haspopup="false" aria-expanded="false">
                                <span class="account-user-avatar">
                                    <img src="{{ asset(auth()->user()->profile_image ? 'storage/'.auth()->user()->profile_image : 'admin/assets/images/users/avatar-1.jpg') }}" alt="user-image"
                                        class="rounded-circle">
                                </span>
                                <span>
                                    <span class="account-user-name">{{ auth()->user()->name }}</span>
									<span class="account-position">Admin</span>
                                </span>
                            </a>
                            <div
                                class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                                <!-- item-->
                                <div class=" dropdown-header noti-title">
                                    <h6 class="text-overflow m-0">Welcome !</h6>
                                </div>

                                <!-- item-->
                                <a href="{{ route('admin.profile') }}" class="dropdown-item notify-item">
                                    <i class="mdi mdi-account-edit me-1"></i>
                                    <span>Edit Profile</span>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item end-bar-toggle">
                                    <i class="mdi dripicons-gear me-1"></i>
                                    <span>Settings</span>
                                </a>

                               
                                <!-- item-->
								<form method="POST" id="logout-form" action="{{ route('logout') }}" style="display: inline;">
								@csrf
									<a href="javascript:void(0);" class="dropdown-item notify-item" onclick="document.getElementById('logout-form').submit()">
										<i class="mdi mdi-logout me-1"></i>
										<span>Logout</span>
									</a>
								</form>
                            </div>
                        </li>

                    </ul>
                    <button class="button-menu-mobile open-left">
                        <i class="mdi mdi-menu"></i>
                    </button>
                    <div class="app-search dropdown d-none d-lg-block">
                        <!--
						<form>
                            <div class="input-group">
                                <input type="text" class="form-control dropdown-toggle" placeholder="Search..."
                                    id="top-search">
                                <span class="mdi mdi-magnify search-icon"></span>
                                <button class="input-group-text btn-primary" type="submit">Search</button>
                            </div>
                        </form>-->

                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h5 class="text-overflow mb-2">Found <span class="text-danger">17</span> results</h5>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-copy-alt font-16 me-1"></i>
                                <span>Analytics Report</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="uil-copy-alt font-16 me-1"></i>
                                <span>How can I help you?</span>
                            </a>

                        </div>
                    </div>
                </div>
                <!-- end Topbar -->


                @yield('main-body')


            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                            document.write(new Date().getFullYear())
                            </script> © Armora
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->


    <!-- Right Sidebar -->
    <div class="end-bar">

        <div class="rightbar-title">
            <a href="javascript:void(0);" class="end-bar-toggle float-end">
                <i class="dripicons-cross noti-icon"></i>
            </a>
            <h5 class="m-0">Settings</h5>
        </div>

        <div class="rightbar-content h-100" data-simplebar>

            <div class="p-3">
                <div class="alert alert-warning" role="alert">
                    <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                </div>

                <!-- Settings -->
                <h5 class="mt-3">Color Scheme</h5>
                <hr class="mt-1" />

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="light"
                        id="light-mode-check" checked>
                    <label class="form-check-label" for="light-mode-check">Light Mode</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="color-scheme-mode" value="dark"
                        id="dark-mode-check" >
                    <label class="form-check-label" for="dark-mode-check">Dark Mode</label>
                </div>


                <!-- Width -->
                <h5 class="mt-4">Width</h5>
                <hr class="mt-1" />
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="width" value="fluid" id="fluid-check" checked>
                    <label class="form-check-label" for="fluid-check">Fluid</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="width" value="boxed" id="boxed-check">
                    <label class="form-check-label" for="boxed-check">Boxed</label>
                </div>


                <!-- Left Sidebar-->
                <h5 class="mt-4">Left Sidebar</h5>
                <hr class="mt-1" />
                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="theme" value="default" id="default-check">
                    <label class="form-check-label" for="default-check">Default</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="theme" value="light" id="light-check" checked>
                    <label class="form-check-label" for="light-check">Light</label>
                </div>

                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="theme" value="dark" id="dark-check">
                    <label class="form-check-label" for="dark-check">Dark</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="fixed" id="fixed-check"
                        checked>
                    <label class="form-check-label" for="fixed-check">Fixed</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="condensed"
                        id="condensed-check">
                    <label class="form-check-label" for="condensed-check">Condensed</label>
                </div>

                <div class="form-check form-switch mb-1">
                    <input class="form-check-input" type="checkbox" name="compact" value="scrollable"
                        id="scrollable-check">
                    <label class="form-check-label" for="scrollable-check">Scrollable</label>
                </div>

                <div class="d-grid mt-4">
                    <button class="btn btn-primary" id="resetBtn">Reset to Default</button>
                </div>
            </div> <!-- end padding-->

        </div>
    </div>


    <!-- Add New client MODAL -->
    <div class="modal fade" id="client-modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form class="needs-validation" novalidate action="{{ route('admin.create-device') }}" method="POST">
                    @csrf
                    <div class="modal-header py-3 px-4 border-bottom-0">
                        <h5 class="modal-title" id="modal-title">Add Client</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body px-4 pb-4 pt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="control-label form-label">Client Name</label>
                                    <input class="form-control" placeholder="Insert Client Name" type="text"
                                        name="system_name" id="client-title" required />
                                    <div class="invalid-feedback">Please provide a valid client name</div>
                                </div>

                                <div class="mb-3">
                                    <label class="control-label form-label">MAC Address</label>
                                    <input class="form-control" placeholder="00-B0-D0-63-C2-26" type="text"
                                        name="mac_address" required />
                                    <div class="invalid-feedback">Please provide a valid MAC Address</div>
                                </div>

                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="control-label form-label">Operating System</label>
                                        <select class="form-select" name="operating_system" id="event-category"
                                            required>
                                            <option value="window" selected>Window</option>
                                            <option value="linux">Linux</option>
                                        </select>
                                        <div class="invalid-feedback">Please select a valid operating system</div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-12 text-end">
                                <button type="button" class="btn btn-light me-1" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div> <!-- end modal-content-->
        </div> <!-- end modal dialog-->
    </div>
    <!-- end modal-->


    <div class="rightbar-overlay"></div>
    <!-- /End-bar -->


    <input type="hidden" id="validationErrors" name="validation_errors" value="{{ json_encode($errors->toArray()) }}">
    <!-- bundle -->
    <script src="{{ asset('admin/assets/js/vendor.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/app.min.js') }}"></script>
    <script src="{{ asset('admin/assets/js/toastr.min.js') }}"></script>


    <script src="{{ asset('admin/assets/js/pages/popup.js') }}"></script>

    <script>
    // Laravel validation error messages
    @if($errors -> any())
    @foreach($errors -> all() as $error)
    toastr.error('{{$error}}');
    @endforeach
    @elseif(isset($success))
    toastr.success('{{ $success }}');
    @endif
    </script>



	<script>

		$(document).on('click', '#notification-button', function () {
			$('#notification-menu').html('<div class="text-center"><i class="mdi mdi-dots-circle mdi-spin text-muted h3 mt-0"></i></div>');

			$.ajax({
				url: '/notification', 
				type: 'GET',
				success: function (response) {
					$('#notification-menu').html(response.html);
				},
				error: function (error) {
					console.error('Error:', error);
				}
			});
		});
		
		$(document).on('click', '#mark-as-read', function () {
			
			$.ajax({
				url: '/notification/read-all', 
				type: 'GET',
				success: function (response) {
					toastr.success("Notifications marked as read");
				},
				error: function (error) {
					toastr.error(error);
				}
			});
		});
		
		$(document).on('click', '#mark-as-unread', function () {
			
			$.ajax({
				url: '/notification/unread-all', 
				type: 'GET',
				success: function (response) {
					toastr.success("Notifications marked as un-read");
				},
				error: function (error) {
					toastr.error(error);
				}
			});
		});
		
		
		
	</script>

    <!-- Yielded stack for page-specific JS -->
    @stack('page-js')

</body>

</html>