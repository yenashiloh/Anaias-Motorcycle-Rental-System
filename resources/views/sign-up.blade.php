{{-- <!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Sign Up</title>

    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">

    <link rel="stylesheet" href="{{ asset('sign-up-assets/fonts/icomoon/style.css') }}">
    <link rel="stylesheet" href="{{ asset('sign-up-assets/css/owl.carousel.min.css') }}">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{ asset('sign-up-assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="{{ asset('sign-up-assets/css/style.css') }}">
</head>

<body>
    <div class="d-lg-flex half">
        <div class="bg order-1 order-md-2" style="background-image: url('sign-up-assets/images/bg-4.jpeg');"></div>
        <div class="contents order-2 order-md-1">
            <div class="container">
                <div class="row align-items-center justify-content-center">
                    <div class="col-md-7 py-5">
                        <h3>Register</h3>
                        <p class="mb-4">Provide all your details to create your account. Please ensure accurate
                            information.
                        </p>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('storeRegistration') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group first">
                                        <label for="fname">First Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your first name"
                                            id="fname" name="first_name" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group first">
                                        <label for="lname">Last Name</label>
                                        <input type="text" class="form-control" placeholder="Enter your last name"
                                            id="lname" name="last_name" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group first">
                                        <label for="email">Email Address</label>
                                        <input type="email" class="form-control"
                                            placeholder="Enter your email address" id="email" name="email"
                                            required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group first">
                                        <label for="address">Address</label>
                                        <input type="address" class="form-control" placeholder="Enter your address"
                                            id="address" name="address" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group first">
                                        <label for="birthdate">Birthdate</label>
                                        <input type="date" class="form-control" id="birthdate" name="birthdate"
                                            required>
                                        <small id="birthdate-error" class="text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group first">
                                        <label for="gender">Gender</label>
                                        <div class="custom-dropdown">
                                            <select class="form-control" id="gender" name="gender" required>
                                                <option value="">Select Gender</option>
                                                <option value="male">Male</option>
                                                <option value="female">Female</option>
                                            </select>
                                            <i class="fas fa-chevron-down dropdown-icon fs-6"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group first">
                                        <label for="contact-number">Contact Number</label>
                                        <input type="text" class="form-control"
                                            placeholder="Enter your contact number" id="contact-number"
                                            name="contact_number" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group first custom-file-margin">
                                        <label for="driver-license">Upload Driver License</label>
                                        <input type="file" class="form-control" id="license"
                                            name="driver_license" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group last mb-3">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" placeholder="Password"
                                            id="password" name="password" required>
                                        <small id="password-error" class="text-danger"></small>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group last mb-3">
                                        <label for="confirm-password">Confirm Password</label>
                                        <input type="password" class="form-control" placeholder="Confirm Password"
                                            id="confirm-password" name="password_confirmation" required>
                                        <small id="confirm-password-error" class="text-danger"></small>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn px-5 btn-primary mt-1">Register</button>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('sign-up-assets/css/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ asset('sign-up-assets/js/popper.min.js') }}"></script>
    <script src="{{ asset('sign-up-assets/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('sign-up-assets/js/main.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');
            const birthdate = document.getElementById('birthdate');
            const passwordError = document.getElementById('password-error');
            const confirmPasswordError = document.getElementById('confirm-password-error');
            const birthdateError = document.getElementById('birthdate-error');
            const registerButton = document.querySelector('button[type="submit"]');
            const form = registerButton.closest('form');

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

            function validateBirthdate() {
                const today = new Date();
                const birthdateValue = new Date(birthdate.value);
                const age = today.getFullYear() - birthdateValue.getFullYear();
                const monthDifference = today.getMonth() - birthdateValue.getMonth();

                let isValid = true;

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdateValue.getDate())) {
                    isValid = age - 1 >= 18;
                } else {
                    isValid = age >= 18;
                }

                if (!isValid) {
                    birthdateError.textContent = 'You must be at least 18 years old';
                } else {
                    birthdateError.textContent = '';
                }

                return isValid;
            }

            function checkAllFieldsFilled() {
                const inputs = form.querySelectorAll('input[required], select[required]');
                return Array.from(inputs).every(input => input.value.trim() !== '');
            }

            function validateForm(event) {
                event.preventDefault(); 

                const isPasswordValid = validatePassword();
                const isBirthdateValid = validateBirthdate();
                const allFieldsFilled = checkAllFieldsFilled();

                if (isPasswordValid && isBirthdateValid && allFieldsFilled) {
                    registerButton.textContent = 'Submitting...';
                    registerButton.disabled = true;
                    form.submit(); 
                } else {
                    alert('Please fill all required fields and correct any errors before submitting.');
                }
            }

            password.addEventListener('input', validatePassword);
            confirmPassword.addEventListener('input', validatePassword);
            birthdate.addEventListener('blur', validateBirthdate);
            birthdate.addEventListener('input', validateBirthdate);

            form.addEventListener('submit', validateForm);
        });
    </script>
