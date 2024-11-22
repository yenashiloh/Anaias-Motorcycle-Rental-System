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
                    <form id="registrationForm" action="{{ route('reservation.process') }}" method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <h4 class="fw-bold">Driver Information</h4>
                        <p>This is the information that will be used for the Rental Confirmation</p>

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p class="text-danger">{{ $error }}</p>
                            @endforeach
                        @endif


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
                                <input type="text" class="form-control" name="first_name" id="firstName"
                                    value="{{ old('first_name', $pastReservation ? $pastReservation->first_name : '') }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label">Last Name <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="last_name" id="lastName"
                                    value="{{ old('last_name', $pastReservation ? $pastReservation->last_name : '') }}"
                                    required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email <span
                                        class="text-danger">*</span></label>
                                <input type="email" class="form-control" id="email" name="email"
                                    value="{{ old('email', $pastReservation ? $pastReservation->email : '') }}"
                                    required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label">Contact Number</label>
                                <input type="tel" class="form-control" name="contact_number" id="phone"
                                    value="{{ old('contact_number', $pastReservation ? $pastReservation->contact_number : '') }}">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="address" class="form-label">Address <span
                                        class="text-danger">*</span></label>
                                <input type="text" class="form-control" name="address" id="address"
                                    {{ old('address', $pastReservation ? $pastReservation->address : '') }} required>
                            </div>
                            <div class="col-md-6">
                                <label for="dob" class="form-label">Date of Birth <span
                                        class="text-danger">*</span></label>
                                <input type="date" class="form-control" name="birthdate" id="dob" required>
                                <div id="ageError" class="text-danger mt-1" style="display: none;"> You must be at
                                    least 18 years of age to rent a motorcycle.</div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="gender" class="form-label">Gender <span
                                        class="text-danger">*</span></label>
                                <select class="form-select" id="gender" name="gender" required>
                                    <option value="" disabled selected>Select Gender</option>
                                    <option value="male"
                                        {{ old('gender', $pastReservation ? $pastReservation->gender : '') == 'male' ? 'selected' : '' }}>
                                        Male</option>
                                    <option value="female"
                                        {{ old('gender', $pastReservation ? $pastReservation->gender : '') == 'female' ? 'selected' : '' }}>
                                        Female</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="licenseImage" class="form-label">Upload Driver License <span
                                        class="text-danger">*</span></label>
                                <input type="file" class="form-control" id="licenseImage" name="driver_license"
                                    accept="image/*" {{ $pastReservation ? '' : 'required' }}>
                            </div>
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="termsCheck" required>
                            <label class="form-check-label" for="termsCheck">
                                I agree to the
                                <a href="#" id="termsLink" data-bs-toggle="modal" data-bs-target="#termsModal"
                                    style="text-decoration: underline; color: blue;">
                                    Terms and Conditions
                                </a>
                            </label>
                        </div>
                </div>

                <!-- Modal for Terms and Conditions -->
                <div class="modal fade" id="termsModal" tabindex="-1" aria-labelledby="termsModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h6 class="modal-title fw-bold" id="termsModalLabel">Agreements of Anaia’s Motorcycle
                                    Rental</h6>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                <h6>Terms and Conditions:</h6>
                                <ol>
                                    <li>Lessees must know how to drive properly. Your safety is our utmost priority.
                                    </li>
                                    <li>Must be 18 years old and above.</li>
                                    <li>Strictly no to drivers who are under the influence of alcohol.</li>
                                    <li>For long-term rentals, the contract and waiver to be provided by the operator
                                        shall be signed.</li>
                                </ol>
                                <br>
                                <h6>Duties and Obligations of the Renter:</h6>
                                <ol>
                                    <li>Follow the rules. Must 100% agree to the duties and obligations as a renter.
                                    </li>
                                    <li>Follow the rental term agreement (rental period, rental date, and return). If
                                        exceeded, it shall be subjected to approval and additional charges.</li>
                                    <li>In the event of rental extension, payment must be settled first thru Gcash.</li>
                                    <li>Strictly no overloading (2 persons only).</li>
                                    <li>Both drivers and back riders shall wear helmets at all times.</li>
                                    <li>If you lost the key, you have to pay 500 pesos.</li>
                                    <li>Fuel cost is your responsibility. Anaia's Moto Rental claims no responsibility
                                        for motorcycle fuel/consumption. If it's full-tank, please return it full-tank
                                        as well.</li>
                                    <li>If the unit is damaged after use, expect to pay additional charges depending on
                                        the severity of the damage. Motor parts will be charged to the renter and labor
                                        to Anaia's Motor Rental.</li>
                                    <li>If an accident occurs, Anaia's Motor Rental will give cash assistance worth
                                        P2,000 for major injuries and P5,000 for death as burial assistance.</li>
                                </ol>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $dates = explode(' - ', $reservationData['rental_dates']);
                    $pickupDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[0]));
                    $dropoffDate = \Carbon\Carbon::createFromFormat('d/m/Y', trim($dates[1]));

                    // Calculate days WITHOUT adding 1
                    $days = $pickupDate->diffInDays($dropoffDate);
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
                                <span>₱{{ number_format($total, 2) }}</span>
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
                            <div class="text-center mt-3">
                                <button type="submit" class="btn btn-secondary w-100" name="payment_method"
                                    value="gcash">Pay via GCash</button>
                                <div class="mt-2">or</div>
                                <button type="submit" class="btn btn-primary w-100 mt-2" name="payment_method"
                                    value="cash">Pay via Cash</button>
                            </div>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const dobInput = document.getElementById('dob');
        const ageError = document.getElementById('ageError');

        function checkAge() {
            const dob = new Date(dobInput.value);
            const today = new Date();

            let age = today.getFullYear() - dob.getFullYear();
            const monthDiff = today.getMonth() - dob.getMonth();

            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dob.getDate())) {
                age--;
            }

            if (age < 18) {
                ageError.style.display = 'block';
            } else {
                ageError.style.display = 'none';
            }
        }

        dobInput.addEventListener('change', checkAge);

        if (dobInput.value) {
            checkAge();
        }
    });
</script>
