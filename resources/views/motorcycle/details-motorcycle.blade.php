<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Details Motorcycle</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.css">
    @include('partials.customer-link')
    <link href="{{ asset('assets/css/details.css') }}" rel="stylesheet">
</head>

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
                            <img id="main-image" style="max-width: 100%; max-height: 100vh; margin: auto;"
                                class="rounded-4 fit" src="{{ asset('storage/' . $images[0]) }}" />
                        @endif
                    </div>
                    <div class="d-flex justify-content-center mb-3">
                        @if ($motorcycle->images)
                            @php
                                $images = json_decode($motorcycle->images);
                            @endphp
                            @foreach ($images as $image)
                                <a href="javascript:void(0);" class="border mx-1 rounded-2"
                                    onclick="showImage('{{ asset('storage/' . $image) }}')" class="item-thumb">
                                    <img class="rounded-2" src="{{ asset('storage/' . $image) }}"
                                        style="width: 60px; height: 60px; object-fit: cover;" />
                                </a>
                            @endforeach
                        @endif
                    </div>
                </div>

                <div class="col-lg-6">
                    <!-- Rental form -->
                    <div class="bg-secondary rounded p-5 mb-3">
                        <h6 class="text-white text-center" id="rentalDays"></h6>
                        <h4 class="text-white text-center fw-bold mb-4" id="rentalPrice"></h4>
                        <hr>
                        <form action="{{ route('reservation.details') }}" method="GET">
                            <input type="hidden" name="motorcycle_id" value="{{ $motorcycle->motor_id }}">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-calendar-alt"></span>
                                            <span class="ms-1">Rental Dates</span>
                                        </div>
                                        <input type="text" id="dateRangePicker" name="rental_dates"
                                            class="form-control" readonly placeholder="Select rental dates" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-clock"></span><span class="ms-2">Pick Up</span>
                                        </div>
                                        <select class="form-select" id="pickUpTimePicker" name="pick_up"
                                            aria-label="Pick Up Time">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-clock"></span><span class="ms-1">Drop off</span>
                                        </div>
                                        <select class="form-select" id="dropOffTimePicker" name="drop_off"
                                            aria-label="Drop off Time">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-user"></span><span class="ms-2">How are you
                                                riding?</span>
                                        </div>
                                        <select class="form-select" name="riding" aria-label="riding">
                                            <option value="Alone">Alone</option>
                                            <option value="With a Passenger">With a Passenger</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    @guest('customer')
                                        <a href="{{ route('login') }}" class="btn btn-light w-100 py-2">Login to Rent Now</a>
                                    @else
                                        @if ($status === 'Available')
                                            @if (!$canRent)
                                                @if (in_array($penaltyStatus, ['Not Paid', 'Pending']))
                                                    <button type="button" class="btn btn-light w-100 py-2 mb-2" id="penalty-not-paid-button">
                                                       Rent Now
                                                    </button>
                                                @elseif ($penaltyStatus === 'Banned')
                                                    <button type="button" class="btn btn-light w-100 py-2 mb-2" id="customer-banned-button">
                                                        Rent Now
                                                    </button>
                                                @endif
                                            @else
                                                <button type="submit" class="btn btn-light w-100 py-2 mb-2" id="rent-now-button">
                                                    Rent Now
                                                </button>
                                            @endif
                                        @else
                                            <button type="button" class="btn btn-light w-100 py-2 mb-2" id="not-available-button">
                                                Rent Now
                                            </button>
                                        @endif
                                    @endguest
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

                        <dt class="col-2">Engine Capacity (CC):</dt>
                        <dd class="col-9">{{ $motorcycle->cc }}</dd>

                        <dt class="col-2">Year:</dt>
                        <dd class="col-9">{{ $motorcycle->year }}</dd>

                        <dt class="col-2">Gas:</dt>
                        <dd class="col-9">{{ $motorcycle->gas }}</dd>

                        <dt class="col-2">Color:</dt>
                        <dd class="col-9">{{ $motorcycle->color }}</dd>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @include('partials.customer-footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-daterangepicker/3.0.5/daterangepicker.js"></script>

</body>

</html>
<script>
    document.getElementById('dateRangePicker').addEventListener('keypress', function(e) {
        e.preventDefault();
    });

    function showImage(imageUrl) {
        const mainImage = document.getElementById('main-image');
        mainImage.src = imageUrl;
    }

    $(function() {
        var motorcyclePrice = <?php echo json_encode($motorcycle->price); ?>;
        var reservedDates = <?php echo json_encode($reservedDates); ?>;

        function isDateReserved(date) {
            return reservedDates.some(function(reservation) {
                var start = moment(reservation.start);
                var end = moment(reservation.end);
                return date.isBetween(start, end, 'day', '[]');
            });
        }

        function updateRentalInfo(start, end) {
            if (!start || !end) return;

            var days = end.diff(start, 'days');
            $('#dateRangePicker').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            $('#rentalDays').text(days + ' Day' + (days !== 1 ? 's' : '') + ' Rental');
            var totalPrice = days * motorcyclePrice;
            $('#rentalPrice').text(' ₱' + totalPrice.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));

            if (days === 1) {
                var pickUpTime = $('#pickUpTimePicker').val();
                $('#dropOffTimePicker').val(pickUpTime).prop('disabled', true);

                $('form').append('<input type="hidden" name="drop_off" value="' + pickUpTime + '">');
            } else {
                $('#dropOffTimePicker').prop('disabled', false);
                $('form input[name="drop_off"]').remove();
            }
        }

        $('#dateRangePicker').daterangepicker({
            opens: 'left',
            autoUpdateInput: false,
            locale: {
                format: 'DD/MM/YYYY',
                cancelLabel: 'Clear'
            },
            minDate: moment().startOf('day'),
            isInvalidDate: function(date) {
                return isDateReserved(date);
            }
        });

        // Handle date selection
        $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
            var start = picker.startDate;
            var end = picker.endDate;
            var hasConflict = false;

            var current = moment(start);
            while (current.isSameOrBefore(end, 'day')) {
                if (isDateReserved(current)) {
                    hasConflict = true;
                    break;
                }
                current.add(1, 'day');
            }

            if (hasConflict) {
                Swal.fire({
                    title: 'Date Not Available',
                    text: 'One or more selected dates are already reserved. Please choose different dates.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#3085d6'
                });
                $(this).val('');
                return;
            }

            updateRentalInfo(picker.startDate, picker.endDate);
        });

        // Handle date clear
        $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#rentalDays').text('Select dates');
            $('#rentalPrice').text('₱0.00');
        });

        $('#pickUpTimePicker').on('change', function() {
            var dateRange = $('#dateRangePicker').val();
            if (dateRange) {
                var days = moment(dateRange.split(' - ')[1], 'DD/MM/YYYY').diff(
                    moment(dateRange.split(' - ')[0], 'DD/MM/YYYY'),
                    'days'
                );

                if (days === 1) {
                    $('#dropOffTimePicker').val($(this).val()).prop('disabled', true);

                    var $hiddenDropOff = $('form input[name="drop_off"]');
                    if ($hiddenDropOff.length) {
                        $hiddenDropOff.val($(this).val());
                    } else {
                        $('form').append('<input type="hidden" name="drop_off" value="' + $(this).val() + '">');
                    }
                }
            }
        });

        $('#dateRangePicker').prop('readonly', true);
    });

    //pick up and drop off
    function generateTimeOptions(selectId) {
        const select = document.getElementById(selectId);
        const startTime = 8;
        const endTime = 18;

        for (let hour = startTime; hour <= endTime; hour++) {
            const displayHour = hour % 12 === 0 ? 12 : hour % 12;
            const period = hour < 12 ? 'AM' : 'PM';

            select.appendChild(new Option(`${displayHour}:00 ${period}`, `${displayHour}:00 ${period}`));
            select.appendChild(new Option(`${displayHour}:30 ${period}`, `${displayHour}:30 ${period}`));
        }
    }

    window.onload = function() {
        generateTimeOptions('pickUpTimePicker');
        generateTimeOptions('dropOffTimePicker');
    };

    //not available
    document.addEventListener('DOMContentLoaded', function() {
        const notAvailableBtn = document.getElementById('not-available-button');
        if (notAvailableBtn) {
            notAvailableBtn.addEventListener('click', function() {
                Swal.fire({
                    title: 'Not Available',
                    text: 'Sorry, this motorcycle is currently not available for rent. Please check back later or browse our other available motorcycles.',
                    icon: 'info',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1f2e4e'
                });
            });
        }
    });

    //not paid
    @if (isset($penaltyStatus) && ($penaltyStatus === 'Not Paid' || $penaltyStatus === 'Pending'))

        const penaltyNotPaidBtn = document.getElementById('penalty-not-paid-button');
        if (penaltyNotPaidBtn) {
            penaltyNotPaidBtn.addEventListener('click', function() {
                Swal.fire({
                    icon: 'warning',
                    title: 'Outstanding Penalty',
                    text: 'You need to settle your unpaid penalty before proceeding with the rental.',
                    showCancelButton: true,
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1f2e4e',
                    customClass: {
                        actions: 'swal2-actions-right' 
                    },
                }).then((result) => {
                    if (result.isDismissed) {
                    }
                });
            });
        }
    @endif

    // Banned Account Handler
    @if (isset($penaltyStatus) && $penaltyStatus === 'Banned')
        const customerBannedBtn = document.getElementById('customer-banned-button');
        if (customerBannedBtn) {
            customerBannedBtn.addEventListener('click', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Account Suspended',
                    text: 'Your account is currently banned. Please contact customer support.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1f2e4e'
                });
            });
        }
    @endif

    const rentNowButton = document.getElementById('rent-now-button');
    const dateRangePicker = document.getElementById('dateRangePicker');

    //select rental dates
    if (rentNowButton) {
        rentNowButton.addEventListener('click', function(event) {
            if (!dateRangePicker.value) {
                event.preventDefault();
                Swal.fire({
                    title: 'Rental Dates Required',
                    text: 'Please select rental dates before proceeding.',
                    icon: 'error',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#1f2e4e'
                });
                return;
            }

            @if (isset($penaltyStatus) && ($penaltyStatus === 'Not Paid' || $penaltyStatus === 'Banned'))
                event.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: '{{ $penaltyStatus === 'Not Paid' ? 'Penalty Outstanding' : 'Account Suspended' }}',
                    text: '{{ $penaltyStatus === 'Not Paid' ? 'Please settle your outstanding penalty before renting.' : 'Your account is currently suspended. Contact customer support.' }}',
                    confirmButtonText: 'OK'
                });
            @endif
        });
    }
</script>