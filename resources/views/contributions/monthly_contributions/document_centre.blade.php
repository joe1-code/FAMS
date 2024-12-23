<!doctype html>
<html lang="en">
    <head>
        
        <meta charset="utf-8" />
        <title>Dashboard | Document Centre.</title>
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
                background-color: #f7f7f7;
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
                    <div class="container-fluid p-0">
                        <div class="row m-0">
                            <div class="col-lg-12">
                                <div class="card w-100">
                                    <div class="card-body">
                                        <h4 class="card-title mb-4" style="display: flex; justify-content:center;">MONTHLY CONTRIBUTIONS PAYMENT DOCUMENTS</h4>
                                        <div id="alert"></div>
                                        <div class="content-layer1">
                                            <div class="card w-90 p-0">
                                                <div class="card-header">
                                                    <small>Preview Payment Document</small> 
                                                </div>
                                                <div class="card-body">
                                                    <form id="doc_view" method="get">
                                                        @csrf
                                                        <div class="form-group row">
                                                            <div class="col-md-12">
                                                                <label for="member"><small>Select Members</small></label>
                                                                <select class="form-control search-select" id="user_data" name="id" required>
                                                                        <option value="" disabled selected></option>
                                                                        @foreach($memberData as $data)
                                                                            <option value="{{$data->id}}">{{ $data->firstname.' '.$data->lastname }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    @if ($errors->has('member'))
                                                                        <div class="text-danger">{{ $errors->first('member') }}</div>
                                                                    @endif
                                                                    <div class="invalid-feedback">Please select a member</div>
                                                            </div>
                                                            
                                                        </div>

                                                        <div class="form-group row">
                                                            <div class="col-md-6">
                                                                <label for="contr_month">Contribution Month</label>
                                                                <select name="contr_month" id="contr_month" class="form-control search-select">
                                                                    <option value="" disabled selected>Month</option>
                                                                    @foreach(range(1, 12) as $month)
                                                                        <option value="{{ str_pad($month, 2, '0', STR_PAD_LEFT) }}" 
                                                                            {{ old('contr_month', isset($request->from_date) ? \Carbon\Carbon::parse($request->from_date)->format('m') : '') == str_pad($month, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}>
                                                                            {{ \Carbon\Carbon::create()->month($month)->format('F') }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <label for="contr_year">Contribution Year</label>
                                                                <select name="contr_year" id="contr_year" class="form-control search-select">
                                                                    <option value="" disabled selected>Year</option>
                                                                    @foreach(range(\Carbon\Carbon::now()->format('Y'), 2022) as $year)
                                                                        <option value="{{ $year }}" 
                                                                            {{ old('contr_year', isset($request->from_date) ? \Carbon\Carbon::parse($request->from_date)->format('Y') : '') == $year ? 'selected' : '' }}>
                                                                            {{ $year }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="monthly_preview_doc col-md-12 mt-3">
                                                            <button type="submit" class="btn btn-success">Preview Document</button>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
        <script src="https://cdn.datatables.net/2.1.5/js/dataTables.js"></script>
        <script src="https://cdn.datatables.net/2.1.5/css/dataTables.dataTables.css"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    </body>


<!-- Mirrored from themesbrand.com/skote/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 12 Oct 2022 14:37:45 GMT -->
</html>
<div class="modal fade" id="monthly_doc_modal" tabindex="-1" role="dialog" aria-labelledby="monthly_doc_modal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Document Preview</h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"> -->
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="document_frame"></div> <!-- This is where the document will be displayed -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close">Close</button>
            </div>
        </div>
    </div>
</div>

<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />
<script>

document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('#doc_view');

    function checkClose(){

         $('#close').on('click', function(){
        $('#monthly_doc_modal').modal('hide');
    });

    }
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const formData = new FormData(form);

        fetch('{{ route("monthly_preview_document") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {

            const previewContainer = document.getElementById('document_frame');
                
            if (data.status === 'success') {
                const fileType = data.document.split('.').pop().toLowerCase();
                const filePath = `{{ asset('storage/documents') }}/${data.document}`;
                
                if (fileType === 'pdf') {
                    previewContainer.innerHTML = `<embed src="${filePath}" type="application/pdf" width="100%" height="600px">`;
                } else if (['jpg', 'jpeg', 'png', 'gif'].includes(fileType)) {
                    previewContainer.innerHTML = `<img src="${filePath}" style="max-width: 100%; height: auto;" alt="Document Preview">`;
                } else {
                    previewContainer.innerHTML = `<p>Unable to preview this file type.</p>`;
                }

                // Show the modal
                $('#monthly_doc_modal').modal('show');
                $('#close').on('click', function(){
                $('#monthly_doc_modal').modal('hide');
             });
            } else {
                console.log(data);
                
                Swal.fire({
                        title: "Not Found",
                        text: previewContainer.innerHTML = `${data.message}`,
                        icon: "error" 
                    });

            }
        })
        .catch(error => {

                // console.error(xhr);
            console.error('Error:', error);
        });
    });
});

</script>

