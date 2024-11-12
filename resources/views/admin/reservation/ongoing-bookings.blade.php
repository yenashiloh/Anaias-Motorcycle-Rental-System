<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Ongoing Bookings</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Ongoing Bookings</h3>
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
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}" class="fw-bold">Ongoing Bookings</a>
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
                            <h4 class="card-title">List of Ongoing Bookings</h4>
                            <a href="{{ route('export.ongoing-bookings') }}" class="btn btn-secondary btn-round ms-auto">
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
                                        <th>Booked Date</th>
                                        <th>Motorcycle</th>
                                        <th>Driver Name</th>
                                        <th>Rental Start Date</th>
                                        <th>Duration</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
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
                                                {{ $booking['status'] === 'Ongoing' ? 'bg-warning' : '' }} ">
                                                    {{ $booking['status'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="form-button-action d-flex align-items-center">
                                                    <form action="{{ route('reservations.completed', $booking['reservation_id']) }}" method="POST" class="m-0">
                                                        @csrf
                                                        <button type="submit" class="btn btn-link btn-success" data-bs-toggle="tooltip" title="Complete Reservation">
                                                            <i class="fas fa-check"></i>
                                                        </button>
                                                    </form>
                                                    <a href="{{ route('admin.reservation.view-ongoing-bookings', $booking['reservation_id']) }}"
                                                        class="btn btn-link btn-primary me-2" data-bs-toggle="tooltip"
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
    $(document).ready(function() {
        $("#basic-datatables").DataTable();
    });
</script>
