@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <title>Register | FAMS - Family Management System.</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
</head>

<body>
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Free Register</h5>
                                        <p>Get your free FAMS account now.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="assets/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="index.html">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="assets/images/logo.svg" alt="" class="rounded-circle" height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form class="needs-validation" action="{{ route('register_member') }}" method="POST" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                        <label for="firstname" class="form-label">Firstname</label>
                                        <input type="text" class="form-control @error('firstname') is-invalid @enderror" id="firstname" name="firstname" placeholder="Enter Firstname" required>
                                        @if ($errors->has('firstname'))
                                            <div class="text-danger">
                                                {{ $errors->first('firstname') }}
                                            </div>
                                        @endif
                                        <div class="invalid-feedback">
                                            Please Enter Firstname
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="middlename" class="form-label">Middlename</label>
                                        <input type="text" class="form-control @error('middlename') is-invalid @enderror" id="middlename" name="middlename" placeholder="Enter Middlename" required>
                                        @if ($errors->has('middlename'))
                                            <div class="text-danger">
                                                {{ $errors->first('middlename') }}
                                            </div>
                                        @endif
                                        <div class="invalid-feedback">
                                            Please Enter Middlename
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="lastname" class="form-label">Lastname</label>
                                        <input type="text" class="form-control @error('lastname') is-invalid @enderror" id="lastname" name="lastname" placeholder="Enter Lastname" required>
                                        @if ($errors->has('lastname'))
                                            <div class="text-danger">
                                                {{ $errors->first('lastname') }}
                                            </div>
                                        @endif
                                        <div class="invalid-feedback">
                                            Please Enter Lastname
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email" required>
                                        @if ($errors->has('email'))
                                            <div class="text-danger">
                                                {{ $errors->first('email') }}
                                            </div>
                                        @endif
                                        <div class="invalid-feedback">
                                            Please Enter Email
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Phone</label>
                                        <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter Phone" required>
                                        @if ($errors->has('phone'))
                                            <div class="text-danger">
                                                {{ $errors->first('phone') }}
                                            </div>
                                        @endif
                                        <div class="invalid-feedback">
                                            Please Enter Phone
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userpassword" class="form-label">Password</label>
                                        <input type="password" class="form-control @error('password') is-invalid @enderror" id="userpassword" name="password" placeholder="Enter password" required>
                                        @if ($errors->has('password'))
                                            <div class="text-danger">
                                                {{ $errors->first('password') }}
                                            </div>
                                        @endif
                                        <div class="invalid-feedback">
                                            Please Enter Password
                                        </div>
                                    </div>
                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="mt-5 text-center">
                        <div>
                            <p>Already have an account ? <a href="{{ route('home') }}" class="fw-medium text-primary"> Login</a> </p>
                            <p>© <script>document.write(new Date().getFullYear())</script> All rights reserved. <i class="mdi mdi-heart text-danger"></i> by FAMS</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- JAVASCRIPT -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/metismenu/metisMenu.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <!-- validation init -->
        <script src="assets/js/pages/validation.init.js"></script>
        <!-- App js -->
        <script src="assets/js/app.js"></script>
    </body>
</html>
