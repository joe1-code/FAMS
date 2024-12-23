<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login | FAMS - Family Management System</title>
    <link rel="shortcut icon" href="assets/images/fams-logo.ico">
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
        }

        .login-page {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }

        .image-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #f0f0f0;
        }

        .curved-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50% 0 0 50%;
        }

        .main-login-contain {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #fff;
            padding: 20px;
            position: relative;
        }

        .img-circle {
            width: 120px;
            height: 120px;
            background-color: #fff;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .img-circle img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }

        .login-form {
            width: 100%;
            max-width: 400px;
            padding: 30px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        .login-form input {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: 2px solid #255196;
            background-color: #fff;
            color: #255196;
            font-size: 16px;
            box-shadow: inset 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .login-form button {
            width: 100%;
            padding: 15px;
            border-radius: 25px;
            border: none;
            background-color: #8dc63f;
            color: #fff;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
        }

        .login-form button:hover {
            background-color: #255196;
        }

        @media screen and (max-width: 768px) {
            .image-container {
                display: none;
            }

            .main-login-contain {
                width: 100%;
            }
        }

        .input-container {
    position: relative;
    width: 100%;
    margin-bottom: 20px;
}

.input-container input {
    width: 100%;
    padding: 15px 20px 15px 15px; /* Increased padding for a larger input field */
    /* border: 1px solid #ccc; */
    border-radius: 24px; /* Increased border radius to make it curved */
    font-size: 16px; /* Increased font size for larger text */
}

.input-container i {
    position: absolute;
    right: 15px; /* Position the icon inside the input */
    top: 40%; /* Center the icon vertically */
    transform: translateY(-50%);
    color: #8dc63f; /* Icon color */
    font-size: 16px; /* Larger icon size */
}

#remember-check{
    width: 3px;
    height: 3px;
    transform: scale(0.6); /* Scale down */

        margin-right: 10px;
        /* background-color: #255196; */
}


    </style>
</head>

<body>
    <div class="login-page">
        <!-- Image Section -->
        <div class="image-container">
            <img src="{{ asset('images/fams_3.jpeg') }}" alt="Login Image" class="curved-image">
        </div>

        <!-- Login Form Section -->
        <div class="main-login-contain">
            <!-- Logo -->
            <div class="img-circle">
                <img src="{{ asset('images/fams-logo.jpg') }}" alt="Logo">
            </div>

            <!-- Login Form -->
            <div class="login-form">
                <form action="{{ route('landing') }}" method="POST">
                    @csrf
                    <div class="input-container">
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            placeholder="Enter username" 
                            required 
                        />
                        <i class="fas fa-envelope"></i>
                    </div>

                    <div class="input-container">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter password" 
                            required 
                        />
                        <i class="fas fa-key"></i>
                    </div>

                    <div class="form-check" style="display: flex; align-items: center;">
                        <input class="form-check-input" type="checkbox" id="remember-check" name="remember" 
                            style="margin-right: 10px;">
                        <label class="form-check-label" for="remember-check" style="font-size: 14px; padding-bottom:12px;">
                            Remember me
                        </label>
                    </div>

                    <button type="submit">Log In</button>
                </form>

                <div class="text-center" style="margin-top: 20px;">
                    <a href="auth-recoverpw.html" class="text-muted">Forgot your password?</a>
                </div>
                <div class="mt-5 text-center">

                        <div>
                            <p>Don't have an account ? <a href="{{ route('register') }}" method='post' class="fw-medium text-primary"> Signup now </a> </p>
                            <p>© <script>document.write(new Date().getFullYear())</script> FAMS. Crafted with <i class="mdi mdi-heart text-danger"></i> version v1.0.0</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <script src="assets/libs/jquery/jquery.min.js"></script>
    <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/app.js"></script>
</body>

</html>
