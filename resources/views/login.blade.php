<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-login.min.css') }}">
</head>

<body>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('sign-up-assets/images/bg-example.png');"></div>
        <div class="contents order-2 order-md-1">
    
          <div class="container">
            <div class="row align-items-center justify-content-center">
              <div class="col-md-7">
                <img src="assets/img/logo.png" alt="Logo" class="logo-login img-fluid w-25">

                <form method="POST" action="{{ route('customer.login') }}">
                    @csrf

                    @if (session('success'))
                    <div class="alert alert-success mt-3" >
                        {{ session('success') }}
                    </div>
                @endif
                
                    @if (session('error'))
                        <div class="alert alert-danger mt-3" >
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="form-group first mt-2">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" name="email" placeholder="Enter your email address" id="email" required>
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                    <div class="form-group last mb-3">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password" required>
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    
                  <div class="d-flex mb-5 align-items-center">
                    <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                      <input type="checkbox" id="remember" name="remember" onclick="toggleRememberMe()" />
                      <div class="control__indicator"></div>
                    </label>
                    <span class="ml-auto"><a href="{{ route('forgot-password') }}" class="forgot-pass">Forgot Password</a></span> 
                  </div>
    
                  <input type="submit" value="Log In" class="btn btn-block btn-primary">
                  
                  <div class="signup-link mt-3 text-center">
                    Don't have an account? <a href="{{ route('sign-up') }}">Sign up</a>
                </div>
                </form>
              </div>
            </div>
          </div>
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
