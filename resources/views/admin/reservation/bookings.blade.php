<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Bookings Management</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Bookings Management</h3>
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
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}" class="fw-bold">Manage
                            Bookings</a>
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
                            <a href="{{ route('export.reservations') }}" class="btn btn-secondary btn-round ms-auto">
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
                                        <th>Name</th>
                                        <th>Rental Start Date</th>
                                        <th>Duration</th>
                                        <th>Total Price</th>
                                        <th>Booking Status</th>
                                        <th>Payment Status</th>
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
                                            <td>{{ \Carbon\Carbon::parse($booking['rental_start_date'])->format('F d, Y') }}
                                            </td>
                                            <td>{{ $booking['duration'] }}</td>
                                            <td>&#8369;{{ number_format($booking['total'], 2) }}</td>
                                            <td>
                                                <span
                                                    class="badge 
                                                    @if ($booking['status'] == 'Approved') badge-success 
                                                    @elseif($booking['status'] == 'Declined') badge-danger 
                                                    @elseif($booking['status'] == 'To Review') badge-primary 
                                                    @else badge-secondary @endif">
                                                    {{ $booking['status'] }}
                                                </span>
                                            </td>
                                            <td>
                                                @if ($booking['payment_status'] === 'Paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <div class="dropdown">
                                                        <button class="btn btn-link" type="button" 
                                                                id="paymentStatusDropdown{{ $booking['reservation_id'] }}" 
                                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                            @if ($booking['payment_status'] === 'Unpaid')
                                                                <span class="badge bg-danger">Unpaid <i class="fas fa-chevron-down"></i></span>
                                                            @elseif ($booking['payment_status'] === 'Pending')
                                                                <span class="badge bg-warning">Pending <i class="fas fa-chevron-down"></i></span>
                                                            @endif
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="paymentStatusDropdown{{ $booking['reservation_id'] }}">
                                                            @if ($booking['payment_status'] === 'Unpaid')
                                                                <li>
                                                                    <form action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Paid">
                                                                        <button type="submit" class="dropdown-item">Set to Paid</button>
                                                                    </form>
                                                                </li>
                                                                {{-- <li>
                                                                    <form action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Pending">
                                                                        <button type="submit" class="dropdown-item">Set to Pending</button>
                                                                    </form>
                                                                </li> --}}
                                                            @elseif ($booking['payment_status'] === 'Pending')
                                                                <li>
                                                                    <form action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Paid">
                                                                        <button type="submit" class="dropdown-item">Set to Paid</button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}" method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="status" value="Unpaid">
                                                                        <button type="submit" class="dropdown-item">Set to Unpaid</button>
                                                                    </form>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-button-action">
                                                    @if ($booking['status'] == 'To Review')
                                                        <form action="{{ route('reservations.approve', $booking['reservation_id']) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-link btn-success"
                                                                data-bs-toggle="tooltip" title="Approve">
                                                                <i class="fa fa-check"></i>
                                                            </button>
                                                        </form>
                                                        <form action="{{ route('reservations.decline', $booking['reservation_id']) }}"
                                                            method="POST" style="display: inline;">
                                                            @csrf
                                                            <button type="submit" class="btn btn-link btn-danger"
                                                                data-bs-toggle="tooltip" title="Decline">
                                                                <i class="fa fa-times"></i>
                                                            </button>
                                                        </form>
                                                    @elseif ($booking['status'] == 'Approved')
                                                        <div class="dropdown">
                                                            <button class="btn btn-link btn-info" type="button"
                                                                id="moreActionsDropdown{{ $booking['reservation_id'] }}"
                                                                data-bs-toggle="dropdown"
                                                                aria-expanded="false" 
                                                                data-bs-tooltip="tooltip"
                                                                title="More Actions">
                                                                <i class="fas fa-ellipsis-h"></i>
                                                            </button>
                                                            <ul class="dropdown-menu" aria-labelledby="moreActionsDropdown{{ $booking['reservation_id'] }}">
                                                                <li>
                                                                    <form action="{{ route('reservations.markOngoing', $booking['reservation_id']) }}"
                                                                        method="POST" class="m-0">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="fas fa-check"></i> Ongoing
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form action="{{ route('reservations.cancel', $booking['reservation_id']) }}"
                                                                        method="POST" class="m-0">
                                                                        @csrf
                                                                        <button type="submit" class="dropdown-item">
                                                                            <i class="fas fa-times"></i> Cancel
                                                                        </button>
                                                                    </form>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    @endif
                                                    <a href="{{ route('admin.reservation.view-bookings', $booking['reservation_id']) }}"
                                                        class="btn btn-link btn-primary" data-bs-toggle="tooltip"
                                                        title="View Bookings">
                                                        <i class="fa fa-eye"></i>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('partials.admin-footer')
</body>

</html>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    });

    // Initialize datatables
    if ($.fn.DataTable) {
        $("#basic-datatables").DataTable();
    }
})
</script>
