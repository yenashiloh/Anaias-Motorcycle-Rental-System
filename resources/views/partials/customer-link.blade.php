<meta content="width=device-width, initial-scale=1.0" name="viewport">
<meta content="" name="keywords">
<meta content="" name="description">
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" href="../../../assets/img/logo.png" type="image/x-icon">
<!-- Google Web Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link
    href="https://fonts.googleapis.com/css2?family=Lato:ital,wght@0,400;0,700;0,900;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
    rel="stylesheet">

<!-- Icon Font Stylesheet -->
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<!-- Libraries Stylesheet -->
<link href="{{ asset('assets/lib/animate/animate.min.css') }}" rel="stylesheet">
<link href="{{ asset('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">

<!-- Customized Bootstrap Stylesheet -->
<link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">

<!-- Template Stylesheet -->
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

<style>
    .notification-item:hover {
        background-color: #f8f9fa;
        transition: background-color 0.3s ease;
    }

    #notificationDropdown:hover {
        color: #dc3545;
        transition: color 0.3s ease;
    }

    .nav-item.nav-link {
        color: #000;
        transition: color 0.3s ease;
    }

    .nav-item.nav-link:hover,
    .nav-item.nav-link.active {
        color: #dc3545;
    }

    .time {
        color: rgb(124, 124, 124);
    }

    .notification-bell {
        font-size: 20px;
    }

    .reservation-details {
        background-color: #fdfdfd;
        border-radius: 10px;
        padding: 20px;
    }

    .text-danger {
        color: red;
    }

    .shadow {
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .new-notification {
        background-color: #eeeeee;
        font-weight: bold;
    }
</style>
