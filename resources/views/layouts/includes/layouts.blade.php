
<!doctype html>
<html lang="en">

    
<head>
        
        <meta charset="utf-8" />
        <title>Membership | FAMS - Family Management system.</title>
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

            #surveyed_area_descrpition {
                padding: 0px;
                margin: 0;
                line-height: 1.5;
                vertical-align: top;
                box-sizing: border-box; /* Ensures padding is included in width/height */
                font-size: 16px; /* Match the font size to your design */
            }
            #unsurveyed_area_descrpition {
                padding: 0px;
                margin: 0;
                line-height: 1.5;
                vertical-align: top;
                box-sizing: border-box; /* Ensures padding is included in width/height */
                font-size: 16px; /* Match the font size to your design */
            }

            .container {
                display: flex;
                align-items: flex-start;
                gap: 20px;
            }

            .vertical-step-indicator-container {
                width: 100px;
                text-align: center;
                display: flex;
                justify-content: center;
                /* background-color: red; */
            }

            .vertical-step-indicator {
                list-style: none;
                padding: 0;
                margin: 0;
                display: flex;
                flex-direction: column;
                gap: 20px;
            }

            .step-item {
                width: 40px;
                height: 40px;
                line-height: 40px;
                border-radius: 50%;
                background-color: #ddd;
                color: #fff;
                font-weight: bold;
                font-size: 16px;
                transition: background-color 0.3s, color 0.3s;
            }

            .step-item.active {
                background-color: #007bff;
                color: #fff;
            }

            .step-item.completed {
                background-color: #28a745;
                color: #fff;
            }

            .form-container {
                flex: 1;
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

                                <div class="container d-flex">
                                    <!-- Vertical Step Indicator -->
                                    <div class="vertical-step-indicator-container">
                                        <ul class="vertical-step-indicator">
                                            <li class="step-item active" data-step="0">1</li>
                                            <span>Personal Information</span>
                                            <li class="step-item" data-step="1">2</li>
                                            <span>Contact Details</span>
                                            <li class="step-item" data-step="2">3</li>
                                            <span>Professional Details</span>
                                        </ul>
                                    </div>

                                    <!-- Multi-step Form -->
                                    <div class="form-container">
                                        <form id="multiStepForm" method="POST" action="">
                                            @csrf
                                            <!-- Step 1 -->
                                            <div class="form-step" id="step-1" style="display: block;">
                                                <br>
                                                <div class="line-separator border-bottom border-1 border-secondary pb-2 mb-4">
                                                    <h4 class="d-flex align-items-center">
                                                        <i class="fas fa-user me-2"></i> Personal Information
                                                    </h4>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="firstname" class="required-field">Firstname</label>
                                                        <input type="text" id="firstname" name="firstname" class="form-control" value="{{ old('firstname', $particulars->firstname ?? '') }}" required>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="middlename" class="required-field">Middlename</label>
                                                        <input type="text" id="middlename" name="middlename" class="form-control" value="{{ old('middlename', $particulars->middlename ?? '') }}" required>
                                                    </div>
                                                    
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    
                                                    <div class="form-group col-md-4">
                                                        <label for="lastname" class="required-field">Lastname</label>
                                                        <input type="text" id="lastname" name="lastname" class="form-control" value="{{ old('lastname', $particulars->lastname ?? '') }}" required>
                                                    </div>
                                                    <div class="row col-md-4">
                                                        <label for="doc" class="required-field">
                                                            Date of Birth (DOB)
                                                        </label>
                                                        <div class="col">
                                                            <select name="dob_day" id="dob_day" class="form-control search-select" style="width:100%;" required>
                                                                <option value="" disabled></option>
                                                                @for ($i = 1; $i <= 31; $i++)
                                                                    <option value="{{ $i }}" {{ $doc->format('j') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select name="dob_month" id="dob_month" class="form-control search-select" style="width:100%;" required>
                                                                <option value="" disabled></option>
                                                                @for ($i = 1; $i <= 12; $i++)
                                                                    <option value="{{ $i }}" {{ $doc->format('n') == $i ? 'selected' : '' }}>
                                                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select name="dob_year" id="dob_year" class="form-control search-select" style="width:100%;" required>
                                                                <option value="" disabled></option>
                                                                @for ($year = now()->format('Y'); $year >= 1900; $year--)
                                                                    <option value="{{ $year }}" {{ $doc->format('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="doc" />
                                                    <input type="hidden" name="today_date" value="{{ getTodayDate() }}" />

                                                    <span class="form-text text-muted">
                                                        <p></p>
                                                    </span>
                                                
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="tin_no" class="required-field1">TIN No.</label>
                                                        <input type="number" id="tin_no" name="tin_no" class="form-control">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="nida_no" class="required-field1">National Identification Number (NIDA).</label>
                                                        <input type="number" id="nida_no" name="nida_no" class="form-control">
                                                    </div>

                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="passport_no" class="required-field1">Passport No.</label>
                                                        <input type="number" id="passport_no" name="passport_no" class="form-control">
                                                    </div>

                                                    <div class="form-group col-md-4">
                                                        <label for="countries" class="required-field">Country.</label>
                                                        <select name="country" id="country" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($countries as $country)
                                                            <option value="{{ $country->id}}">{{ $country->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    

                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="unit" class="required-field">Member Unit.</label>
                                                        <select name="unit" id="unit" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($units as $unit)
                                                            <option value="{{ $unit->id}}">{{ $unit->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="designation" class="required-field">Member Designation.</label>
                                                        <select name="designation" id="designation" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($designations as $designation)
                                                            <option value="{{ $designation->id}}">{{ $designation->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="entitled_amount" class="required-field">Entitled Amount.</label>
                                                        <input type="number" id="entitled_amount" name="entitled_amount" class="form-control" value="{{ old('entitled_amount', $particulars->entitled_amount ?? '') }}" required>
                                                    </div>
                                                    <!-- Add Monthly Earnings to the Row -->
                                                    <div class="col-md-4">
                                                        <label for="monthly_earning" class="required-field">Monthly Earnings</label>

                                                        <div class="form-group">
                                                            <input type="number" id="monthly_earning" name="monthly_earning" class="form-control" required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="next-btn" style="display: flex; justify-content:end">
                                                    <button type="button" class="btn btn-primary next-btn">Next <i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>

                                            <!-- Step 2 -->
                                            <div class="form-step" id="step-2" style="display: none;">
                                                <br>
                                                <div class="line-separator border-bottom border-1 border-secondary pb-2 mb-4">
                                                    <h4 class="d-flex align-items-center">
                                                        <i class="fas fa-university me-2"></i> Contact Details
                                                    </h4>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="email" class="">Email Address</label>
                                                        <input type="text" id="email" name="email" class="form-control" value="{{ old('email', $particulars->email ?? '') }}">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="phone" class="required-field">Phone Number</label>
                                                        <input type="text" id="phone_no" name="phone_no" class="form-control" value="{{ old('phone_no', $particulars->phone ?? '') }}" required>
                                                    </div>

                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="box" class="">P.O.Box</label>
                                                        <input type="text" id="box" name="box" class="form-control">
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="fax" class="">Fax</label>
                                                        <input type="text" id="fax" name="fax" class="form-control">
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="region" class="required-field">Member Region.</label>
                                                        <select name="region" id="region" class="form-control" required>
                                                            <option value="">Select</option>
                                                            @foreach($regions as $region)
                                                            <option value="{{ $region->id}}">{{ $region->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label for="district" class="required-field">Member District.</label>
                                                        <select name="district" id="district" class="form-control">
                                                            <option value="">Select</option>
                                                            
                                                        </select>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="location" class="required-field">Location Type.</label>
                                                        <select name="location" id="location" class="form-control">
                                                            <option value="">Select</option>
                                                            <option value="1">Surveyed Area</option>
                                                            <option value="2">Unsurveyed Area</option>
                                                        </select>
                                                    </div>
                                                    <div class="column col-md-4" id="area_unsurveyed">
                                                        <label for="unsurveyed_area_descrpition" class="required-field">Unsurveyed Area Description</label>
                                                        <textarea 
                                                            name="unsurveyed_area_descrpition" 
                                                            id="unsurveyed_area_descrpition" 
                                                            class="form-control" 
                                                            rows="4" 
                                                            placeholder="Enter details about the unsurveyed area">
                                                        </textarea>
                                                        <span class="small">Enter details about the unsurveyed area</span>
                                                    </div>

                                                </div>
                                                <br>
                                                <div id="area_surveyed">
                                                    <div class="row col-md-11" >
                                                        <div class="form-group col-md-4">
                                                            <label for="road" class="">Road</label>
                                                            <input type="text" id="road" name="road" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="plot" class="">Plot No.</label>
                                                            <input type="text" id="plot" name="plot" class="form-control">
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <div class="row col-md-11">
                                                        <div class="form-group col-md-4">
                                                            <label for="block" class="">Block No.</label>
                                                            <input type="text" id="block" name="block" class="form-control">
                                                        </div>
                                                        <div class="form-group col-md-4">
                                                            <label for="Street" class="">Street.</label>
                                                            <input type="text" id="Street" name="Street" class="form-control">
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <div class="column col-md-4">
                                                        <label for="surveyed_area_descrpition" class="required-field">Surveyed Area Description</label>
                                                        <textarea 
                                                            name="surveyed_area_descrpition" 
                                                            id="surveyed_area_descrpition" 
                                                            class="form-control" 
                                                            rows="4" 
                                                            placeholder="Enter details about the surveyed area">
                                                        </textarea>
                                                        <span class="small">More details about surveyed area i.e Bulding Name, Floor, Office / Room Number</span>
                                                    </div>

                                                </div>
                                                    
                                                <br>
                                                <div class="next-btn" style="display: flex; justify-content:end; gap: 4px;">
                                                    <button type="button" class="btn prev-btn"><i class="fas fa-arrow-left"></i> Previous</button>
                                                    <button type="button" class="btn btn-primary next-btn">Next  <i class="fas fa-arrow-right"></i></button>
                                                </div>
                                            </div>

                                            <!-- Step 3 -->
                                            <div class="form-step" id="step-3" style="display: none;">
                                                <br>
                                                <div class="line-separator border-bottom border-1 border-secondary pb-2 mb-4">
                                                    <h4 class="d-flex align-items-center">
                                                        <i class="fas fa-briefcase me-2"></i> Professional/Bussiness Details
                                                    </h4>
                                                </div>
                                                <br>
                                                <div class="row col-md-11" >
                                                    <div class="form-group col-md-4">
                                                        <label for="job_title" class="">Job Title</label>
                                                        <input type="text" id="job_title" name="job_title" class="form-control" value="{{ old('job_title', $particulars->job_title ?? '') }}">
                                                    </div>
                                                    <div class="column col-md-4" id="job_description">
                                                        <label for="job_description" class="required-field">Job Description</label>
                                                        <textarea 
                                                            name="job_description" 
                                                            id="job_description" 
                                                            class="form-control" 
                                                            rows="4" 
                                                            placeholder="Enter details about the job you do">
                                                        </textarea>
                                                        <span class="small">Enter details about the way you carry your job</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="business_name" class="">Business Name</label>
                                                        <input type="text" id="business_name" name="business_name" class="form-control">
                                                    </div>
                                                    <div class="column col-md-4" id="business_nature">
                                                        <label for="business_nature" class="">Nature Of Business</label>
                                                        <textarea 
                                                            name="business_nature" 
                                                            id="business_nature" 
                                                            class="form-control" 
                                                            rows="4" 
                                                            placeholder="Enter details about the business you do">
                                                        </textarea>
                                                        <span class="small">Enter details about the way you carry your business</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-11">
                                                    <div class="form-group col-md-4">
                                                        <label for="education_level" class="required-field">Education Level.</label>
                                                        <select name="education_level" id="education_level" class="form-control" required>
                                                            <option value="">Select</option>
                                                            <option value="1">Primary</option>
                                                            <option value="2">Secondary</option>
                                                            <option value="3">Diploma</option>
                                                            <option value="4">Bachelor's Degree</option>
                                                            <option value="5">Masters' Degree</option>
                                                            <option value="6">phD Degree</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4" id="degree_name">
                                                        <label for="degree_name" class="required-field">Latest Diploma/Degree Name.</label>
                                                        <input type="text" id="degree_name" name="degree_name" class="form-control">
                                                        <span class="small">e.g BSc. In Information Systems And Networking Engineering.</span>
                                                    </div>
                                                </div>
                                                <br>
                                                <div class="row col-md-11" id="university">
                                                    <div class="form-group col-md-4">
                                                        <label for="university_name" class="required-field">Latest University Name.</label>
                                                        <input type="text" id="university_name" name="university_name" class="form-control">
                                                        <span class="small">e.g University Of Dar Es Salaam (UDSM) </span>
                                                    </div>
                                                    <div class="row col-md-4">
                                                        <label for="doc" class="required-field">
                                                            Latest Degree Completion Date
                                                        </label>
                                                        <div class="col">
                                                            <select name="uni_day" id="uni_day" class="form-control search-select" style="width:100%;">
                                                                <option value="" disabled></option>
                                                                @for ($i = 1; $i <= 31; $i++)
                                                                    <option value="{{ $i }}" {{ $doc->format('j') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select name="uni_month" id="uni_month" class="form-control search-select" style="width:100%;">
                                                                <option value="" disabled></option>
                                                                @for ($i = 1; $i <= 12; $i++)
                                                                    <option value="{{ $i }}" {{ $doc->format('n') == $i ? 'selected' : '' }}>
                                                                        {{ \Carbon\Carbon::create()->month($i)->format('F') }}
                                                                    </option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col">
                                                            <select name="uni_year" id="uni_year" class="form-control search-select" style="width:100%;">
                                                                <option value="" disabled></option>
                                                                @for ($year = now()->format('Y'); $year >= 1900; $year--)
                                                                    <option value="{{ $year }}" {{ $doc->format('Y') == $year ? 'selected' : '' }}>{{ $year }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <input type="hidden" name="doc" />
                                                    <input type="hidden" name="today_date" value="{{ getTodayDate() }}" />
                                                </div>
                                                <br>
                                                <div class="next-btn" style="display: flex; justify-content:end; gap:4px;">
                                                    <button type="button" class="btn prev-btn"><i class="fas fa-arrow-left"></i> Previous</button>
                                                    <button type="submit" class="btn btn-success" id="btn_submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>

                                </div>
                                
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


</html>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-steps/1.1.0/jquery.steps.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script>
    const steps = document.querySelectorAll(".form-step");
    const stepIndicators = document.querySelectorAll(".step-item");
    const nextBtns = document.querySelectorAll(".next-btn");
    const prevBtns = document.querySelectorAll(".prev-btn");

    let currentStep = 0;

    // Function to display the current step
    const showStep = (step) => {
        steps.forEach((formStep, index) => {
            formStep.style.display = index === step ? "block" : "none";
        });

        stepIndicators.forEach((indicator, index) => {
        console.log(indicator, index);
        
        if (index === step) {
            indicator.classList.add("active");
            indicator.classList.remove("completed");
        } else if (index < step) {
            indicator.classList.add("completed");
            indicator.classList.remove("active");
        } else {
            indicator.classList.remove("active", "completed");
        }
    });
        // console.log(`Displaying Step: ${step}`);
    };
    
    

    // Function to handle the "Next" button click
    const handleNext = (event) => {
        event.stopPropagation(); // Prevent event bubbling
        if (currentStep < steps.length - 1) {
            currentStep++;
            // console.log(`Current Step After Click: ${currentStep}`);
            showStep(currentStep);
        }
    };

    // Function to handle the "Previous" button click
    const handlePrev = (event) => {
        event.stopPropagation(); // Prevent event bubbling
        if (currentStep > 0) {
            currentStep--;
            showStep(currentStep);
        }
    };

        // Attach single event listeners to buttons
        nextBtns.forEach((btn) => {
        btn.addEventListener("click", handleNext); // Ensure only one listener
    });

    prevBtns.forEach((btn) => {
        btn.addEventListener("click", handlePrev); // Ensure only one listener
    });

    // Initialize the first step
    showStep(currentStep);
</script>

<script>
    $(document).ready(function(){

        $('#area_unsurveyed').hide();
        $('#area_surveyed').hide();
        $('#degree_name').hide();
        $('#university').hide();
        
        $('#region').on('change', function(){

            const region_id = $(this).val();
            
            const district_select = $('#district');

            district_select.html('<option value="">select</option>');

            if (region_id) {
                
                $.ajax({
                    url: `/api/district/get/${region_id}`,
                    type: "GET",
                    dataType: "json",
                    success: function(data){
                            data.forEach(function(district){
                                district_select.append(`<option value="${district.id}">${district.name}</option>`);
                            });
                    },
                    error: function(xhr, error, status){

                        console.error('error occured while fetching district', error);
                        
                    }
                });
            }
        });

        $('#location').on('click', function(){

            const area = $('#location').val();        
            console.log(area);

            $('#area_unsurveyed').hide();
            $('#area_surveyed').hide();

            if (area == 1) {
                $('#area_surveyed').show();
            }
            else if(area == 2){
                $('#area_unsurveyed').show();
            }
        });

        $('#education_level').on('click', function(){

            $('#degree_name').hide();
            $('#university').hide();

            const degree = $(this).val();

            if (degree == 3 || degree == 4 || degree == 5 || degree == 6) {
                
                $('#degree_name').show();
                $('#university').show();

            }
        });

        $('#btn_submit').on('click', function(e){

            e.preventDefault();
            const form = document.querySelector('#multiStepForm');
                        
            const formData = {};
            $('#multiStepForm').find('input, select, textarea').each(function () {
                const name = $(this).attr('name');
                if (name) {
                    formData[name] = $(this).val();
                }
            });
            
            $.ajax({

                url: "{{ route('submit_members', ['id'=>$request->input('member_id')]) }}",
                method: "POST",
                data: formData,
                dataType: "JSON",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                },
                success: function(data){
                    console.log(data);
                    
                },
                error: function(error, xhr, status){
                    console.error(error);
                },
            });
            
        });
    });
</script>

