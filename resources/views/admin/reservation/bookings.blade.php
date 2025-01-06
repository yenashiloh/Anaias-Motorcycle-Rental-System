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
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-line nav-color-secondary d-flex justify-content-between w-100" id="line-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link" id="line-home-tab" data-bs-toggle="pill" href="#line-home"
                                    role="tab" aria-controls="line-home" aria-selected="true">To Review Status</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="line-profile-tab" data-bs-toggle="pill" href="#line-profile"
                                    role="tab" aria-controls="line-profile" aria-selected="false">Approved Status</a>
                            </li>
                            <li class="nav-item ms-auto">
                                <a href="{{ route('export.reservations') }}" class="btn btn-secondary btn-round">
                                    <i class="fas fa-file-export"></i> Export
                                </a>
                            </li>
                        </ul>
                        
                        <div class="tab-content mt-3 mb-3" id="line-tabContent">
                            <div class="tab-pane fade" id="line-home" role="tabpanel" aria-labelledby="line-home-tab">
                                <div class="col-md-12">

                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">List of To Review Bookings</h4>
                                           
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="basic-datatables"
                                                class="display table table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Booking Date</th>
                                                        <th>Motorcycle</th>
                                                        <th>Name</th>
                                                        <th>Rental Start Date</th>
                                                        <th>Rental End Date</th>
                                                        <th>Duration</th>
                                                        <th>Total Price</th>
                                                        <th>Booking Status</th>
                                                        <th>Payment Status</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($toReviewBookings as $index => $booking)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($booking['created_at'])->setTimezone('Asia/Manila')->format('F d, Y, g:i A') }}</td>
                                                            </td>
                                                            <td>
                                                                <img src="{{ asset('storage/' . $booking['motorcycle_image']) }}"
                                                                    alt="Motorcycle Image"
                                                                    style="width: 100px; height: auto;">
                                                            </td>
                                                            <td>{{ $booking['driver_name'] }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($booking['rental_start_date'])->format('F d, Y') }}</td> 
                                                            <td>{{ \Carbon\Carbon::parse($booking['rental_end_date'])->format('F d, Y') }}</td> 
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
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            @if ($booking['payment_status'] === 'Unpaid')
                                                                                <span class="badge bg-danger">Unpaid <i
                                                                                        class="fas fa-chevron-down"></i></span>
                                                                            @elseif ($booking['payment_status'] === 'Pending')
                                                                                <span class="badge bg-warning">Pending
                                                                                    <i
                                                                                        class="fas fa-chevron-down"></i></span>
                                                                            @endif
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="paymentStatusDropdown{{ $booking['reservation_id'] }}">
                                                                            @if ($booking['payment_status'] === 'Unpaid')
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Paid">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">Set
                                                                                            to Paid</button>
                                                                                    </form>
                                                                                </li>
                                                                            @elseif ($booking['payment_status'] === 'Pending')
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Paid">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">Set
                                                                                            to Paid</button>
                                                                                    </form>
                                                                                </li>
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Unpaid">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">Set
                                                                                            to Unpaid</button>
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
                                                                        <form
                                                                            action="{{ route('reservations.approve', $booking['reservation_id']) }}"
                                                                            method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn btn-link btn-success"
                                                                                data-bs-toggle="tooltip"
                                                                                title="Approve">
                                                                                <i class="fa fa-check"></i>
                                                                            </button>
                                                                        </form>
                                                                        <form action="{{ route('reservations.decline', $booking['reservation_id']) }}" method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <button type="button" class="btn btn-link btn-danger" data-bs-toggle="modal" 
                                                                                    data-bs-target="#declineModal{{ $booking['reservation_id'] }}" title="Decline">
                                                                                <i class="fa fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    @elseif ($booking['status'] == 'Approved')
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-link btn-info"
                                                                                type="button"
                                                                                id="moreActionsDropdown{{ $booking['reservation_id'] }}"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false"
                                                                                data-bs-tooltip="tooltip"
                                                                                title="More Actions">
                                                                                <i class="fas fa-ellipsis-h"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu"
                                                                                aria-labelledby="moreActionsDropdown{{ $booking['reservation_id'] }}">
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.markOngoing', $booking['reservation_id']) }}"
                                                                                        method="POST" class="m-0">
                                                                                        @csrf
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">
                                                                                            <i
                                                                                                class="fas fa-check"></i>
                                                                                            Ongoing
                                                                                        </button>
                                                                                    </form>
                                                                                </li>
                                                                                <li>
                                                                                    <form class="m-0">
                                                                                        <button type="button"
                                                                                            class="dropdown-item"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#cancelModal"
                                                                                            data-id="{{ $booking['reservation_id'] }}">
                                                                                            <i
                                                                                                class="fas fa-times"></i>
                                                                                            Cancel
                                                                                        </button>
                                                                                    </form>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                    <a href="{{ route('admin.reservation.view-bookings', $booking['reservation_id']) }}"
                                                                        class="btn btn-link btn-primary"
                                                                        data-bs-toggle="tooltip"
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
                            <div class="tab-pane fade" id="line-profile" role="tabpanel" aria-labelledby="line-profile-tab">
                                <div class="col-md-12">

                                    <div class="card-header">
                                        <div class="d-flex align-items-center">
                                            <h4 class="card-title">List of To Approved Bookings</h4>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table id="approved-datatables"
                                                class="display table table-striped table-hover">
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
                                                    @foreach ($approvedBookings as $index => $booking)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ \Carbon\Carbon::parse($booking['created_at'])->format('F d, Y, g:i A') }}
                                                            </td>
                                                            <td>
                                                                <img src="{{ asset('storage/' . $booking['motorcycle_image']) }}"
                                                                    alt="Motorcycle Image"
                                                                    style="width: 100px; height: auto;">
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
                                                                            data-bs-toggle="dropdown"
                                                                            aria-expanded="false">
                                                                            @if ($booking['payment_status'] === 'Unpaid')
                                                                                <span class="badge bg-danger">Unpaid <i
                                                                                        class="fas fa-chevron-down"></i></span>
                                                                            @elseif ($booking['payment_status'] === 'Pending')
                                                                                <span class="badge bg-warning">Pending
                                                                                    <i
                                                                                        class="fas fa-chevron-down"></i></span>
                                                                            @endif
                                                                        </button>
                                                                        <ul class="dropdown-menu"
                                                                            aria-labelledby="paymentStatusDropdown{{ $booking['reservation_id'] }}">
                                                                            @if ($booking['payment_status'] === 'Unpaid')
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Paid">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">Set
                                                                                            to Paid</button>
                                                                                    </form>
                                                                                </li>
                                                                            @elseif ($booking['payment_status'] === 'Pending')
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Paid">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">Set
                                                                                            to Paid</button>
                                                                                    </form>
                                                                                </li>
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.update-payment-status', $booking['reservation_id']) }}"
                                                                                        method="POST">
                                                                                        @csrf
                                                                                        <input type="hidden"
                                                                                            name="status"
                                                                                            value="Unpaid">
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">Set
                                                                                            to Unpaid</button>
                                                                                    </form>
                                                                                </li>
                                                                            @endif
                                                                        </ul>
                                                                    </div>
                                                                @endif
                                                            </td>
                                                            <td class="text-center align-middle">
                                                                <div class="form-button-action">
                                                                    @if ($booking['status'] == 'To Review')
                                                                        <form
                                                                            action="{{ route('reservations.approve', $booking['reservation_id']) }}"
                                                                            method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn btn-link btn-success"
                                                                                data-bs-toggle="tooltip"
                                                                                title="Approve">
                                                                                <i class="fa fa-check"></i>
                                                                            </button>
                                                                        </form>
                                                                        <form
                                                                            action="{{ route('reservations.decline', $booking['reservation_id']) }}"
                                                                            method="POST" style="display: inline;">
                                                                            @csrf
                                                                            <button type="submit"
                                                                                class="btn btn-link btn-danger"
                                                                                data-bs-toggle="tooltip"
                                                                                title="Decline">
                                                                                <i class="fa fa-times"></i>
                                                                            </button>
                                                                        </form>
                                                                    @elseif ($booking['status'] == 'Approved')
                                                                        <div class="dropdown">
                                                                            <button class="btn btn-link btn-info"
                                                                                type="button"
                                                                                id="moreActionsDropdown{{ $booking['reservation_id'] }}"
                                                                                data-bs-toggle="dropdown"
                                                                                aria-expanded="false"
                                                                                data-bs-tooltip="tooltip"
                                                                                title="More Actions">
                                                                                <i class="fas fa-ellipsis-h"></i>
                                                                            </button>
                                                                            <ul class="dropdown-menu"
                                                                                aria-labelledby="moreActionsDropdown{{ $booking['reservation_id'] }}">
                                                                                <li>
                                                                                    <form
                                                                                        action="{{ route('reservations.markOngoing', $booking['reservation_id']) }}"
                                                                                        method="POST" class="m-0">
                                                                                        @csrf
                                                                                        <button type="submit"
                                                                                            class="dropdown-item">
                                                                                            <i
                                                                                                class="fas fa-check"></i>
                                                                                            Ongoing
                                                                                        </button>
                                                                                    </form>
                                                                                </li>
                                                                                <li>
                                                                                    <form class="m-0">
                                                                                        <button type="button"
                                                                                            class="dropdown-item"
                                                                                            data-bs-toggle="modal"
                                                                                            data-bs-target="#cancelModal"
                                                                                            data-id="{{ $booking['reservation_id'] }}">
                                                                                            <i
                                                                                                class="fas fa-times"></i>
                                                                                            Cancel
                                                                                        </button>
                                                                                    </form>
                                                                                </li>
                                                                            </ul>
                                                                        </div>
                                                                    @endif
                                                                    <a href="{{ route('admin.reservation.view-bookings', $booking['reservation_id']) }}"
                                                                        class="btn btn-link btn-primary"
                                                                        data-bs-toggle="tooltip"
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
                </div>
            </div>
        </div>
    </div>

    <!-- Decline Modal -->
    @foreach($toReviewBookings as $booking)
        <div class="modal fade" id="declineModal{{ $booking['reservation_id'] }}" tabindex="-1" aria-labelledby="declineModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="declineModalLabel">Decline Reservation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('reservations.decline', $booking['reservation_id']) }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="decline_reason" class="form-label">Decline Reason</label>
                                <textarea class="form-control" id="decline_reason" name="decline_reason" rows="6" required></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-secondary">Decline Reservation</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    <!-- Cancel Modal -->
    <div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelModalLabel">Cancel Reservation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="" method="POST" class="m-0" id="cancelForm">
                        @csrf
                        <div class="mb-3">
                            <label for="cancel_reason" class="form-label">Reason for Cancellation</label>
                            <textarea id="cancel_reason" name="cancel_reason" class="form-control" rows="6" required></textarea>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-outline-dark"
                                data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-secondary" id="confirmArchive">Submit</button>
                        </div>
                </div>
                </form>
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
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        if ($.fn.DataTable) {
            $("#basic-datatables").DataTable();
            $("#approved-datatables").DataTable();
        }
    })

    $(document).ready(function() {
        $('#cancelModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var reservationId = button.data('id');
            var form = $('#cancelForm');
            form.attr('action', '/admin/bookings/cancel/' +
                reservationId);
        });
    });

    //nav active
    document.addEventListener('DOMContentLoaded', function () {
        const tabButtons = document.querySelectorAll('[data-bs-toggle="pill"]');

        function activateTab(tabElement) {
            const tab = new bootstrap.Tab(tabElement);
            tab.show();
            
            document.querySelectorAll('[data-bs-toggle="pill"]').forEach(t => {
                t.setAttribute('aria-selected', 'false');
            });
            tabElement.setAttribute('aria-selected', 'true');
            
            localStorage.setItem('activeTab', tabElement.id);
        }
        
        const storedTabId = localStorage.getItem('activeTab');
        if (storedTabId) {
            const storedTab = document.getElementById(storedTabId);
            if (storedTab) {
                activateTab(storedTab);
            }
        } else {
            const firstTab = document.querySelector('[data-bs-toggle="pill"]');
            if (firstTab) {
                activateTab(firstTab);
            }
        }
        
        tabButtons.forEach(tabButton => {
            tabButton.addEventListener('click', function (e) {
                localStorage.setItem('activeTab', this.id);
            });
        });
        
        document.querySelectorAll('[data-bs-toggle="pill"]').forEach(tabEl => {
            tabEl.addEventListener('shown.bs.tab', function (e) {
                const targetId = e.target.getAttribute('href');
                const targetPane = document.querySelector(targetId);
                if (targetPane) {
                    targetPane.classList.add('show', 'active');
                }
            });
        });
    });

</script>
