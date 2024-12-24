
<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>Dashboard | FAMS - Family Management system.</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- App favicon -->
        <link rel="shortcut icon" href="assets/images/fams-logo.ico">

        <!-- Bootstrap Css -->
        <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

        <style>
            .callout {
                padding: 1.5rem;
                margin: 1rem 0;
                border-left: 4px solid #0d6efd; /* Bootstrap primary color */
                background-color: #e7f1ff; /* Light blue background */
                border-radius: 0.375rem; /* Rounded corners */
            }

            .callout h4 {
                margin-top: 0;
                font-weight: bold;
            }

            .callout p {
                margin-bottom: 0;
            }

            .required-field::after {
                content: " *";
                color: red;
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
             @php
             $doc = $doc ?? \Carbon\Carbon::now();
             @endphp
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="alert alert-primary border-start border-5 border-info rounded-3 p-4 shadow">
                                        <h4 class="alert-heading">Edit Members Particulars.</h4>
                                        <p class="mb-0">Whether an Admin or a member himself or herself can edit the particulars.</p>
                                    </div>
                                </div>

                                <form id="multiStepForm" method="POST" action="{{ route('submit_members', ['id'=>$request->input('member_id')]) }}">
                                    @csrf

                                    <!-- Step 1 -->
                                    <div class="form-step" id="step-1">
                                        <div class="line-separator border-bottom border-1 border-secondary pb-2 mb-4">
                                            <h4 class="d-flex align-items-center">
                                                <i class="fas fa-user me-2"></i> Personal Information
                                            </h4>
                                        </div>
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label for="firstname">Firstname</label>
                                                <input type="text" id="firstname" name="firstname" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="middlename">Middlename</label>
                                                <input type="text" id="lastname" name="lastname" class="form-control" required>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="lastname">Lastname</label>
                                                <input type="text" id="lastname" name="lastname" class="form-control" required>
                                            </div>

                                        </div>

                                        <div class="row col-md-11">
                                            <label for="doc" class="required">
                                                Date of Birth (DOB)
                                            </label>
                                            <div class="row">
                                                <div class="col">
                                                    <select name="dob_day" id="dob_day" class="form-control search-select" style="width:100%;">
                                                        <option value="" disabled></option>
                                                        @for ($i = 1; $i <= 31; $i++)
                                                            <option value="{{ $i }}" {{ $doc->format('j') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select name="dob_month" class="form-control search-select" style="width:100%;">
                                                        <option value="" disabled></option>
                                                        @for ($i = 1; $i <= 12; $i++)
                                                            <option value="{{ $i }}" {{ $doc->format('n') == $i ? 'selected' : '' }}>
                                                                {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                                            </option>
                                                        @endfor
                                                    </select>
                                                </div>
                                                <div class="col">
                                                    <select name="dob_year" class="form-control search-select" style="width:100%;">
                                                        <option value="" disabled></option>
                                                        @for ($year = now()->format('Y'); $year >= 1900; $year--)
                                                            <option value="{{ $year }}" {{ $doc->format('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                        @endfor
                                                    </select>
                                                </div>

                                                    <!-- Add Monthly Earnings to the Row -->
                                                <div class="col-md-6">
                                                <label for="monthly_earning">Monthly Earnings</label>

                                                    <div class="form-group">
                                                        <input type="number" id="monthly_earning" name="monthly_earning" class="form-control" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <input type="hidden" name="doc" />
                                            <input type="hidden" name="today_date" value="{{ getTodayDate() }}" />

                                            <span class="form-text text-muted">
                                                <p></p>
                                            </span>
                                            

                                        </div>

                                        <div class="row col-md-11">
                                            <div class="form-group col-md-4">
                                                <label for="tin_no" class="required-field">TIN No.</label>
                                                <input type="number" id="tin_no" name="tin_no" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="nida_no" class="required-field">National Identification Number (NIDA).</label>
                                                <input type="number" id="nida_no" name="nida_no" class="form-control" required>
                                            </div>

                                        </div>

                                        <div class="row col-md-11">
                                            <div class="form-group col-md-4">
                                                <label for="passport_no" class="required-field">Passport No.</label>
                                                <input type="number" id="passport_no" name="passport_no" class="form-control" required>
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label for="countries" class="required-field">Country.</label>
                                                <select name="country" id="country" class="form-control">
                                                    <option value="">Select</option>
                                                    @foreach($countries as $country)
                                                    <option value="{{ $country->id}}">{{ $country->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            

                                        </div>

                                        
                                        <button type="button" class="btn btn-primary next-btn">Next</button>
                                    </div>

                                    <!-- Step 2 -->
                                    <div class="form-step" id="step-2" style="display: none;">
                                        <h4>Step 2: Contact Details</h4>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" id="email" name="email" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="phone">Phone</label>
                                            <input type="text" id="phone" name="phone" class="form-control" required>
                                        </div>
                                        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                                        <button type="button" class="btn btn-primary next-btn">Next</button>
                                    </div>

                                    <!-- Step 3 -->
                                    <div class="form-step" id="step-3" style="display: none;">
                                        <h4>Step 3: Job Details</h4>
                                        <div class="form-group">
                                            <label for="job_title">Job Title</label>
                                            <input type="text" id="job_title" name="job_title" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label for="designation">Designation</label>
                                            <select id="designation" name="designation" class="form-control">
                                                <option value="">Select</option>
                                                @foreach($designations as $designation)
                                                    <option value="{{ $designation->id }}">{{ $designation->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button type="button" class="btn btn-secondary prev-btn">Previous</button>
                                        <button type="submit" class="btn btn-success">Submit</button>
                                    </div>
                                </form>
                                
                            </div>
                        </div>
                    </div>
                </div>

            <div>
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>

document.addEventListener("DOMContentLoaded", () => {
    const steps = document.querySelectorAll(".form-step");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");

    let currentStep = 0;

    const showStep = (step) => {
        steps.forEach((formStep, index) => {
            formStep.style.display = index === step ? "block" : "none";
        });
    };

    nextBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            saveData();
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    const saveData = () => {
        const inputs = steps[currentStep].querySelectorAll("input, select");
        inputs.forEach((input) => {
            localStorage.setItem(input.name, input.value);
        });
    };

    const loadData = () => {
        const inputs = document.querySelectorAll("input, select");
        inputs.forEach((input) => {
            input.value = localStorage.getItem(input.name) || "";
        });
    };

    loadData();
    showStep(currentStep);
});

</script>