</body>

</html> --}}

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
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
    <div class="container">
        <div class="login-section">
            <div class="login-form">
                <div class="logo">
                    <img src="assets/img/logo.png" alt="Logo" class="logo-login">
                </div>

                <form action="{{ route('storeRegistration') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="text-danger">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                
                    <div class="form-group mb-2">
                        
                        <label for="email">Email Address</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Enter your email address" required>
                     
                    </div>
                    
                    <div class="form-group mb-2">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" class="form-control" placeholder="Enter password" required>
                        <small id="password-error" class="text-danger"></small>
                    </div>
                
                    <div class="form-group mb-2">
                        <label for="confirm-password">Confirm Password</label>
                        <input type="password" id="confirm-password" name="password_confirmation" class="form-control" placeholder="Enter confirm password" required>
                        <small id="confirm-password-error" class="text-danger"></small>
                    </div>
                
                    <button type="submit" class="login-button">Register</button>
                    <div class="signup-link">
                        Already have an account? <a href="{{ route('login') }}">login</a>
                    </div>
                </form>
                
            </div>
        </div>
        <div class="image-section"></div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm-password');
            const birthdate = document.getElementById('birthdate');
            const passwordError = document.getElementById('password-error');
            const confirmPasswordError = document.getElementById('confirm-password-error');
            const birthdateError = document.getElementById('birthdate-error');
            const registerButton = document.querySelector('button[type="submit"]');
            const form = registerButton.closest('form');

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

            function validateBirthdate() {
                const today = new Date();
                const birthdateValue = new Date(birthdate.value);
                const age = today.getFullYear() - birthdateValue.getFullYear();
                const monthDifference = today.getMonth() - birthdateValue.getMonth();

                let isValid = true;

                if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdateValue.getDate())) {
                    isValid = age - 1 >= 18;
                } else {
                    isValid = age >= 18;
                }

                if (!isValid) {
                    birthdateError.textContent = 'You must be at least 18 years old';
                } else {
                    birthdateError.textContent = '';
                }

                return isValid;
            }

            function checkAllFieldsFilled() {
                const inputs = form.querySelectorAll('input[required], select[required]');
                return Array.from(inputs).every(input => input.value.trim() !== '');
            }

            function validateForm(event) {
                event.preventDefault(); 

                const isPasswordValid = validatePassword();
                const isBirthdateValid = validateBirthdate();
                const allFieldsFilled = checkAllFieldsFilled();

                if (isPasswordValid && isBirthdateValid && allFieldsFilled) {
                    registerButton.textContent = 'Submitting...';
                    registerButton.disabled = true;
                    form.submit(); 
                } else {
                    alert('Please fill all required fields and correct any errors before submitting.');
                }
            }

            password.addEventListener('input', validatePassword);
            confirmPassword.addEventListener('input', validatePassword);
            birthdate.addEventListener('blur', validateBirthdate);
            birthdate.addEventListener('input', validateBirthdate);

            form.addEventListener('submit', validateForm);
        });
    </script>
</body>

</html>
