<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Motorcycle Reservation System</title>
    @include('partials.customer-link')
</head>

<body>

@include('partials.customer-header')
    <!-- Carousel Start -->
    <div class="header-carousel" id="home">
        <div id="carouselId" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
            <div class="carousel-inner" role="listbox">
                <div class="carousel-item active">
                    <img src="assets/img/hero-bg.jpg" class="img-fluid w-100" alt="First slide" />
                    <div class="carousel-caption">
                        <div class="container py-4">
                            <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight"
                                data-delay="1s" style="animation-delay: 1s;">
                                <div class="text-start">
                                    <h1 class="display-5 text-white">Anaia's Motorcycle Rental</h1>
                                    <p>Cruise on two wheels, spend less, and hire the best!
                                        Explore the open road with unbeatable rental prices, top-tier bikes, and
                                        exceptional service. Whether you're planning a weekend
                                        getaway or a long road trip, we’ve got the perfect ride for you. Embrace the
                                        freedom of the journey with safety, style, and comfort—your adventure begins
                                        here!</p>
                                    <a href="{{route('motorcycles')}}" class="btn btn-primary rounded-pill py-2 px-4">Rent</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <img src="assets/img/carousel-1.jpg" class="img-fluid w-100" alt="First slide" />
                <div class="carousel-caption">
                    <div class="container py-4">
                        <div class="row g-5">
                            <div class="col-lg-6 fadeInLeft animated" data-animation="fadeInLeft" data-delay="1s"
                                style="animation-delay: 1s;">
                                <div class="bg-secondary rounded p-5">
                                    <h4 class="text-white mb-4">CONTINUEMotorcycle RESERVATION</h4>
                                    <form>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <select class="form-select" aria-label="Default select example">
                                                    <option selected>Select YourMotorcycle type</option>
                                                    <option value="1">VW Golf VII</option>
                                                    <option value="2">Audi A1 S-Line</option>
                                                    <option value="3">Toyota Camry</option>
                                                    <option value="4">BMW 320 ModernLine</option>
                                                </select>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <div
                                                        class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                        <span class="fas fa-map-marker-alt"></span><span
                                                            class="ms-1">Pick Up</span>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        placeholder="Enter a City or Airport"
                                                        aria-label="Enter a City or Airport">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <a href="#" class="text-start text-white d-block mb-2">Need a
                                                    different drop-off location?</a>
                                                <div class="input-group">
                                                    <div
                                                        class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                        <span class="fas fa-map-marker-alt"></span><span
                                                            class="ms-1">Drop off</span>
                                                    </div>
                                                    <input class="form-control" type="text"
                                                        placeholder="Enter a City or Airport"
                                                        aria-label="Enter a City or Airport">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="input-group">
                                                    <div
                                                        class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                        <span class="fas fa-calendar-alt"></span><span
                                                            class="ms-1">Pick Up</span>
                                                    </div>
                                                    <input class="form-control" type="date">
                                                    <select class="form-select ms-3"
                                                        aria-label="Default select example">
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
                                                    <div
                                                        class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                                        <span class="fas fa-calendar-alt"></span><span
                                                            class="ms-1">Drop off</span>
                                                    </div>
                                                    <input class="form-control" type="date">
                                                    <select class="form-select ms-3"
                                                        aria-label="Default select example">
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
                                                <button class="btn btn-light w-100 py-2">Rent</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-lg-6 d-none d-lg-flex fadeInRight animated" data-animation="fadeInRight"
                                data-delay="1s" style="animation-delay: 1s;">
                                <div class="text-start">
                                    <h1 class="display-5 text-white">Get 15% off your rental! Choose Your Model </h1>
                                    <p>Treat yourself in USA</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Carousel End -->

    <!-- Features Start -->
    <div class="container-fluid feature py-5" id="features">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Anaia's <span class="text-primary">Features</span></h1>
                <p class="mb-0">Discover the exceptional features that set Anaia's motorcycle rentals apart
                </p>
            </div>
            <div class="row g-4 align-items-center">
                <div class="col-xl-4">
                    <div class="row gy-4 gx-0">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <span class="fa fa-tags fa-2x"></span>
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-3">Affordable Rental Rates</h5>
                                    <p class="mb-0">Competitive pricing with flexible rental plans, including daily,
                                        weekly, or monthly options to fit your budget and trip duration.</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <span class="fa fa-wrench fa-2x"></span>
                                </div>
                                <div class="ms-4">
                                    <h5 class="mb-3">Well-Maintained and Clean Bikes</h5>
                                    <p class="mb-0">Our fleet is regularly serviced to ensure safety, reliability,
                                        and peak performance, providing you with a smooth and worry-free ride.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-xl-4 wow fadeInUp" data-wow-delay="0.2s">
                    <img src="assets/img/motor-1.png" class="img-fluid w-100" style="object-fit: cover;"
                        alt="Img">
                </div>
                <div class="col-xl-4">
                    <div class="row gy-4 gx-0">
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.1s">
                            <div class="feature-item justify-content-end">
                                <div class="text-end me-4">
                                    <h5 class="mb-3">Easy Booking Process</h5>
                                    <p class="mb-0">Book your ride effortlessly with our user-friendly platform, ensuring a hassle-free experience.</p>
                                </div>
                                <div class="feature-icon">
                                    <span class="fa fa-book fa-2x"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 wow fadeInUp" data-wow-delay="0.3s">
                            <div class="feature-item justify-content-end">
                                <div class="text-end me-4">
                                    <h5 class="mb-3">Flexible Pickup and Drop-off Locations</h5>
                                    <p class="mb-0">Convenient pickup and drop-off services at multiple locations or
                                        even doorstep delivery for added convenience.</p>
                                </div>
                                <div class="feature-icon">
                                    <span class="fa fa fa-map-marker-alt fa-2x"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features End -->




    <!--Motorcycle Steps Start -->
    <div class="container-fluid steps py-5" id="process">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize text-white mb-3">Anaia's<span class="text-primary">
                        Process</span></h1>
                <p class="mb-0 text-white">This is the six-step process of our motorcycle reservation system, designed
                    to make booking a motorcycle simple and hassle-free. Follow these steps to successfully reserve your
                    ride
                </p>
            </div>
            <div class="row g-4">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="steps-item p-4 mb-4">
                        <h4>Explore Motorcycles</h4>
                        <p class="mb-0">Browse our motorcycle catalog by model, brand to find the best option for
                            you.</p>
                        <div class="setps-number">01.</div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="steps-item p-4 mb-4">
                        <h4>Select a Motorcycle</h4>
                        <p class="mb-0">Choose a motorcycle and view details, including features and rental costs.
                        </p>
                        <div class="setps-number">02.</div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="steps-item p-4 mb-4">
                        <h4>Choose Rental Dates</h4>
                        <p class="mb-0">Select your preferred rental start and end dates to check availability.</p>
                        <div class="setps-number">03.</div>
                    </div>
                </div>
            </div>

            <div class="row g-4 mt-2">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="steps-item p-4 mb-4">
                        <h4>Register or Log In</h4>
                        <p class="mb-0">Sign up for an account or log in to proceed with your motorcycle reservation.
                        </p>
                        <div class="setps-number">04.</div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="steps-item p-4 mb-4">
                        <h4> Confirm and Pay</h4>
                        <p class="mb-0">Review your reservation details and complete payment securely.</p>
                        <div class="setps-number">05.</div>
                    </div>
                </div>
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="steps-item p-4 mb-4">
                        <h4>Receive Notifications</h4>
                        <p class="mb-0">Get an email with your reservation details.</p>
                        <div class="setps-number">06.</div>
                    </div>
                </div>
            </div>




        </div>
    </div>
    </div>
    </div>
    <!--Motorcycle Steps End -->


    <!-- Services Start -->
    <div class="container-fluid service py-5" id="services">
        <div class="container py-5">
            <div class="text-center mx-auto pb-5 wow fadeInUp" data-wow-delay="0.1s" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Anaia's <span class="text-primary">Services</span></h1>
                <p class="mb-0">Anaia’s Motorcycle Rental System is committed to improving your riding experience
                    with top-quality bikes and exceptional service.
                </p>
            </div>
            <div class="row g-4">
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item p-4">
                        <div class="service-icon mb-4">
                            <i class="fa fa-motorcycle fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Top-Quality Motorcycles</h5>
                        <p class="mb-0">Anaia’s Motorcycle Rental System offers top-quality motorcycles for rent,
                            ensuring you get the best ride for your needs.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item p-4">
                        <div class="service-icon mb-4">
                            <i class="fa fa-check-circle fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Reliable and Well-Maintained</h5>
                        <p class="mb-0">Our bikes are reliable and well-maintained, providing riders with the
                            confidence to embark on any adventure.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item p-4">
                        <div class="service-icon mb-4">
                            <i class="fa fa-hands-helping fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Exceptional Customer Service</h5>
                        <p class="mb-0">We pride ourselves on delivering exceptional customer service to make your
                            rental experience smooth and pleasant.
                        </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div class="service-item p-4">
                        <div class="service-icon mb-4">
                            <i class="fa fa-calendar-alt fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Flexible Rental Options</h5>
                        <p class="mb-0">Enjoy flexible rental options, allowing you to choose the duration that fits
                            your schedule and plans.</p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.3s">
                    <div class="service-item p-4">
                        <div class="service-icon mb-4">
                            <i class="fa fa-money-bill-alt fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Affordable Rates</h5>
                        <p class="mb-0">We provide affordable rates that ensure you get great value for your money.
                            Our pricing is designed to be budget-friendly. </p>
                    </div>
                </div>
                <div class="col-md-6 col-lg-4 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="service-item p-4">
                        <div class="service-icon mb-4">
                            <i class="fa fa-shield-alt fa-2x"></i>
                        </div>
                        <h5 class="mb-3">Convenience and Safety</h5>
                        <p class="mb-0">Whether you're a local or a traveler, Anaia’s is here to fuel your journey
                            with convenience and safety at every step.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Services End -->


  @include('partials.customer-footer')
</body>

</html>
