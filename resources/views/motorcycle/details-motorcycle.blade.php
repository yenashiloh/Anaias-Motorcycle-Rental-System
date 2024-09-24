<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Details Motorcycle</title>
    @include('partials.customer-link')
</head>
<style>
    dt{
        color: rgb(19, 19, 19);
    }
</style>
<body>

@include('partials.customer-header')

<section class="py-5">
    <div class="container">
        <div class="row gx-5">
            <div class="col-lg-6">
                <!-- Image gallery -->
                <div class="border rounded-4 mb-3 d-flex justify-content-center" id="main-image-container">
                    @if ($motorcycle->images)
                        @php
                            $images = json_decode($motorcycle->images);
                        @endphp
                        <img id="main-image" style="max-width: 100%; max-height: 100vh; margin: auto;" class="rounded-4 fit" src="{{ asset('storage/' . $images[0]) }}" />
                    @endif
                </div>
                <div class="d-flex justify-content-center mb-3">
                    @if ($motorcycle->images)
                        @php
                            $images = json_decode($motorcycle->images);
                        @endphp
                        @foreach ($images as $image)
                            <a href="javascript:void(0);" class="border mx-1 rounded-2" onclick="showImage('{{ asset('storage/' . $image) }}')" class="item-thumb">
                                <img class="rounded-2" src="{{ asset('storage/' . $image) }}" style="width: 60px; height: 60px; object-fit: cover;" />
                            </a>
                        @endforeach
                    @endif
                </div>
            </div>
            
            <div class="col-lg-6">
                <!-- Rental form -->
                <div class="bg-secondary rounded p-5 mb-3">
                    {{-- <h5 class="text-white mb-4 text-center">6 day rental</h5>
                    <h4 class="text-white mb-4 text-center">₱8,000.00</h4>
                    <h6 class="text-white mb-4 text-center">(₱{{ $motorcycle->price }}/per day)</h6> --}}
                    <h4 class="text-white mb-4 text-center"> MOTORCYCLE RESERVATION</h4>
                    <form>
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                        <span class="fas fa-calendar-alt"></span><span class="ms-1">Rental Dates</span>
                                    </div>
                                    <input class="form-control" type="date" placeholder="Enter a City or Airport" aria-label="Enter a City or Airport">
                                </div>
                            </div>
                            {{-- <div class="col-12">
                                <a href="#" class="text-start text-white d-block mb-2">Need a different drop-off location?</a>
                                <div class="input-group">
                                    <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                        <span class="fas fa-map-marker-alt"></span><span class="ms-1">Drop off</span>
                                    </div>
                                    <input class="form-control" type="text" placeholder="Enter a City or Airport" aria-label="Enter a City or Airport">
                                </div>
                            </div> --}}
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                        <span class="fas fa-calendar-alt"></span><span class="ms-1">Pick Up</span>
                                    </div>
                                    <input class="form-control" type="date">
                                    <select class="form-select ms-3" aria-label="Default select example">
                                        <option selected>12:00AM</option>
                                        <option value="1">1:00AM</option>
                                        <option value="2">2:00AM</option>
                                        <option value="3">3:00AM</option>
                                        <option value="4">4:00AM</option>
                                        <option value="5">5:00AM</option>
                                        <option value="6">6:00AM</option>
                                        <option value="7">7:00AM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="input-group">
                                    <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                        <span class="fas fa-calendar-alt"></span><span class="ms-1">Drop off</span>
                                    </div>
                                    <input class="form-control" type="date">
                                    <select class="form-select ms-3" aria-label="Default select example">
                                        <option selected>12:00AM</option>
                                        <option value="1">1:00AM</option>
                                        <option value="2">2:00AM</option>
                                        <option value="3">3:00AM</option>
                                        <option value="4">4:00AM</option>
                                        <option value="5">5:00AM</option>
                                        <option value="6">6:00AM</option>
                                        <option value="7">7:00AM</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12">
                                <button class="btn btn-light w-100 py-2">Rent Now</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
            <div class="col-12">
                <!-- Motorcycle details -->
                <h3 class="title text-dark fw-bold">
                    {{ $motorcycle->name }}
                </h3>
                <div class="mb-3">
                    <span class="h5">₱{{ number_format($motorcycle->price, 2, '.', ',') }}</span>
                    <span class="" style="color: black;"> / per day</span>
                </div>
                <p>
                    {{ $motorcycle->description }}
                </p>
                <div class="row">
                    <dt class="col-2">Brand:</dt>
                    <dd class="col-9">{{ $motorcycle->brand }}</dd>

                    <dt class="col-2">Model:</dt>
                    <dd class="col-9">{{ $motorcycle->model }}</dd>

                    <dt class="col-2">CC:</dt>
                    <dd class="col-9">{{ $motorcycle->cc }}</dd>

                    <dt class="col-2">Year:</dt>
                    <dd class="col-9">{{ $motorcycle->year }}</dd>

                    <dt class="col-2">Gas:</dt>
                    <dd class="col-9">{{ $motorcycle->gas }}</dd>

                    <dt class="col-2">Color:</dt>
                    <dd class="col-9">{{ $motorcycle->color }}</dd>

                    <dt class="col-2">Body Number:</dt>
                    <dd class="col-9">{{ $motorcycle->body_number }}</dd>

                    <dt class="col-2">Plate Number:</dt>
                    <dd class="col-9">{{ $motorcycle->plate_number }}</dd>
                </div>
            </div>
        </div>
    </div>
</section>


@include('partials.customer-footer')
</body>

</html>
<script>
    function showImage(imageUrl) {
        const mainImage = document.getElementById('main-image');
        mainImage.src = imageUrl; 
    }
</script>