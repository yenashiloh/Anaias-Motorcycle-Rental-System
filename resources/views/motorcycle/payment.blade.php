<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Reservation Details</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    @include('partials.customer-link')
    <style>
        .check-circle {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background-color: #4CAF50;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 15px rgba(76, 175, 80, 0.1);
            margin-bottom: 30px;
            margin-top: 10px;
        }

        .check-mark {
            width: 40px;
            height: 40px;
        }

        .check-mark path {
            stroke: white;
            stroke-width: 4;
            stroke-linecap: round;
            stroke-linejoin: round;
            fill: none;
        }

        #reservationDetails {
            text-align: left;
            margin-top: 20px;
        }

        #paymentImageContainer img {
            max-width: 100%;
            height: auto;
            margin-top: 10px;
        }

        #reservationDetails h4 {
            margin-bottom: 15px;
        }

        #reservationDetails .d-flex {
            margin-bottom: 10px;
        }

        #reservationDetails hr {
            margin: 15px 0;
        }

        #modalOkButton {
            background-color: #1f2e4e;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            cursor: pointer;
            width: 100%;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Add hover effect */
        #modalOkButton:hover {
            background-color: #B30001;
        }
    </style>

</head>

<body>
    @include('partials.customer-header')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="text-center mb-4">
                        <h3 class="fw-bold">Payment</h3>
                        <p>To complete your reservation, kindly pay the total rental amount for your selected dates.</p>
                        <img src="{{ asset('assets/img/gcash.jpg') }}" alt="GCash" class="img-fluid"
                            style="max-width: 40%;">
                    </div>
                    <form action="{{ route('payment.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="reservation_id" value="{{ $reservation->reservation_id }}">

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="name" class="form-label">GCash Name</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>

                            <div class="col-md-6">
                                <label for="number" class="form-label">GCash Number</label>
                                <input type="text" class="form-control" id="number" name="number" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="receipt" class="form-label">Receipt Number</label>
                                <input type="text" class="form-control" id="receipt" name="receipt" required>
                            </div>

                            <div class="col-md-6">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="number" class="form-control" id="amount" name="amount" required>
                                <div id="amount-error" class="text-danger" style="display: none;"></div>
                                <!-- Error message div -->
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label">Upload Payment Receipt</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*"
                                required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-secondary mt-2 w-50" id="submit-button">Complete
                                Payment</button>
                        </div>

                    </form>

                </div>
                <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title text-center fw-bold" id="successModalLabel">Successfully Booked
                                </h6>

                            </div>
                            <div class="modal-body">
                                <div class="text-center">

                                    <div class="check-circle">
                                        <svg class="check-mark" viewBox="0 0 52 52">
                                            <path d="M14 27l7.8 7.8L38 14" />
                                        </svg>
                                    </div>
                                    <p class="fw-bold">Please wait for the admin to review and confirm your booking. You
                                        will receive a
                                        notification once it's approved. Thank you!</p>
                                </div>
                                <div id="reservationDetails">
                                    <p><strong>Booking ID:</strong> <span id="bookingId"></span></p>
                                    <p><strong>Motorcycle Name:</strong> <span id="motorcycleName"></span></p>
                                    <p><strong>Pickup:</strong> <span id="pickupInfo"></span></p>
                                    <p><strong>Drop-off:</strong> <span id="dropoffInfo"></span></p>
                                    <p><strong>Rental Start Date:</strong> <span id="rentalStartDate"></span></p>
                                    <p><strong>Rental End Date:</strong> <span id="rentalEndDate"></span></p>
                                    <p><strong>GCash Name:</strong> <span id="gcashName"></span></p>
                                    <p><strong>GCash Number:</strong> <span id="gcashNumber"></span></p>
                                    <p><strong>Receipt Number:</strong> <span id="receiptNumber"></span></p>
                                    <p><strong>Total:</strong> <span id="totalPrice"></span></p>
                                    <div id="paymentImageContainer" class="text-center mt-3">
                                        <h6>Payment Receipt</h6>
                                        <img id="paymentImage" src="" alt="Payment Receipt"
                                            class="img-fluid mt-2" style="max-height: 300px;">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" id="modalOkButton">Proceed to
                                    dashboard</button>
                            </div>
                        </div>
                    </div>
                </div>
                @php
                    $dates = explode(' - ', $reservationData['rental_dates']);
                    $pickupDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[0]);
                    $dropoffDate = \Carbon\Carbon::createFromFormat('d/m/Y', $dates[1]);
                    $days = abs($dropoffDate->diffInDays($pickupDate));
                    $total = $days * $motorcycle->price;
                @endphp

                <div class="col-md-4 mt-5">
                    <div class="card reservation-details shadow">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start ">
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
                                    <p>
                                        {{ \Carbon\Carbon::parse($reservation->pick_up)->format('d/m/Y') }}<br>
                                        {{ \Carbon\Carbon::parse($reservation->pick_up)->format('h:iA') }}
                                    </p>
                                </div>
                                <div>
                                    <strong style="color: blue;">Drop-off</strong>
                                    <p>
                                        {{ \Carbon\Carbon::parse($reservation->drop_off)->format('d/m/Y') }}<br>
                                        {{ \Carbon\Carbon::parse($reservation->drop_off)->format('h:iA') }}
                                    </p>
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

                        </div>
                    </div>
                    </form>
                </div>

                <div class="col-md-8">
                    <h4 class="fw-bold mt-5">Driver Information</h4>
                    <input type="hidden" name="motorcycle_id" value="{{ $motorcycle->motor_id }}">
                    <input type="hidden" name="rental_dates" value="{{ $reservationData['rental_dates'] }}">
                    <input type="hidden" name="pick_up" value="{{ $reservationData['pick_up'] }}">
                    <input type="hidden" name="drop_off" value="{{ $reservationData['drop_off'] }}">
                    <input type="hidden" name="riding" value="{{ $reservationData['riding'] }}">
                    <input type="hidden" name="total" value="{{ $total }}">

                    @if ($driverInformation)
                        <!-- Row 1: First Name, Last Name, Email -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">First Name</label>
                                <p class="form-control-static">{{ $driverInformation->first_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Last Name</label>
                                <p class="form-control-static">{{ $driverInformation->last_name }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Email</label>
                                <p class="form-control-static">{{ $driverInformation->email }}</p>
                            </div>
                        </div>

                        <!-- Row 2: Contact Number, Address, Date of Birth -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Contact Number</label>
                                <p class="form-control-static">{{ $driverInformation->contact_number }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Address</label>
                                <p class="form-control-static">{{ $driverInformation->address }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Date of Birth</label>
                                <p class="form-control-static">{{ $driverInformation->birthdate }}</p>
                            </div>
                        </div>

                        <!-- Row 3: Gender, Driver License -->
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Gender</label>
                                <p class="form-control-static">{{ ucfirst($driverInformation->gender) }}</p>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-bold">Driver License</label>
                                @if ($driverInformation->driver_license)
                                    <img src="{{ asset('storage/' . $driverInformation->driver_license) }}"
                                        alt="Driver License" class="img-fluid">
                                @else
                                    <p class="form-control-static">No license image uploaded</p>
                                @endif
                            </div>
                        </div>
                    @else
                        <p>No driver information available.</p>
                    @endif
                </div>
            </div>
        </div>
        </div>
        </div>
    </section>

    @include('partials.customer-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const amountInput = document.getElementById('amount');
            const errorDiv = document.getElementById('amount-error');
            const submitButton = document.getElementById('submit-button');

            const totalAmount = {{ abs($total) }};

            function formatNumber(num) {
                return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

            amountInput.addEventListener('input', function() {
                const enteredAmount = parseFloat(this.value.replace(/,/g, '')) || 0;

                if (enteredAmount !== totalAmount) {
                    errorDiv.textContent = `The amount must be ₱${formatNumber(totalAmount)}.`;
                    errorDiv.style.display = 'block';
                    submitButton.disabled = true;
                } else {
                    errorDiv.style.display = 'none';
                    submitButton.disabled = false;
                }
            });

            document.querySelectorAll('input').forEach(input => {
                input.disabled = false;
            });

            submitButton.disabled = false;
        });
        $(document).ready(function() {
            $('form').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            var pickUpDate = new Date('{{ $reservation->pick_up }}');
                            var dropOffDate = new Date('{{ $reservation->drop_off }}');

                            var options = {
                                year: 'numeric',
                                month: '2-digit',
                                day: '2-digit',
                                hour: 'numeric',
                                minute: '2-digit',
                                hour12: true
                            };
                            $('#bookingId').text(response.booking_id);
                            $('#motorcycleName').text('{{ $motorcycle->name }}');
                            $('#pickupInfo').text(
                                '{{ \Carbon\Carbon::parse($reservation->pick_up)->format('Y-m-d, g:iA') }}'
                            );
                            $('#dropoffInfo').text(
                                '{{ \Carbon\Carbon::parse($reservation->drop_off)->format('Y-m-d, g:iA') }}'
                            );

                            $('#rentalStartDate').text(
                                '{{ $reservation->rental_start_date }}');
                            $('#rentalEndDate').text('{{ $reservation->rental_end_date }}');
                            $('#totalPrice').text('₱{{ number_format(abs($total), 2) }}');
                            $('#gcashName').text($('#name').val());
                            $('#gcashNumber').text($('#number').val());
                            $('#receiptNumber').text($('#receipt').val());

                            if (response.payment_image) {
                                var imagePath = '/storage/receipts/' + response
                                    .payment_image;
                                $('#paymentImage').attr('src', imagePath)
                                    .on('load', function() {
                                        $('#paymentImageContainer').show();
                                    })
                                    .on('error', function() {
                                        console.error('Failed to load image:', imagePath);
                                        $('#paymentImageContainer').hide();
                                    });
                            } else {
                                $('#paymentImageContainer').hide();
                            }

                            var successModal = new bootstrap.Modal(document.getElementById(
                                'successModal'));
                            successModal.show();

                            $('#modalOkButton').on('click', function() {
                                window.location.href =
                                    '{{ route('customer.customer-dashboard') }}';
                            });
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>

</body>

</html>
