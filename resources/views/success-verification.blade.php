<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Successfully Verification</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('sign-up-assets/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('sign-up-assets/css/owl.carousel.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('sign-up-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('sign-up-assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/verified-check.css') }}">
</head>

<body style="background-color: #f3f3f3;">
    <div class="container">
        <div class="card">
            <svg xmlns="http://www.w3.org/2000/svg" class="svg-success mt-5" viewBox="0 0 24 24">
                <g stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10">
                    <circle class="success-circle-outline" cx="12" cy="12" r="11.5" />
                    <circle class="success-circle-fill" cx="12" cy="12" r="11.5" />
                    <polyline class="success-tick" points="17,8.5 9.5,15.5 7,13" />
                </g>
            </svg>
            <h3 class="text-center" style="margin-top: 25px; font-size: 30px; font-weight:bold;">Your email address is now verified!</h3>
            <p class="text-center" style="margin-top: 15px; font-size: 18px; color: black;">Click the Login button to continue</p>
            <div class="d-flex justify-content-center">
                <a href="/login" class="btn btn-primary next-button mb-5 mt-1">Login</a>
            </div>
        </div>
    </div>
</body>
</html>