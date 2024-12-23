
<!doctype html>
<html lang="en">
    <style>

        th {
            background-color: #e3f2fd;
        }
        .over15color{
            background-color: #e6771c;
        }
        .incidentMonth{
            background-color: #e3f2fd;
        }



    </style>
@php
$active = $memberData->where('active', 1)->count();
$inactive = $memberData->where('active', 0)->count();
@endphp
    
<!-- Mirrored from themesbrand.com/skote/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Oct 2022 14:34:47 GMT -->
<head>
        <meta charset="utf-8" />
        <title>Dashboard | FAMS - Family Management system.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/favicon.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">


    </head>

    <body data-sidebar="dark" data-layout-mode="light">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        <div id="layout-wrapper">

            
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                            <a href="index.html" class="logo logo-dark">
                                <span class="logo-sm">
                                    <img src="assets/images/logo.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-dark.png" alt="" height="17">
                                </span>
                            </a>

                            <a href="index.html" class="logo logo-light">
                                <span class="logo-sm">
                                    <img src="assets/images/logo-light.svg" alt="" height="22">
                                </span>
                                <span class="logo-lg">
                                    <img src="assets/images/logo-light.png" alt="" height="19">
                                </span>
                            </a>
                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars"></i>
                        </button>

                    </div>

                    <div class="d-flex">

                        <div class="dropdown d-inline-block d-lg-none ms-2">
                            <button type="button" class="btn header-item noti-icon waves-effect" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-magnify"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                                aria-labelledby="page-header-search-dropdown">
        
                                <form class="p-3">
                                    <div class="form-group m-0">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Search ..." aria-label="Recipient's username">
                                            <div class="input-group-append">
                                                <button class="btn btn-primary" type="submit"><i class="mdi mdi-magnify"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>


                        <div class="dropdown d-none d-lg-inline-block ms-1">
                            <button type="button" class="btn header-item noti-icon waves-effect" data-bs-toggle="fullscreen">
                                <i class="bx bx-fullscreen"></i>
                            </button>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="assets/images/users/user4.png"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key=""></span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}" method="POST"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                            </div>
                        </div>

                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item noti-icon right-bar-toggle waves-effect">
                                <i class="bx bx-cog bx-spin"></i>
                            </button>
                        </div>

                    </div>
                </div>
            </header>

            <!-- ========== Left Sidebar Start ========== -->
            <div class="vertical-menu">

                <div data-simplebar class="h-100">

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">
                        <!-- Left Menu Start -->
                        <ul class="metismenu list-unstyled" id="side-menu">
                            <li class="menu-title" key="t-menu">Fund Items List</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-group"></i>
                                    <span key="t-contributions">Membership</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('landing/homepage') }}" key="t-members">HomePage</a></li>
                                    <li><a href="{{ route('members') }}" key="t-members">Members List</a></li>
                                    <li><a href="#" key="t-members">Register Members</a></li>
                                    <!-- <li><a href="dashboard-job.html"><span class="badge rounded-pill text-bg-success float-end" key="t-new">New</span> <span key="t-jobs">Jobs</span></a></li> -->
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-credit-card"></i>
                                    <span key="t-contributions">Contributions</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('payments') }}" method='POST' key="t-payments">Monthly Payments</a></li>
                                    <li><a href="{{ route('monthly_arrears') }}" key="t-arrears">Monthly Arrears</a></li>
                                    <!-- <li><a href="dashboard-job.html"><span class="badge rounded-pill text-bg-success float-end" key="t-new">New</span> <span key="t-jobs">Jobs</span></a></li> -->
                                </ul>
                            </li>

                        </ul>
                    </div>
                    <!-- Sidebar -->
                </div>
            </div>
            <!-- Left Sidebar End -->

            

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
                        <!-- <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Dashboard</h4>

                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div>

                                </div>
                            </div>
                        </div> -->
                        <!-- end page title -->


