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
                    <div class="brand-logo text-center">
                        <img src="{{ asset('assets/img/logo.png') }}" class="img-fluid w-25 mb-2">
                    </div>
                    
                    <h3 class="card-title text-center">Forgot Password</h3>
                    <p class="text-center">Enter your email address to reset your password</p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('password.email') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Enter your email" required>
                        </div>
                        <button type="submit" class="btn btn-secondary w-100 mt-1">SUBMIT</button>
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
