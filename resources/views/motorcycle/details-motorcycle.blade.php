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
                        {{-- <h4 class="text-white mb-4 text-center"> MOTORCYCLE RESERVATION</h4> --}}
                        <form action="{{ route('reservation.details') }}" method="GET">
                            <input type="hidden" name="motorcycle_id" value="{{ $motorcycle->motor_id }}">
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-calendar-alt"></span><span class="ms-1">Rental Dates</span>
                                        </div>
                                        <input type="text" id="dateRangePicker" name="rental_dates" class="form-control" readonly>
                                    </div>
                                </div>
                        
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-clock"></span><span class="ms-2">Pick Up</span>
                                        </div>
                                        <select class="form-select" id="pickUpTimePicker" name="pick_up" aria-label="Pick Up Time">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-clock"></span><span class="ms-1">Drop off</span>
                                        </div>
                                        <select class="form-select" id="dropOffTimePicker" name="drop_off" aria-label="Drop off Time">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="input-group mb-1">
                                        <div class="d-flex align-items-center bg-light text-body rounded-start p-2">
                                            <span class="fas fa-user"></span><span class="ms-2">How are you riding?</span>
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
                                        <button type="submit" class="btn btn-light w-100 py-2">Rent Now</button>
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
        var today = moment().startOf('day');
        var tomorrow = moment(today).add(1, 'days');
        var motorcyclePrice = <?php echo json_encode($motorcycle->price); ?>;

        function updateRentalInfo(start, end) {
            var days = end.diff(start, 'days'); 
            $('#dateRangePicker').val(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
            $('#rentalDays').text(days + ' Day' + (days !== 1 ? 's' : '') + ' Rental');
            var totalPrice = days * motorcyclePrice;
            $('#rentalPrice').text(' ₱' + totalPrice.toLocaleString('en-PH', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }));
        }

        $('#dateRangePicker').daterangepicker({
            startDate: today,
            endDate: tomorrow,
            opens: 'left',
            locale: {
                format: 'DD/MM/YYYY'
            },
            minDate: today,
        });

        updateRentalInfo(today, tomorrow);

        $('#dateRangePicker').on('apply.daterangepicker', function(ev, picker) {
            updateRentalInfo(picker.startDate, picker.endDate);
        });

        $('#dateRangePicker').on('cancel.daterangepicker', function(ev, picker) {
            updateRentalInfo(today, tomorrow);
        });

        $('#dateRangePicker').prop('readonly', false);
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
</script>
