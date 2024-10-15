<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Motorcycles</title>
    @include('partials.customer-link')
</head>

<body>

@include('partials.customer-header')
<div class="container-fluid">
    <div class="container pt-5 pb-3">
        <div class=" mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" >
            <h3 class=" text-capitalize mb-2 fw-bold">Dashboard</span></h3>
            <p><strong>Email:</strong> {{ $customerEmail }}</p>
        </div>

        
    </div>
</div> 
@include('partials.customer-footer')
</body>

</html>
