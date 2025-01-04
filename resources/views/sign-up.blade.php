<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="icon" href="../../assets/img/logo.png" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/login.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/carousel.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-login.min.css') }}">
    <!-- Style -->
    <style>
        .image-section {
            flex: 1;
            background-image: url('sign-up-assets/images/bg-3.jpeg');
            ;
            background-size: cover;
            background-position: center;
        }
        .form-group {
        margin-bottom: 10px; 
   
    }

    .form-group .text-danger {
        margin-bottom: 5px;
        display: block;  
    }
 
    </style>
</head>

<body>
        <div class="d-lg-flex half">
            <div class="bg order-1 order-md-2" style="background-image: url('sign-up-assets/images/bg-example.png');"></div>
            <div class="contents order-2 order-md-1">
        
              <div class="container">
                <div class="row align-items-center justify-content-center">
                  <div class="col-md-7">
                    <img src="assets/img/logo.png" alt="Logo" class="logo-login img-fluid w-25">
    
                    <form action="{{ route('storeRegistration') }}" method="POST" enctype="multipart/form-data">
                        @csrf
    
                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                
                        <div class="form-group first mt-2">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                        </div>
                        
                        <div class="form-group last mb-3">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                            <small id="password-error" class="text-danger"></small>
                        </div>
        
                        <div class="form-group mb-3">
                            <label for="confirm-password">Confirm Password</label>
                            <input type="password" id="confirm-password" name="password_confirmation" class="form-control" placeholder="Enter confirm password" required>
                            <small id="confirm-password-error" class="text-danger"></small>
                        </div>
    
                        
                      <input type="submit" value="Log In" class="btn btn-block btn-primary">
                      
                      <div class="signup-link mt-3 text-center">
                        Already have an account? <a href="{{ route('login') }}">login</a>
                    </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
    </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm-password');
        const passwordError = document.getElementById('password-error');
        const confirmPasswordError = document.getElementById('confirm-password-error');
        const form = confirmPassword.closest('form');

        function validatePassword() {
            let isValid = true;

            if (password.value.length < 8) {
                passwordError.textContent = 'Password must be at least 8 characters long';
                isValid = false;
            } else if (!/[A-Z]/.test(password.value)) {
                passwordError.textContent = 'Password must contain at least one uppercase letter';
                isValid = false;
            } else if (!/[a-z]/.test(password.value)) {
                passwordError.textContent = 'Password must contain at least one lowercase letter';
                isValid = false;
            } else if (!/[0-9]/.test(password.value)) {
                passwordError.textContent = 'Password must contain at least one number';
                isValid = false;
            } else if (!/[!@#$%^&*()_+{}\[\]:;"'<>,.?/]/.test(password.value)) {
                passwordError.textContent = 'Password must contain at least one special character';
                isValid = false;
            } else {
                passwordError.textContent = '';
            }

            if (confirmPassword.value !== password.value) {
                confirmPasswordError.textContent = 'Passwords do not match';
                isValid = false;
            } else {
                confirmPasswordError.textContent = '';
            }

            return isValid;
        }

        password.addEventListener('input', validatePassword);
        confirmPassword.addEventListener('input', validatePassword);

        form.addEventListener('submit', function(event) {
            event.preventDefault(); 

            const isPasswordValid = validatePassword();

            if (isPasswordValid) {
                form.submit();
            } else {
                alert('Please fill all required fields and correct any errors before submitting.');
            }
        });
    });
</script>

</body>

</html>
