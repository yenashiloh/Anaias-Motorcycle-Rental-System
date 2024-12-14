<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Motorcycles</title>
    @include('partials.customer-link')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <!-- DataTables Responsive CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
</head>
<style>
    .table-responsive {
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    table.dataTable {
        width: 100%;
        margin: 0;
    }

    #example tbody tr:nth-child(even) {
        background-color: #fcfcfc;
    }

    #example tbody tr:hover {
        background-color: #f3f3f3;
        transition: background-color 0.3s ease;
    }
</style>

<body>
    @include('partials.customer-header')
    <div class="container-fluid">
        <div class="container pt-5 pb-3">

            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">History <span class="text-primary">Bookings</span></h1>
                <p class="mb-0">Here you can view all your past bookings and their details.</p>
            </div>

            <div class="card">
                <div class="card-body">
                    @if ($isCustomerLoggedIn)
                        @if ($reservations->isEmpty())
                            <p>No booking history found.</p>
                        @else
                            <div class="table-responsive">
                                <table id="example" class="display" style="width:100%; border-collapse: collapse;">
                                    <thead style="background-color: #1F2E4E; color: white; mt-3">
                                        <tr>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">#</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Booked
                                                Date</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">
                                                Motorcycle</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Driver
                                                Name</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Rental
                                                Start Date</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">
                                                Duration</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Total
                                                Price</th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Booking
                                                Status
                                            </th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Payment
                                                Status
                                            </th>
                                            <th style="padding: 12px; text-align: left; border: 1px solid #ddd;">Actions
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reservations as $index => $reservation)
                                            <tr style="border-bottom: 1px solid #ddd;">
                                                <td>{{ $index + 1 }}</td>
                                                <td style="padding: 10px;">
                                                    {{ \Carbon\Carbon::parse($reservation->created_at)->format('F d, Y, g:i A') }}
                                                </td>
                                                <td style="padding: 10px;">
                                                    @if ($reservation->motorcycle && $reservation->motorcycle->images)
                                                        @php
                                                            $images = json_decode($reservation->motorcycle->images);
                                                            $firstImage = is_array($images) ? $images[0] : null;
                                                        @endphp
                                                        @if ($firstImage)
                                                            <img src="{{ asset('storage/' . $firstImage) }}"
                                                                alt="Motorcycle Image" width="100">
                                                        @else
                                                            No image available
                                                        @endif
                                                    @else
                                                        No image available
                                                    @endif
                                                </td>
                                                <td style="padding: 10px;">
                                                    {{ $reservation->driverInformation ? $reservation->driverInformation->first_name . ' ' . $reservation->driverInformation->last_name : 'No driver assigned' }}
                                                </td>
                                                <td style="padding: 10px;">
                                                    {{ \Carbon\Carbon::parse($reservation->rental_start_date)->format('F d, Y') }}
                                                </td>
                                                <td style="padding: 10px;">
                                                    @php
                                                        $startDate = \Carbon\Carbon::parse(
                                                            $reservation->rental_start_date,
                                                        );
                                                        $endDate = \Carbon\Carbon::parse($reservation->rental_end_date);
                                                        $duration = $startDate->diffInDays($endDate);
                                                    @endphp
                                                    {{ $duration }} {{ $duration === 1 ? 'day' : 'days' }}
                                                </td>
                                                <td style="padding: 10px;">₱{{ number_format($reservation->total, 2) }}
                                                </td>
                                                <td style="padding: 10px;">
                                                    {{ $reservation->status }}
                                                    @if ($reservation->status === 'Cancelled')
                                                        <br>Reason: {{ $reservation->cancel_reason }}
                                                    @endif
                                                </td>
                                                
                                                <td style="padding: 10px;">
                                                    {{ $reservation->payment->status ?? 'N/A' }}
                                                </td>
                                                <td
                                                    style="padding: 10px; display: flex; align-items: center; width: 100px;">
                                                    <a href="{{ route('view.history', ['reservation_id' => $reservation->reservation_id]) }}"
                                                        data-toggle="tooltip" title="View"
                                                        style="margin-right: 10px;">
                                                        <i class="fas fa-eye text-secondary"></i>
                                                    </a>

                                                    <a href="{{ route('reservations.invoice', $reservation['reservation_id']) }}"
                                                        data-toggle="tooltip" title="Download Invoice"
                                                        style="margin-right: 10px;">
                                                        <i class="fas fa-download text-success"></i>
                                                    </a>

                                                    @if ($reservation->status !== 'Cancelled' && $reservation->status !== 'Completed')
                                                        <a href="#" class="cancel-reservation" data-toggle="modal"
                                                            data-target="#cancelReservationModal"
                                                            data-reservation-id="{{ $reservation->reservation_id }}"
                                                            title="Cancel Reservation">
                                                            <i class="fas fa-times text-danger"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    @else
                        <p>Please log in to view your booking history.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="cancelReservationModal" tabindex="-1" role="dialog"
        aria-labelledby="cancelReservationModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cancelReservationModalLabel">Cancel Reservation</h5>
                </div>
                <div class="modal-body">
                    <form id="cancelReservationForm">
                        @csrf
                        <input type="hidden" name="reservation_id" id="cancelReservationId">
                        <div class="form-group">
                            <label for="cancel_reason">Reason for Cancellation</label>
                            <textarea class="form-control" id="cancel_reason" name="cancel_reason" rows="6" required></textarea>
                        </div>
                        <div id="cancelReservationError" class="alert alert-danger" style="display:none;"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="confirmCancelReservation">Confirm Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <br><br>
    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <!-- DataTables Responsive JS -->
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('assets/js/notifications.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true
            });
        });
        $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });

        $(document).ready(function() {
            let reservationIdToCancel = null;

            $('.cancel-reservation').on('click', function() {
                reservationIdToCancel = $(this).data('reservation-id');
                $('#cancelReservationId').val(reservationIdToCancel);
                $('#cancelReservationError').hide();
            });

            $('#confirmCancelReservation').on('click', function() {
                const cancelReason = $('#cancel_reason').val().trim();

                if (!cancelReason) {
                    $('#cancelReservationError')
                        .text('Please provide a reason for cancellation')
                        .show();
                    return;
                }

                $.ajax({
                    url: `/reservations/cancel/${reservationIdToCancel}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        cancel_reason: cancelReason
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON.message || 'An error occurred';
                        $('#cancelReservationError')
                            .text(errorMessage)
                            .show();
                    }
                });
            });
        });
    </script>
</body>

</html>
