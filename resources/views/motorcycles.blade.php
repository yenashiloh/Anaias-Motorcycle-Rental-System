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
        <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
            <h1 class="display-5 text-capitalize mb-3">Motorcycle <span class="text-primary">Categories</span></h1>
            <p class="mb-0">Choose your motorcycle from the categories below
            </p>
        </div>
        <div class="row wow fadeInUp">
            @if ($motorcycles->isEmpty())
                <div class="col-12">
                    <h5 class="text-center fw-bold">No motorcycles uploaded yet.</h5>
                </div>
            @else
                @foreach ($motorcycles as $motorcycle)
                <div class="col-md-3 mb-4"> 
                    <div class="rental-card">
                        @if ($motorcycle->images)
                            @php
                                $images = json_decode($motorcycle->images);
                                $firstImage = $images[0] ?? null;
                            @endphp
                            @if ($firstImage)
                                <div class="position-relative"> 
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $motorcycle->name }}" class="img-fluid"> 
                                    <span class="badge bg-success position-absolute m-2">{{ $motorcycle->status }}</span> 
                                </div>
                            @endif
                        @endif
                        <div class="rental-card-body">
                            <h3 class="rental-card-title">{{ $motorcycle->name }}</h3>
                            <p class="rental-card-year">{{ $motorcycle->year }}</p>
                            <div class="rental-card-features">
                                <span class="rental-card-feature"><i class="fas fa-cog"></i> Engine CC: {{ $motorcycle->cc }}</span>
                            </div>
                            <p class="rental-card-price">₱{{ number_format($motorcycle->price, 2) }} / day</p>
                            <div class="d-flex justify-content-between mt-3"> 
            
                                <a href="{{ route('motorcycle.details-motorcycle', $motorcycle->motor_id) }}" class="btn-rent-now ms-2">View Details</a> 
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @endif
        </div>
        
    </div>
</div>
<!-- Rent A Car End -->
@include('partials.customer-footer')
</body>

</html>
