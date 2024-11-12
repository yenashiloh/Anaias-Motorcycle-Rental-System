<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>View Booking</title>
    @include('partials.admin-link')
</head>
<style>
    .text-muted {
        font-weight: bold;
    }

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
</style>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">View Booking</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('admin.admin-dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}">Manage Motorcycles</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.motorcycles.view-motorcycle', $motorcycle->motor_id) }}">View Motorcycle</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.reservation.view-bookings-specific', $reservation->reservation_id) }}" class="fw-bold">View Booking</a>
                    </li>
                    
                </ul>
            </div>
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body p-4">
                        <!-- Driver Information Section -->
                        <div class="mb-4">
                            <div class="row align-items-center mb-3">
                                <div class="col-md-12">
                                    <div class="bg-light-blue text-dark rounded p-3">
                                        <h5 class="mb-0" style="font-weight: bold;">Booking Reference</h5>
                                        <strong class="bold-blue"
                                            style="text-transform: uppercase; font-size: 15px; letter-spacing: 1px;">{{ $reservation->reference_id }}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h5 class="fw-bold mb-0  mt-5">Driver Information</h5>
                                </div>
                            </div>
                            <hr>
                            <div class="ps-3">
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2 text-muted">Name:</div>
                                    <div class="col-md-10">{{ $reservation->driverInformation->first_name }}
                                        {{ $reservation->driverInformation->last_name }}</div>
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2 text-muted">Email:</div>
                                    <div class="col-md-10">{{ $reservation->driverInformation->email }}</div>
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2 text-muted">Contact Number:</div>
                                    <div class="col-md-10">
                                        {{ $reservation->driverInformation->contact_number }}</div>
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2 text-muted">Address:</div>
                                    <div class="col-md-10">
                                        {{ $reservation->driverInformation->address }}</div>
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2 text-muted">Birthdate:</div>
                                    <div class="col-md-10">
                                        {{ \Carbon\Carbon::parse($reservation->driverInformation->birthdate)->format('F d, Y') }}
                                    </div>
                                </div>
                                <div class="row mb-2 align-items-center">
                                    <div class="col-md-2 text-muted">Gender:</div>
                                    <div class="col-md-10">
                                        {{ ucfirst($reservation->driverInformation->gender) }}
                                    </div>
                                </div>

                                <div class="row mb-2">
                                    <div class="col-md-2 text-muted">Driver License:</div>
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
                                    <div class="col-md-2 text-muted">Booking Status:</div>
                                    <div class="col-md-10">{{ ucfirst($reservation->status ?? 'To Review') }}</div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-md-2 text-muted">Riding:</div>
                                    <div class="col-md-10">{{ $reservation->riding }}</div>
                                </div>
                                <div class="row mb-4">
                                    <div class="col-md-2 text-muted">Duration:</div>
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
                                            <div class="col-md-3 text-muted">Name:</div>
                                            <div class="col-md-8">{{ $reservation->motorcycle->name }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Brand:</div>
                                            <div class="col-md-8">{{ $reservation->motorcycle->brand }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Model:</div>
                                            <div class="col-md-8">{{ $reservation->motorcycle->model }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">CC:</div>
                                            <div class="col-md-8">{{ $reservation->motorcycle->cc }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Color:</div>
                                            <div class="col-md-8">{{ $reservation->motorcycle->color }}</div>
                                        </div>
                                        <div class="row mb-2">
                                            <div class="col-md-3 text-muted">Plate No:</div>
                                            <div class="col-md-8">{{ $reservation->motorcycle->plate_number }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Details -->
                        <div class="mb-4">
                            <h5 class="fw-bold mb-3 mt-5">Payment Details</h5>
                            <hr>
                            @if ($reservation->payment_method === 'cash')
                                <div class="ps-3">
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Payment Status:</div>
                                        <div class="col-md-10">{{ $reservation->payment->status ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Total Amount:</div>
                                        <div class="col-md-10">₱{{ number_format($reservation->total, 2) }}</div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-2 text-muted">Payment Method:</div>
                                        <div class="col-md-10">{{ ucfirst($reservation->payment_method) }}</div>
                                    </div>
                                </div>
                            @endif

                            @if ($reservation->payment_method !== 'cash' && $reservation->payment)
                                <div class="ps-3">
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Payment Status:</div>
                                        <div class="col-md-10">{{ $reservation->payment->status ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Total Amount:</div>
                                        <div class="col-md-10">₱{{ number_format($reservation->total, 2) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Receipt:</div>
                                        <div class="col-md-10">{{ $reservation->payment->receipt ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Amount Sent:</div>
                                        <div class="col-md-10">
                                            ₱{{ number_format($reservation->payment->amount ?? 0, 2) }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">GCash Number:</div>
                                        <div class="col-md-10">{{ $reservation->payment->number ?? 'N/A' }}</div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-2 text-muted">Proof Image:</div>
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
                            <div class="mb-4 mt-3">
                                <h5 class="fw-bold mb-3 mt-5 text-danger">Violations</h5>
                                <hr>
                                <div class="ps-3">
                                    <div class="row mb-2">
                                        <div class="col-md-3 text-muted">Penalty Type:</div>
                                        <div class="col-md-6">
                                            <span>{{ $reservation->penalty->penalty_type ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <div class="col-md-3 text-muted">Additional Payment:</div>
                                        <div class="col-md-6">
                                            <span>{{ isset($reservation->penalty->additional_payment) ? '₱' . number_format($reservation->penalty->additional_payment, 2) : 'N/A' }}</span>
                                        </div>
                                    </div>
                                    <div class="row mb-5">
                                        <div class="col-md-3 text-muted">Description:</div>
                                        <div class="col-md-6">
                                            <span>{{ $reservation->penalty->description ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @include('partials.admin-footer')
</body>

</html>
