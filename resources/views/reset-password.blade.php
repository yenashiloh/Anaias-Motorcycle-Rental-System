<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../../../assets/img/logo.png" type="image/x-icon">

    <!-- Fonts and icons -->
    <script src="../../../../admin-assets-final/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {
                families: ["Public Sans:300,400,500,600,700"]
            },
            custom: {
                families: [
                    "Font Awesome 5 Solid",
                    "Font Awesome 5 Regular",
                    "Font Awesome 5 Brands",
                    "simple-line-icons",
                ],
                urls: ["../../../../admin-assets-final/css/fonts.min.css"],
            },
            active: function() {
                sessionStorage.fonts = true;
            },
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="../../../../admin-assets-final/css/bootstrap.min.css" />
    <link rel="stylesheet" href="../../../../admin-assets-final/css/plugins.min.css" />
    <link rel="stylesheet" href="../../../../admin-assets-final/css/kaiadmin.min.css" />
    <link rel="stylesheet" href="../../../../admin-assets-final/css/style.css" />
</head>

<div class="container min-vh-100 d-flex justify-content-center align-items-center">
    <div class="row w-100 justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="card-title text-center">Reset Password</h3>
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf
                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" value="{{ $email }}" class="form-control"
                                required readonly>
                        </div>


                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" name="password" id="password" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-secondary w-100">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="../../../../admin-assets-final/js/core/jquery-3.7.1.min.js"></script>
<script src="../../../../admin-assets-final/js/core/popper.min.js"></script>
<script src="../../../../admin-assets-final/js/core/bootstrap.min.js"></script>


<!-- jQuery Scrollbar -->
<script src="../../../../admin-assets-final/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

<!-- Chart JS -->
<script src="../../../../admin-assets-final/js/plugin/chart.js/chart.min.js"></script>

<!-- jQuery Sparkline -->
<script src="../../../../admin-assets-final/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

<!-- Chart Circle -->
<script src="../../../../admin-assets-final/js/plugin/chart-circle/circles.min.js"></script>

<!-- Datatables -->
<script src="../../../../admin-assets-final/js/plugin/datatables/datatables.min.js"></script>

<!-- Bootstrap Notify -->
<script src="../../../../admin-assets-final/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

<!-- jQuery Vector Maps -->
<script src="../../../../admin-assets-final/js/plugin/jsvectormap/jsvectormap.min.js"></script>
<script src="../../../../admin-assets-final/js/plugin/jsvectormap/world.js"></script>

<!-- Sweet Alert -->
<script src="../../../../admin-assets-final/js/plugin/sweetalert/sweetalert.min.js"></script>

<!-- Kaiadmin JS -->
<script src="../../../../admin-assets-final/js/kaiadmin.min.js"></script>

<!-- Kaiadmin DEMO methods, don't include it in your project! -->
<script src="../../../../admin-assets-final/js/setting-demo.js"></script>
<script src="../../../../admin-assets-final/js/demo.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('password_confirmation');
        const form = document.querySelector('form');

        const passwordErrors = document.createElement('div');
        passwordErrors.id = 'password-errors';
        passwordInput.parentNode.appendChild(passwordErrors);

        const confirmPasswordErrors = document.createElement('div');
        confirmPasswordErrors.id = 'confirm-password-errors';
        confirmPasswordInput.parentNode.appendChild(confirmPasswordErrors);

        function validatePassword() {
            const password = passwordInput.value;
            const errors = [];

            if (password.length < 6) {
                errors.push('Password must be at least 6 characters long');
            }

            if (!/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
                errors.push('Password must contain at least one special character');
            }

            if (!/[A-Z]/.test(password)) {
                errors.push('Password must contain at least one uppercase letter');
            }

            if (!/[a-z]/.test(password)) {
                errors.push('Password must contain at least one lowercase letter');
            }

            if (!/[0-9]/.test(password)) {
                errors.push('Password must contain at least one number');
            }

            passwordErrors.innerHTML = errors.map(error =>
                `<small class="text-danger d-block">${error}</small>`
            ).join('');

            return errors.length === 0;
        }

        function validateConfirmPassword() {
            const password = passwordInput.value;
            const confirmPassword = confirmPasswordInput.value;
            const errors = [];

            if (confirmPassword && password !== confirmPassword) {
                errors.push('Passwords do not match');
            }

            confirmPasswordErrors.innerHTML = errors.map(error =>
                `<small class="text-danger d-block">${error}</small>`
            ).join('');

            return errors.length === 0;
        }

        passwordInput.addEventListener('input', validatePassword);
        confirmPasswordInput.addEventListener('input', validateConfirmPassword);

        form.addEventListener('submit', function(e) {
            const isPasswordValid = validatePassword();
            const isConfirmPasswordValid = validateConfirmPassword();

            if (!isPasswordValid || !isConfirmPasswordValid) {
                e.preventDefault();
            }
        });
    });
</script>
