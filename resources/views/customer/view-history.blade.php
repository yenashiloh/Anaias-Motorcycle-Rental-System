<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Payment</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    @include('partials.customer-link')
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
                            
                            <div class="row mb-2 align-items-center">
                                <div class="col-md-2 fw-bold">Facebook Link:</div>
                                <div class="col-md-10">
                                    <a href="{{ $reservation->driverInformation->fb_link }}" target="_blank" rel="noopener noreferrer" style="color: rgb(0, 126, 230);">
                                        {{ $reservation->driverInformation->fb_link }}
                                    </a>
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
                            <div class="col-md-2 fw-bold">Reservation Status:</div>
                            <div class="col-md-10">{{ $reservation->status }}</div>
                        </div>
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

                @if ($reservation->violation_status === 'Violator' && $reservation->penalty)
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
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Description:</div>
                                <div class="col-md-10">
                                    <span>{{ $reservation->penalty->description ?? 'N/A' }}</span>
                                </div>
                            </div>
                            @if ($reservation->penalty->penalty_image)
                                <div class="row mb-2 mb-5">
                                    <div class="col-md-2 fw-bold">Penalty Image:</div>
                                    <div class="col-md-10">
                                        @php
                                            $images = json_decode($reservation->penalty->penalty_image, true);
                                        @endphp
                                        @foreach ($images as $image)
                                            <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                                <img src="{{ asset('storage/' . $image) }}" alt="Penalty Image"
                                                    style="max-height: 200px;">
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            @if (!$reservation->penaltyPayment)
                            <button class="btn btn-secondary mt-2 mb-2" data-bs-toggle="modal" data-bs-target="#paymentModal">Pay Now</button>
                         @endif
                            <hr>

                            @if ($reservation->penaltyPayment)
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Payment Method:</div>
                                <div class="col-md-10">
                                    <span>{{ ucfirst($reservation->penaltyPayment->payment_method) }}</span>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-md-2 fw-bold">Status:</div>
                                <div class="col-md-10">
                                    <span>{{ $reservation->penalty->status ?? 'N/A' }}</span>
                                </div>
                            </div>
                            
                                @if ($reservation->penaltyPayment->payment_method === 'Gcash')
                               
                                    <div class="row mb-2">
                                        <div class="col-md-2 fw-bold">GCash Name:</div>
                                        <div class="col-md-10">
                                            <span>{{ $reservation->penaltyPayment->gcash_name ?? 'N/A' }}</span>
                                        </div>
                                    </div>
                                
                                    <div class="row mb-2">
                                        <div class="col-md-2 fw-bold">GCash Number:</div>
                                        <div class="col-md-10">
                                            <span>{{ $reservation->penaltyPayment->gcash_number ?? 'N/A' }}</span>
                                        </div>
                                    </div>

                                    <div class="row mb-2 mb-5">
                                        <div class="col-md-2 fw-bold">Receipt Image:</div>
                                        <div class="col-md-10">
                                            @if ($reservation->penaltyPayment && $reservation->penaltyPayment->image_receipt)
                                                <a href="{{ asset('storage/penalty_receipts/' . basename($reservation->penaltyPayment->image_receipt)) }}"
                                                    target="_blank">
                                                    <img src="{{ asset('storage/penalty_receipts/' . basename($reservation->penaltyPayment->image_receipt)) }}"
                                                        alt="Receipt Image" class="img-fluid"
                                                        style="max-height: 250px;">
                                                </a>
                                            @else
                                                <span>No receipt image available</span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                @endif
                            </div>
                        </div>
                    </div>
                @endif
                @endif
            </div>
        </div>
        @endif

        <!-- Modal for Payment Options -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-labelledby="paymentModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="paymentModalLabel">Choose Payment Method</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;"  enctype="multipart/form-data">
                        <!-- Payment method selection -->
                        <div class="form-group">
                            <label><input type="radio" name="payment_method" value="cash" id="cashOption"> Cash</label>
                            <br>
                            <label><input type="radio" name="payment_method" value="gcash" id="gcashOption"> Pay via Gcash</label>
                        </div>
        
                        <!-- Gcash Field -->
                        <div id="gcashFields" style="display: none;">
                            <div class="d-flex justify-content-center">
                                <img src="{{ asset('../../assets/img/gcash.jpg') }}" alt="GCash" class="img-fluid" style="max-width: 60%;">
                            </div>
        
                            <div class="form-group mb-3 mt-3">
                                <label for="gcash_name">Gcash Name</label>
                                <input type="text" class="form-control" id="gcash_name" name="gcash_name"
                                    placeholder="Enter Gcash name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="gcash_number">Gcash Number</label>
                                <input type="number" class="form-control" id="gcash_number" name="gcash_number"
                                    placeholder="Enter Gcash number" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="image_receipt">Receipt </label>
                                <input type="file" class="form-control" id="image_receipt" name="image_receipt" accept="image/*" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-secondary" id="submitPayment">Submit Payment</button>
                    </div>
                </div>
            </div>
        </div>
        
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
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cashOption = document.getElementById('cashOption');
            const gcashOption = document.getElementById('gcashOption');
            const gcashFields = document.getElementById('gcashFields');
            const submitButton = document.getElementById('submitPayment');
    
            if (!document.getElementById('toastContainer')) {
                const toastContainer = document.createElement('div');
                toastContainer.id = 'toastContainer';
                toastContainer.classList.add('position-fixed', 'bottom-0', 'end-0', 'p-3');
                toastContainer.style.zIndex = '1100';
                document.body.appendChild(toastContainer);
            }
    
            gcashOption.addEventListener('change', function() {
                gcashFields.style.display = 'block';
            });
    
            cashOption.addEventListener('change', function() {
                gcashFields.style.display = 'none';
            });
    
            function showToast(message, type = 'success') {
                const toastContainer = document.getElementById('toastContainer');
                const toastHTML = `
                    <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
                        <div class="d-flex">
                            <div class="toast-body">
                                ${message}
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                        </div>
                    </div>
                `;
    
                toastContainer.innerHTML = toastHTML;
                const toast = new bootstrap.Toast(toastContainer.querySelector('.toast'));
                toast.show();
            }
    
            submitButton.addEventListener('click', function() {
                let paymentMethod = cashOption.checked ? 'Cash' : 'Gcash';
                let formData = new FormData();
                
                formData.append('payment_method', paymentMethod);
                formData.append('penalty_id', {!! json_encode($reservation->penalty ? $reservation->penalty->penalty_id : null) !!});
                formData.append('customer_id', {!! json_encode($reservation->customer_id) !!});
                formData.append('driver_id', {!! json_encode($reservation->driver_id) !!});
                formData.append('reservation_id', {!! json_encode($reservation->reservation_id) !!});

                if (paymentMethod === 'Gcash') {
                    let gcashName = document.getElementById('gcash_name').value.trim();
                    let gcashNumber = document.getElementById('gcash_number').value.trim();
                    let receiptFile = document.getElementById('image_receipt').files[0];

                    if (!gcashName) {
                        showToast('Gcash Name is required.', 'danger');
                        return;
                    }

                    if (!gcashNumber) {
                        showToast('Gcash Number is required.', 'danger');
                        return;
                    }

                    if (!receiptFile) {
                        showToast('Receipt is required.', 'danger');
                        return;
                    }

                    formData.append('gcash_name', gcashName);
                    formData.append('gcash_number', gcashNumber);
                    formData.append('image_receipt', receiptFile);
                }

                fetch('/submit-payment', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData 
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.setItem('paymentSuccess', 'true');
                        location.reload();
                    } else {
                        showToast('An error occurred: ' + (data.message || 'Unknown error'), 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('An error occurred: ' + error.message, 'danger');
                });
            });

    
            if (localStorage.getItem('paymentSuccess') === 'true') {
                showToast('Payment Processed Successfully!');
                localStorage.removeItem('paymentSuccess');
            }
        });
    </script>
</body>
