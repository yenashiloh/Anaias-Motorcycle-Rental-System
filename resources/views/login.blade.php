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
            background-image: url('sign-up-assets/images/bg-example.png');
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

                    @if (session('success'))
                    <div class="alert alert-success" style="color: green; font-size: 13px; margin-bottom:10px;">
                        {{ session('success') }}
                    </div>
                @endif
                

                    @if (session('error'))
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

                    <div class="row">
                        <div class="col-6 forgot-password">
                            <a href="{{ route('forgot-password') }}">Forgot password?</a>
                        </div>
                        <div class="col-6 remember-me text-right">
                            <input type="checkbox" id="remember" name="remember" onclick="toggleRememberMe()">
                            <label for="remember">Remember me</label>
                        </div>
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
<script>
    // remember me
    function toggleRememberMe() {
        const rememberCheckbox = document.getElementById('remember');
        if (rememberCheckbox.checked) {
            console.log('User wants to be remembered');
            localStorage.setItem('rememberMe', 'true');
        } else {
            console.log('User does not want to be remembered');
            localStorage.removeItem('rememberMe');
        }
    }

    window.onload = function() {
        if (localStorage.getItem('rememberMe') === 'true') {
            document.getElementById('remember').checked = true;
        }
    };
</script>
