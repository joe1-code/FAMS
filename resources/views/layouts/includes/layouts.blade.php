

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

                        <!-- App Search-->
                       
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
                                <img class="rounded-circle header-profile-user" src="assets/images/users/avatar-1.jpg"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1" key="t-henry">Henry</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="#"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                <a class="dropdown-item" href="#"><i class="bx bx-wallet font-size-16 align-middle me-1"></i> <span key="t-my-wallet">My Wallet</span></a>
                                <a class="dropdown-item d-block" href="#"><span class="badge bg-success float-end">11</span><i class="bx bx-wrench font-size-16 align-middle me-1"></i> <span key="t-settings">Settings</span></a>
                                <a class="dropdown-item" href="#"><i class="bx bx-lock-open font-size-16 align-middle me-1"></i> <span key="t-lock-screen">Lock screen</span></a>
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
                                    <li><a href="" key="t-members">Members</a></li>
                                    <li><a href="" key="t-payments">Monthly Payments</a></li>
                                    <li><a href="" key="t-arrears">Monthly Arrears</a></li>
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
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">Edit Member Information</h4>

                                    <!-- <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboards</a></li>
                                            <li class="breadcrumb-item active">Dashboard</li>
                                        </ol>
                                    </div> -->

                                </div>
                            </div>
                        </div>
                        <!-- end page title -->

                       

                        <div class="row">
    <!-- <========================= Content Here=======================================================> -->
    <form class="needs-validation" action="{{ route('submit_members', ['id'=>$particulars->id]) }}" method="POST" novalidate>
        @csrf
        @if (session('success'))
        <div class="col-md-8 alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-4 mb-4">
                <label for="firstname" class="form-label">Firstname</label>
                <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="Enter Firstname" value="{{$particulars->firstname}}" required>
                @if ($errors->has('firstname'))
                    <div class="text-danger">
                        {{ $errors->first('firstname') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Firstname
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <label for="middlename" class="form-label">Middlename</label>
                <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" placeholder="Enter Middlename" value="{{$particulars->middlename}}" required>
                @if ($errors->has('middlename'))
                    <div class="text-danger">
                        {{ $errors->first('middlename') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Middlename
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="lastname" class="form-label">Lastname</label>
                <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Enter Lastname" value="{{$particulars->lastname}}" required>
                @if ($errors->has('lastname'))
                    <div class="text-danger">
                        {{ $errors->first('lastname') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Lastname
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{$particulars->email ?? ''}}" placeholder="Enter email" >
                <!-- @if ($errors->has('email'))
                    <div class="text-danger">
                        {{ $errors->first('email') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Email
                </div> -->
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter Phone" value="{{$particulars->phone ?? ''}}" required>
                @if ($errors->has('phone'))
                    <div class="text-danger">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Phone
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <label for="phone" class="form-label">Job Title</label>
                <input type="text" class="form-control @error('job_title') is-invalid @enderror" id="job_title" name="job_title" placeholder="Enter Job Title" value="{{$particulars->job_title ?? ''}}" >
                @if ($errors->has('phone'))
                    <div class="text-danger">
                        {{ $errors->first('job_title') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter Job Title
                </div>
            </div>
        </div>
        <div class="row">
                <div class="col-md-4 mb-4">
            <label for="regions" class="form-label">Region</label>
            <select class="form-control search-select" id="regions" name="regions" required>
                <option value="" disabled selected>Select a region</option>
                @foreach($regions as $region)
                    <option value="{{ $particulars->job_title ?? '' }}" {{ old('region') == $region->id ? 'selected' : '' }}>{{ $region->name }}</option>
                @endforeach
            </select>
            @if ($errors->has('regions'))
                <div class="text-danger">
                    {{ $errors->first('regions') }}
                </div>
            @endif
            <div class="invalid-feedback">
                Please select a region
            </div>
        </div>


            <div class="col-md-4 mb-4">
                <label for="district" class="form-label">District</label>
                <input type="text" class="form-control @error('district') is-invalid @enderror" id="district" name="district" placeholder="Enter district" value="{{$particulars->district ?? ''}}" required>
                @if ($errors->has('district'))
                    <div class="text-danger">
                        {{ $errors->first('district') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter district
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="dob" class="form-label">Date of Birth(DOB)</label>
                <input type="date" class="form-control @error('dob') is-invalid @enderror" id="dob" name="dob" placeholder="Enter dob" value="{{$particulars->dob ?? ''}}" required>
                @if ($errors->has('dob'))
                    <div class="text-danger">
                        {{ $errors->first('dob') }}
                    </div>
                @endif
                <div class="invalid-feedback">
                    Please Enter dob
                </div>
            </div>
        </div>
        
        
        
        <div class="mt-4 d-grid col-md-4"  style="margin-left: auto; margin-right: auto;">
            <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
        </div>
    </form>
</div>