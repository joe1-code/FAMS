<!doctype html>
<html lang="en">

    
    <head>
        
        <meta charset="utf-8" />
        <title>Dashboard | Arrears Payment Form.</title>
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
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

        <style>
            .content-layer1 {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 60vh;
                /* background-color: #f7f7f7; */
            }
            .card {
                width: 50%;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .card-header {
                    background: linear-gradient(to right, #f5f5f5, #ffffff); /* Light smoke-like effect */
                    color: black; /* Change text color to black for contrast */
                    text-align: center;
                    font-size: 1.25rem;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Adds some depth */
            }
            .form-group {
                margin-bottom: 1.5rem;
            }
            .monthly_pay_butt {
                text-align: center;
            }
         </style>

    </head>

    <body data-sidebar="dark" data-layout-mode="light">

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
                            <li class="menu-title" key="t-menu">Menu</li>

                            <li>
                                <a href="javascript: void(0);" class="has-arrow waves-effect">
                                    <i class="bx bx-home-circle"></i>
                                    <span key="t-contributions">Contributions</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('landing/homepage') }}" key="t-members">HomePage</a></li>
                                    <li><a href="{{ route('members') }}" key="t-members">Members</a></li>
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
                    <div class="container-fluid p-0">
                        <div class="row m-0">
                            <div class="col-lg-12">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4" style="display: flex; justify-content:center;">ARREARS PAYMENT PROCESS</h4>
                                        <div id="alert" class="fade-out"></div>
                                        <div class="content-layer1">
                                            <div class="card w-90 p-0">
                                                <div class="card-header">
                                                    <small>Arrears Payment</small>
                                                </div>
                                                <div class="card-body">
                                                    <form id="arrears_payment" enctype="multipart/form-data">
                                                        @csrf 
                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label for="member"><small>Select Members</small></label>
                                                                <select class="form-control search-select" id="user_data" name="id" required>
                                                                    <option value="" disabled selected></option>
                                                                    @foreach($memberData as $data)
                                                                        <option value="{{$data->id}}">{{ $data->firstname.' '.$data->lastname }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="document" class="form-label"><small>Upload Document</small></label>
                                                                <input type="file" class="form-control" id="1" name="document">
                                                                @if ($errors->has('document'))
                                                                    <div class="text-danger">
                                                                        {{ $errors->first('document') }}
                                                                    </div>
                                                                @endif
                                                                <div class="invalid-feedback">
                                                                    Please upload a document
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label for="paid_amount" class="form-label"><small>Amount (Tshs.)</small></label>
                                                                <input type="number" class="form-control @error('paid_amount') is-invalid @enderror" id="paid_amount" name="paid_amount" placeholder="Enter Amount" required>
                                                                <div class="text-danger" id="paid_amount_error"></div>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="payment_method"><small>Payment Method</small></label>
                                                                <select class="form-control search-select" id="payment_method" name="payment_method" required>
                                                                    <option value="" disabled selected></option>
                                                                    @foreach($payment_methods as $methods)
                                                                        <option value="{{$methods->id}}">{{ $methods->name }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>

                                                        <input type="hidden" id="module_id" name="module_id" value="1">
                                                        <input type="hidden" id="module_group_id" name="module_group_id" value="1">

                                                        <div class="monthly_pay_butt">
                                                            <button type="submit" class="btn btn-success" id="sbmt"><small>Submit</small></button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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

<!-- CSRF token -->
@push('after-script-end')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    
    $(document).ready(function(){

        let totalArrears = 0;

        $('#user_data').on('change', function(){

            const userID = $(this).val();

            if (userID) {
                
                $.ajax({

                    url: `/api/get_payment_limit/${userID}`,
                    method: 'GET',
                    success: function(response){

                        $totalArrears = response.total_arrears || 0;
                        
                        $('#paid_amount_error').text(`member's total arrears is: Tshs.${$totalArrears}`);
                    },
                    error: function(xhr){

                        console.error('error', xhr);
                        
                        $('#paid_amount_error').text(`error occured while fetching member's total arrears.`);
                    }
                });
            }
        });

        $('#paid_amount').on('input', function(e){
            e.preventDefault();

            const amount = parseFloat($(this).val());            

            if (amount > $totalArrears) {
                
                $('#paid_amount_error').text(`The entered amount (${amount}) exceeds the total arrears (${$totalArrears}).`);
                $('#sbmt').prop('disabled', true);

            }
            else{
                $('#paid_amount_error').text("");
                $('#sbmt').prop('disabled', false);
            }
        });

       $('#arrears_payment').on('submit', function(e){
            e.preventDefault();

            const paid_amount = parseFloat($(this).val());

            if (paid_amount > $totalArrears) {
                Swal.fire({
                title: "Error",
                text: `The entered amount (${enteredAmount}) exceeds the total arrears (${totalArrears}).`,
                icon: "error",
            });

             return;
            }
            
            var formData = new FormData(this);
            console.log(formData);
            
            

            $.ajax({

                url: "{{ route('get_arrears_payment') }}",
                method: "POST",
                data: formData,
                contentType: false,
                processData: false,
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response){

                    Swal.fire({
                    title: "Good job!",
                    text: "You successfully paid your monthly bill!",
                    icon: "success",
                
                    });

                    window.location.reload();

                },
                error: function(xhr,status,error){

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        
                        $('#alert').html('<div class="alert alert-danger">' + xhr.responseJSON.message + '</div>');
                    }
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        
                        $('#alert').html('<div class="alert alert-danger">' + xhr.responseJSON.message + '</div>');
                     }
                    Swal.fire({
                            title: "Error",
                            text: "An error occurred while processing your payment.",
                            icon: "error"
                        });                    
                    console.error(xhr);
                    
                }
            });
       });


    });
</script>
