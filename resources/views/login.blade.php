<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <!-- Style -->
    <style>
        .image-section {
            flex: 1;
            background-image: url('sign-up-assets/images/bg-3.jpeg');
            ;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="login-section">
            <div class="login-form">
                <div class="logo"></div>
                <img src="assets/img/logo.png" alt="Logo" class="logo-login">

                <form method="POST" action="{{ route('customer.login') }}">
                    @csrf
                
                    {{-- General error message --}}
                    @if(session('error'))
                        <div class="alert alert-danger" style="color: red; font-size: 13px; margin-bottom:10px;">
                            {{ session('error') }}
                        </div>
                    @endif
                
                    <div class="form-group">
                        <label for="email" class="mb-2">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control"
                               placeholder="Enter your email address" required style="margin-top: 5px;">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Enter your password" required style="margin-top: 5px;">
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
            
                    <div class="forgot-password">
                        <a href="#">Forgot password?</a>
                    </div>
                    <div class="remember-me">
                        <input type="checkbox" id="remember" name="remember">
                        <label for="remember">Remember me</label>
                    </div>
                
                    <button type="submit" class="login-button btn btn-primary">LOGIN</button>
                
                    <div class="signup-link mt-3">
                        Don't have an account? <a href="{{ route('sign-up') }}">Sign up</a>
                    </div>
                </form>
                
                
            </div>
        </div>
        <div class="image-section"></div>
    </div>

</body>

</html>
