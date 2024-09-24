<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/img/logo.png" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/otp.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awes+ome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" id="main-font-link" >
   
</head>

<body class="container-fluid bg-body-tertiary d-block" style="background-color: #f3f3f3;">
<div class="row justify-content-center">
        <div class="col-12 col-md-6 col-lg-4" style="min-width: 500px;">
            <div class="card bg-white mb-5 mt-5 border-0" style="box-shadow: 0 12px 15px rgba(0, 0, 0, 0.02);">
                <div class="card-body p-5 text-center">
                    <h4>Verify</h4>
                    <p>Your code was sent to you via email</p>

                    @if ($errors->any())
                        <div class="text-center" id="errorMessage" style="color: red; font-size: 12px;">
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif

                    <form method="POST" action="{{ route('email.verify') }}" id="otpForm">
                        @csrf
                        <input type="hidden" name="email" value="{{ session('email') }}">
                        
                        <div class="otp-field mb-4">
                            <input type="number" maxlength="1" required>
                            <input type="number" maxlength="1" required>
                            <input type="number" maxlength="1" required>
                            <input type="number" maxlength="1" required>
                            <input type="number" maxlength="1" required>
                            <input type="number" maxlength="1" required>
                        </div>
                        <input type="hidden" name="otp" id="otpValue">
    
                        <button type="submit" class="btn btn-primary verify-button mb-3" style="background-color: #b30001;">
                            Verify
                        </button>
                    </form>
    
                    <p class="resend text-muted mb-0">
                        Didn't receive code?
                        <form id="resendForm" method="POST" action="{{ route('email.resend') }}" style="display: inline;">
                            @csrf
                            <input type="hidden" name="email" value="{{ session('email') }}">
                            <a href="#" onclick="event.preventDefault(); document.getElementById('resendForm').submit();">Request again</a>
                        </form>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/js/otp.js') }}"></script>

