<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Completed Bookings</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Completed Bookings</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{ route('admin.admin-dashboard') }}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}" class="fw-bold">Completed Bookings</a>
                    </li>

                </ul>
            </div>
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">List of Bookings</h4>
                            <a href="{{ route('export.all-bookings-record') }}"
                                class="btn btn-secondary btn-round ms-auto">
                                <i class="fas fa-file-export"></i>
                                Export
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Booking Date</th>
                                        <th>Motorcycle</th>
                                        <th>Driver Name</th>
                                        <th>Duration</th>
                                        <th>Total Price</th>
                                        <th>Booking Status</th>
                                        <th>Violation Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($bookings as $index => $booking)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ \Carbon\Carbon::parse($booking['created_at'])->format('F d, Y, g:i A') }}
                                            </td>

                                            <td>
                                                <img src="{{ asset('storage/' . $booking['motorcycle_image']) }}"
                                                    alt="Motorcycle Image" style="width: 100px; height: auto;">
                                            </td>
                                            <td>{{ $booking['driver_name'] }}</td>
                                            </td>
                                            <td>{{ $booking['duration'] }}</td>
                                            <td>&#8369;{{ number_format($booking['total'], 2) }}</td>
                                            <td class="text-center">
                                                <span
                                                    class="badge 
                                                    @if ($booking['status'] == 'Completed') badge-success 
                                                    @elseif($booking['status'] == 'Declined') badge-danger 
                                                    @elseif($booking['status'] == 'Cancelled') badge-warning
                                                    @else badge-secondary @endif">
                                                    {{ $booking['status'] }}
                                                </span>
                                            </td>
                                            
                                            <td class="text-center">
                                                <span
                                                    class="badge 
                                                    @if ($booking['violation_status'] == 'No Violation') badge-primary
                                                    @elseif($booking['violation_status'] == 'Violator') badge-danger 
                                                    @else badge-secondary @endif">
                                                    {{ $booking['violation_status'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="#" class="btn btn-link btn-secondary"
                                                        data-bs-toggle="modal" data-bs-target="#addPenaltyModal"
                                                        data-reservation-id="{{ $booking['reservation_id'] }}"
                                                        data-customer-id="{{ $booking['customer_id'] }}"
                                                        data-driver-id="{{ $booking['driver_id'] }}"
                                                        onclick="console.log('Booking Data:', {{ json_encode($booking) }})"
                                                        title="Add Penalty">
                                                        <i class="fas fa-plus-circle"></i>
                                                    </a>
                                                    <a href="{{ route('admin.reservation.view-all-bookings', $booking['reservation_id']) }}"
                                                        class="btn btn-link btn-primary" data-bs-toggle="tooltip"
                                                        title="View Bookings">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('reservations.invoice', $booking['reservation_id']) }}"
                                                        class="btn btn-link btn-success" data-bs-toggle="tooltip"
                                                        title="Download Invoice">
                                                        <i class="fas fa-download"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Penalty Modal -->
    <div class="modal fade" id="addPenaltyModal" tabindex="-1" aria-labelledby="addPenaltyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addPenaltyModalLabel">Add Penalty</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('penalties.store') }}" method="POST" id="penaltyForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="reservation_id" name="reservation_id">
                        <input type="hidden" id="customer_id" name="customer_id">
                        <input type="hidden" id="driver_id" name="driver_id">

                        <div class="mb-3">
                            <label for="penalty_type" class="form-label fw-bold">
                                Penalty Type
                                <span style="color: red;">*</span>
                            </label>
                            <input type="text" class="form-control" id="penalty_type" name="penalty_type" required>
                        </div>

                        <div class="mb-3">
                            <label for="additional_payment" class="form-label fw-bold">
                                Additional Payment
                                <span style="color: red;">*</span>
                            </label>
                            <input type="number" class="form-control" id="additional_payment"
                                name="additional_payment" required>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">
                                Description
                                <span style="color: red;">*</span>
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary"
                            data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-secondary">Add Penalty</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('partials.admin-footer')
</body>

</html>
<script>
    $(document).ready(function() {
        $("#basic-datatables").DataTable();
    });

    document.addEventListener('DOMContentLoaded', function() {
        const addPenaltyModal = document.getElementById('addPenaltyModal');

        addPenaltyModal.addEventListener('show.bs.modal', (event) => {
            const button = event.relatedTarget;

            const reservationId = button.getAttribute('data-reservation-id');
            const customerId = button.getAttribute('data-customer-id');
            const driverId = button.getAttribute('data-driver-id');

            console.log('Modal Values:', {
                reservationId,
                customerId,
                driverId
            });

            const reservationInput = addPenaltyModal.querySelector('#reservation_id');
            const customerInput = addPenaltyModal.querySelector('#customer_id');
            const driverInput = addPenaltyModal.querySelector('#driver_id');

            reservationInput.value = reservationId;
            customerInput.value = customerId;
            driverInput.value = driverId;

            console.log('Input Values After Set:', {
                reservation: reservationInput.value,
                customer: customerInput.value,
                driver: driverInput.value
            });
        });

        const additionalPaymentInput = document.getElementById('additional_payment');
        const additionalPaymentError = document.createElement('div');
        additionalPaymentError.classList.add('invalid-feedback');
        additionalPaymentInput.insertAdjacentElement('afterend', additionalPaymentError);

        additionalPaymentInput.addEventListener('input', function() {
            if (additionalPaymentInput.value === '0') {
                additionalPaymentInput.classList.add('is-invalid');
                additionalPaymentError.textContent = 'Additional payment cannot be 0.';
            } else {
                additionalPaymentInput.classList.remove('is-invalid');
                additionalPaymentError.textContent = '';
            }
        });

        const penaltyForm = document.getElementById('penaltyForm');
        penaltyForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const reservationId = this.querySelector('#reservation_id').value;
            const customerId = this.querySelector('#customer_id').value;
            const driverId = this.querySelector('#driver_id').value;

            console.log('Form Submission Values:', {
                reservation: reservationId,
                customer: customerId,
                driver: driverId
            });

            if (!reservationId || !customerId || !driverId) {
                Swal.fire({
                    title: 'Error',
                    text: 'Missing required information. Please try again.',
                    icon: 'error'
                });
                return;
            }

            if (additionalPaymentInput.value === '0') {
                return;
            }

            this.submit();
        });
    });
</script>
