
<!doctype html>
<html lang="en">

    
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
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/css/select2.min.css" rel="stylesheet" />

        <style>
                .wrapper {
                        /* background-color: whitesmoke; */
                        background-color: #17a2b8;
                        /* font-family: Futura, Helvetica, "san-serif" !important; */
                        position: relative; /* Enables positioning of child elements */
                        width: 100%; /* Full width of the container */
                        height: 100vh; /* Full height of the viewport */
                    }

                .content-layer {
                    position: absolute; /* Positions the content layer on top */
                    top: 50%; /* Centers the content vertically */
                    left: 58%; /* Centers the content horizontally */
                    height: 85%;
                    transform: translate(-50%, -50%); /* Adjusts the content to be truly centered */
                    padding: 20px; /* Optional padding for the content layer */
                    background-color: rgba(255, 255, 255, 0.9); /* Slightly transparent white background for the content layer */
                    box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1); /* Optional shadow effect */
                    border-radius: 10px; /* Optional rounded corners */
                }

        </style>


    </head>

    <body data-sidebar="dark" data-layout-mode="light">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->

        <!-- Begin page -->
        

        @include('contributions.includes.contr_payments')
<!-- /Right-bar -->
        <!-- Include Select2 CSS -->

<!-- Include jQuery -->

<!-- Include Select2 JS -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0/js/select2.min.js"></script>
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
</html>

