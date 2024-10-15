<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Reservation Details</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    @include('partials.customer-link')
</head>

<body>
    @include('partials.customer-header')
    <section class="py-5">
        <div class="container">

            <div class="row">
                <div class="col-md-8">
                    <form action="{{ route('reservation.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <h4 class="fw-bold">Driver Information</h4>
                        <p>This is the information that will be used for the Rental Confirmation</p>

                        <input type="hidden" name="motorcycle_id" value="{{ $motorcycle->motor_id }}">
                        <input type="hidden" name="rental_dates" value="{{ $reservationData['rental_dates'] }}">
                        <input type="hidden" name="pick_up" value="{{ $reservationData['pick_up'] }}">
                        <input type="hidden" name="drop_off" value="{{ $reservationData['drop_off'] }}">
                        <input type="hidden" name="riding" value="{{ $reservationData['riding'] }}">
                        <input type="hidden" name="total" value="{{ $total }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label">First Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="first_name" id="firstName" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" id="lastName" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email" required>

                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" name="contact_number" id="phone">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address" id="address" required>
                            </div>
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="birthdate" id="dob" required>
                            </div>
                        </div>

                        <div class="row mb-3">

                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="licenseImage" class="form-label">Upload Driver License <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="licenseImage" name="driver_license"
                                    accept="image/*" required>
                            </div>
                        </div>

                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheck" required>
                            <label class="form-check-label" for="termsCheck">I accept Anaia's privacy policy, terms
                                of service, and booking conditions.</label>
                        </div>
                </div>
                @php
                    $dates = explode(' - ', $reservationData['rental_dates']);
                    $pickupDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                    $dropoffDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                    $days = abs($dropoffDate->diffInDays($pickupDate));
                    $total = $days * $motorcycle->price;
                @endphp
                <div class="col-md-4">
                    <div class="card reservation-details shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h5 class="card-title fw-bold mb-0">{{ $motorcycle->name }}</h5>
                                    <h6 class="card-title">{{ $motorcycle->brand }}</h6>
                                </div>
                                @if ($motorcycle->images)
                                    @php
                                        $images = json_decode($motorcycle->images);
                                        $firstImage = $images[0] ?? null;
                                    @endphp
                                    @if ($firstImage)
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $firstImage) }}"
                                                alt="{{ $motorcycle->name }}" class="img-fluid"
                                                style="max-width: 100px; max-height: 100px; object-fit: cover;">
                                        </div>
                                    @endif
                                @endif
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <div>
                                    <strong style="color: blue;">Pickup</strong>
                                    <p>{{ $pickupDate->format('d/m/Y') }}<br>{{ $reservationData['pick_up'] }}</p>
                                </div>
                                <div>
                                    <strong style="color: blue;">Drop-off</strong>
                                    <p>{{ $dropoffDate->format('d/m/Y') }}<br>{{ $reservationData['drop_off'] }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>Motorbike Rental ({{ $days }} day{{ $days > 1 ? 's' : '' }})</span>
                                <span>₱{{ number_format(abs($total), 2) }}</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Daily Price</span>
                                <span>₱{{ number_format($motorcycle->price, 2) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <h6 class="fw-bold">Total</h6>
                                <h6 class="fw-bold">₱{{ number_format(abs($total), 2) }}</h6>

                            </div>
                            <button type="submit" class="btn btn-secondary w-100 mt-3">Pay</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('partials.customer-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

</body>

</html>
