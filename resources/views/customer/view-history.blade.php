<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Payment</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    @include('partials.customer-link')

</head>
<style>
    .bg-light-blue {
        background-color: #eaedf8;
        text-align: center;
        padding: 10px;
    }

    .bold-blue {
        color: blue;
        font-weight: 900;
        text-transform: uppercase;
    }

    .bg-light-red {
        background-color: #ffe2e2;
        text-align: center;
        padding: 10px;
    }

    html {
        scroll-behavior: smooth;
    }
</style>

<body>
    @include('partials.customer-header')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    @if ($isCustomerLoggedIn)
                        <a href="{{ route('customer.customer-dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>


                        <div class="col-md-12">
                            <div class="bg-light-blue text-dark rounded p-3 mt-5">
                                <h6 class="mb-0" style="font-weight: bold;">Booking Reference</h6>
                                <strong class="bold-blue"
                                    style="text-transform: uppercase; font-size: 18px; letter-spacing: 1px;">{{ $reservation->reference_id }}</strong>

                            </div>
                        </div>

                        <div class="row align-items-center mt-2">
                            <div class="col-md-6">
                                <h5 class="fw-bold mb-0 mt-5">Driver Information</h5>
                            </div>
                        </div>
                        <hr>
                        <div class="ps-3">
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Name:</div>
                                <div class="col-md-10">{{ $reservation->driverInformation->first_name }}
                                    {{ $reservation->driverInformation->last_name }}</div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Email:</div>
                                <div class="col-md-10">{{ $reservation->driverInformation->email }}</div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Contact Number:</div>
                                <div class="col-md-10">
                                    {{ $reservation->driverInformation->contact_number }}</div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Address:</div>
                                <div class="col-md-10">
                                    {{ $reservation->driverInformation->address }}</div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Birthdate:</div>
                                <div class="col-md-10">
                                    {{ \Carbon\Carbon::parse($reservation->driverInformation->birthdate)->format('F d, Y') }}
                                </div>
                            </div>
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Gender:</div>
                                <div class="col-md-10">
                                    {{ $reservation->driverInformation->gender }}
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Driver License:</div>
                                <div class="col-md-10">
                                    @if ($driverLicensePath && Storage::disk('public')->exists($driverLicensePath))
                                        <a href="{{ asset('storage/' . $driverLicensePath) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $driverLicensePath) }}"
                                                alt="Driver License" class="img-fluid" style="max-height: 200px;">
                                        </a>
                                    @else
                                        <p>No driver license uploaded.</p>
                                    @endif
                                </div>

                            </div>
                        </div>
                </div>

                <!-- Trip Information Section -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3 mt-5">Trip Information</h5>
                    <hr>
                    <div class="ps-3">
                        <div class="row mb-2">
                            <div class="col-md-2 fw-bold">Riding:</div>
                            <div class="col-md-10">{{ $reservation->riding }}</div>
                        </div>
                        <div class="row mb-4">
                            <div class="col-md-2 fw-bold">Duration:</div>
                            <div class="col-md-10">{{ $duration }} day(s)</div>
                        </div>

                        <div class="row mb-2">
                            <div class="col-md-5">
                                <div class="col-md-2 fw-bold">Pick-up</div>
                                <div class="mt-2">
                                    {{ Carbon\Carbon::parse($reservation->rental_start_date)->format('M. d, Y') }}<br>
                                    <span>{{ Carbon\Carbon::parse($reservation->pick_up)->format('h:i A') }}</span>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="col-md-2 fw-bold">Drop-off</div>
                                <div class="mt-2">
                                    {{ Carbon\Carbon::parse($reservation->rental_end_date)->format('M. d, Y') }}<br>
                                    <span>{{ Carbon\Carbon::parse($reservation->drop_off)->format('h:i A') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Motorbike Details Section -->
                <div class="mb-4">
                    <h5 class="fw-bold mb-3 mt-5">Motorbike Details</h5>
                    <hr>
                    <div class="ps-3">
                        <div class="row">
                            <div class="col-md-5">
                                <a href="{{ asset('storage/' . $firstImage) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $firstImage) }}" alt="Motorcycle Image"
                                        class="img-fluid rounded mb-3" style="max-width: 70%; height: auto;">
                                </a>
                            </div>

                            <div class="col-md-6">
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-bold">Name:</div>
                                    <div class="col-md-8">{{ $reservation->motorcycle->name }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-bold">Brand:</div>
                                    <div class="col-md-8">{{ $reservation->motorcycle->brand }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-bold">Model:</div>
                                    <div class="col-md-8">{{ $reservation->motorcycle->model }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-bold">CC:</div>
                                    <div class="col-md-8">{{ $reservation->motorcycle->cc }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-bold">Color:</div>
                                    <div class="col-md-8">{{ $reservation->motorcycle->color }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-3 fw-bold">Daily Price:</div>
                                    <div class="col-md-8">₱{{ number_format($reservation->motorcycle->price, 2) }}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold mb-3 mt-5">Payment Details</h5>
                    <hr>
                    @if ($reservation->payment_method === 'cash')
                        <div class="ps-3">
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Payment Status:</div>
                                <div class="col-md-10">{{ $reservation->payment->status ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Total:</div>
                                <div class="col-md-10">₱{{ number_format($reservation->total, 2) }}</div>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-2 fw-bold">Payment Method:</div>
                                <div class="col-md-10">
                                    <span style="font-size: 1.2em;">
                                        {{ ucfirst($reservation->payment_method) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if ($reservation->payment_method !== 'cash' && $reservation->payment)
                        <div class="ps-3">
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Payment Status:</div>
                                <div class="col-md-10">{{ $reservation->payment->status ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 ">Total Amount:</div>
                                <div class="col-md-10">₱{{ number_format($reservation->total, 2) }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 ">GCash Number:</div>
                                <div class="col-md-10">{{ $reservation->payment->number ?? 'N/A' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 ">Proof Image:</div>
                                <div class="col-md-10">
                                    @if ($reservation->payment->image)
                                        @php
                                            $imagePath = preg_replace(
                                                '#receipts/receipts/#',
                                                'receipts/',
                                                $reservation->payment->image,
                                            );
                                        @endphp
                                        <a href="{{ asset('storage/' . $imagePath) }}" target="_blank">
                                            <img src="{{ asset('storage/' . $imagePath) }}" alt="Proof Image"
                                                style="max-width: 30%; height: auto;">
                                        </a>
                                    @else
                                        <div class="alert alert-info">No proof image available.</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                </div>
                @endif

                @if ($reservation->violation_status === 'Violator')
                    <div class="col-md-12" id="violations-section">
                        <div class="bg-light-blue text-dark rounded p-3 ">
                            <h6 class="mb-0" style="font-weight: bold; font-size: 18px; color:red;">Violations</h6>
                            <strong class="" style=""> Please review the details and take immediate action
                                to resolve the issue.</strong>
                        </div>
                    </div>
                    <div class="mb-4 mt-3">
                        <div class="ps-3">
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Penalty Type:</div>
                                <div class="col-md-10">
                                    <span>{{ $reservation->penalty->penalty_type ?? 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Additional Payment:</div>
                                <div class="col-md-10">
                                    <span>{{ isset($reservation->penalty->additional_payment) ? '₱' . number_format($reservation->penalty->additional_payment, 2) : 'N/A' }}</span>
                                </div>
                            </div>
                            <div class="row mb-5">
                                <div class="col-md-2 fw-bold">Description:</div>
                                <div class="col-md-10">
                                    <span>{{ $reservation->penalty->description ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                @endif
            </div>
        </div>
        @endif
        </div>
        <br>
    </section>

    <!-- Back to Top -->
    <a href="#" class="btn btn-secondary btn-lg-square rounded-circle back-to-top"><i
            class="fa fa-arrow-up"></i></a>


    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('assets/lib/wow/wow.min.js') }}"></script>
    <script src="{{ asset('assets/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('assets/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('assets/lib/counterup/counterup.min.js') }}"></script>
    <script src="{{ asset('assets/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.js"></script>

    <!-- SweetAlert JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>

</body>