<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                 <h4 class="card-title mb-4">Welcome</h4>
                <div class="row">
        <div class="col-md-6">
            <div>&nbsp;</div>
            <div class="computation-group">
                <table class="table table-bordered" style="text-align: center; background-color: #e3f2fd ;">
                    <thead>
                    <th style="text-align: center">Full Names</th>
                    <!-- <th style="text-align: right">Title</th> -->
                    <!-- <th style="text-align: right">Total Contributions</th> -->
                    <th style="text-align: center">Phone</th>
                    <th style="text-align: center">Region</th>
                    <th style="text-align: center">Action</th>
                    </thead>
                    <tbody>
                    <!-- @php
                        try {
                            if (isset($contribution_history['contributions']) && is_countable($contribution_history['contributions']) && count($contribution_history['contributions'])) {
                                   end($contribution_history['contributions']); // Move pointer to last index
                                    $last_index = key($contribution_history['contributions']);
                            }
                             // get key of last index (where pointer is)
                        } catch (\Throwable $e) {
                            \Illuminate\Support\Facades\Log::info($e->getMessage());
                            $last_index = 0;
                        }
                    @endphp -->
                    @foreach($memberData as $data)
                        <tr class="" style="text-align: left">
                            <td>{{ $data->firstname.' '.$data->middlename.' '.$data->lastname }}</td>
                                <td style="text-align: right">
                                    {{ $data->phone }}
                                </td>
                            <td class="" style="text-align: center">{{$data->region_name}}</td>
                            @if($data->active == true)
                            <td style="text-align: right;">
                                <button class="btn btn-secondary site-btn" style="font-weight: normal; background-color: white; color: black;">
                                    <i class="fas fa-pencil-alt" aria-hidden="true" style="color: black;"></i> Deactivate
                                </button>
                            </td>

                            @else
                            
                            <td style="text-align: right;">
                                <button class="btn btn-secondary site-btn" style="font-weight: normal; background-color: white; color: black;">
                                    <i class="fas fa-pencil-alt" aria-hidden="true" style="color: black;"></i> Activate
                                </button>
                            </td>
                            @endif
                                <!-- <td class="over15color" style="text-align: center">{{ 10 .'%'}}</td> -->
                        </tr>
                     @endforeach   
                    </tbody>

                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th colspan="4" style="text-align: center; background-color: #e3f2fd ;">REGISTERED MEMBERS</th></tr>
                    <tr><th style="text-align: center; background-color: green;">Active</th>
                        <!-- <th>Amount</th> -->
                            <th style="text-align: center; background-color:#e6771c;">Inactive</th>
                        <!-- <th>Remark</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td style="text-align: center;">{{ $active }}</td>
                        <!-- <td> {{ 5600 }} </td> -->
                            <td style="text-align: center;">
                                {{ $inactive }}
                            </td>
                        <!-- <td>{{ 'Need Review' }}</td> -->
                    </tr>
                    </tbody>
                </table>

                <table class="table table-bordered">
                    <tr>
                        <th colspan="4" style="text-align: center; background-color: #e3f2fd ;">CHAIRPERSON</th></tr>
                        <th>Full Names</th>
                        <td>{{ $data->firstname.' '.$data->middlename.' '.$data->lastname }}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td> {{ 29 }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td> {{ 29 }}</td>
                    </tr>
                    
                </table>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4" style="text-align: center; background-color: #e3f2fd ;">GENERAL SECRETARY</th></tr>
                        <th>Full Names</th>
                        <td>{{ $data->firstname.' '.$data->middlename.' '.$data->lastname }}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td> {{ 29 }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td> {{ 29 }}</td>
                    </tr>
                    
                </table>
                <table class="table table-bordered">
                    <tr>
                        <th colspan="4" style="text-align: center; background-color: #e3f2fd ;">ACCOUNTANT</th></tr>
                        <th>Full Names</th>
                        <td>{{ $data->firstname.' '.$data->middlename.' '.$data->lastname }}</td>
                    </tr>
                    <tr>
                        <th>Age</th>
                        <td> {{ 29 }}</td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td> {{ 29 }}</td>
                    </tr>
                    
                </table>
            </div>
                
                </div>
           
        </div>
        <div>&nbsp;</div>

        </div>
        <div>&nbsp;</div>
        <legend></legend>
        <div>&nbsp;</div>

       
                <!-- <table class="table table-bordered">
                    <tr><th class="active">Active Members: </th>
                        <td class="badge bg-success">{{ $active }}</td>
                        <th>Inactive Members: </th>
                        <td  class="badge bg-warning"> {{ $inactive }} </td>
                    </tr>
                </table> -->


           
            </div>
        </div>
    </div>
</div>

<!-- Transaction Modal -->


                <!-- end modal -->

                <!-- subscribeModal -->
                <!-- <div class="modal fade" id="subscribeModal" tabindex="-1" aria-labelledby="subscribeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-bottom-0">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="text-center mb-4">
                                    <div class="avatar-md mx-auto mb-4">
                                        <div class="avatar-title bg-light rounded-circle text-primary h1">
                                            <i class="mdi mdi-email-open"></i>
                                        </div>
                                    </div>

                                    <div class="row justify-content-center">
                                        <div class="col-xl-10">
                                            <h4 class="text-primary">Subscribe !</h4>
                                            <p class="text-muted font-size-14 mb-4">Subscribe our newletter and get notification to stay update.</p>

                                            <div class="input-group bg-light rounded">
                                                <input type="email" class="form-control bg-transparent border-0" placeholder="Enter Email address" aria-label="Recipient's username" aria-describedby="button-addon2">
                                                
                                                <button class="btn btn-primary" type="button" id="button-addon2">
                                                    <i class="bx bxs-paper-plane"></i>
                                                </button>
                                                
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
                <!-- end modal -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>document.write(new Date().getFullYear())</script> © FAMS.
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Design & Develop by FAMS.
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center px-3 py-4">
            
                    <h5 class="m-0 me-2">Settings</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="mt-0" />
                <h6 class="text-center mb-0">Choose Layouts</h6>

                <div class="p-4">
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-1.jpg" class="img-thumbnail" alt="layout images">
                    </div>

                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="light-mode-switch" checked>
                        <label class="form-check-label" for="light-mode-switch">Light Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-2.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-mode-switch">
                        <label class="form-check-label" for="dark-mode-switch">Dark Mode</label>
                    </div>
    
                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-3.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input theme-choice" type="checkbox" id="rtl-mode-switch">
                        <label class="form-check-label" for="rtl-mode-switch">RTL Mode</label>
                    </div>

                    <div class="mb-2">
                        <img src="assets/images/layouts/layout-4.jpg" class="img-thumbnail" alt="layout images">
                    </div>
                    <div class="form-check form-switch mb-5">
                        <input class="form-check-input theme-choice" type="checkbox" id="dark-rtl-mode-switch">
                        <label class="form-check-label" for="dark-rtl-mode-switch">Dark RTL Mode</label>
                    </div>

            
                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>

        <!-- apexcharts -->
        <script src="assets/libs/apexcharts/apexcharts.min.js"></script>

        <!-- dashboard init -->
        <script src="assets/js/pages/dashboard.init.js"></script>

        <!-- App js -->
        <script src="assets/js/app.js"></script>
    </body>


<!-- Mirrored from themesbrand.com/skote/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Oct 2022 14:37:45 GMT -->
</html>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const viewDetailsButtons = document.querySelectorAll('.view-details-btn');

    viewDetailsButtons.forEach(button => {
        button.addEventListener('click', function() {
            const memberId = this.getAttribute('data-id');
            const memberName = this.getAttribute('data-name');

            document.getElementById('member-id').textContent = memberId;
            document.getElementById('member-name').textContent = memberName;
            document.getElementById('edit-member-id').value = memberId;
        });
    });
});
</script>
