<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Penalties</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Penalties</h3>
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
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}" class="fw-bold">Penalties</a>
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
                            <h4 class="card-title">Penalties List</h4>
                            <a href="{{ route('export.penalty') }}" class="btn btn-secondary btn-round ms-auto">
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
                                        <th>Driver Name</th>
                                        <th>Email</th>
                                        <th>Penalty Type</th>
                                        <th>Additional Payment</th>
                                        <th>Description</th>
                                        <th>Damage </th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($penalties as $penalty)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $penalty->driver->first_name ?? '' }}
                                                {{ $penalty->driver->last_name ?? '' }}</td>
                                            <td>{{ $penalty->driver->email ?? '' }}</td>
                                            <td>{{ $penalty->penalty_type }}</td>
                                            <td>{{ '₱' . number_format($penalty->additional_payment, 2) }}</td>
                                            <td>{{ $penalty->description }}</td>
                                            <td class="text-center">
                                                @if ($penalty->penalty_image)
                                                    @php
                                                        $images = json_decode($penalty->penalty_image, true);
                                                    @endphp
                                                    @foreach ($images as $image)
                                                        <a href="{{ asset('storage/' . $image) }}" target="_blank">
                                                            <img src="{{ asset('storage/' . $image) }}"
                                                                alt="Penalty Image"
                                                                style="width: 50px; height: 50px; object-fit: cover; margin: 2px;">
                                                        </a>
                                                    @endforeach
                                                @else
                                                    <span>N/A</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                @if (in_array($penalty->status, ['Pending', 'Not Paid']))
                                                    <div class="dropdown">
                                                        <button
                                                            class="badge @if ($penalty->status == 'Pending') badge-warning @elseif ($penalty->status == 'Not Paid') badge-danger @endif"
                                                            type="button" id="statusDropdown" data-bs-toggle="dropdown"
                                                            aria-expanded="false">
                                                            {{ $penalty->status }}
                                                            <i class="fas fa-chevron-down ms-2"></i>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="statusDropdown">
                                                            @if ($penalty->status == 'Pending')
                                                                <li>
                                                                    <form
                                                                        action="{{ route('penalties.updateStatus', $penalty->penalty_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button class="dropdown-item" type="submit"
                                                                            name="status" value="Paid">Paid</button>
                                                                    </form>
                                                                </li>
                                                                <li>
                                                                    <form
                                                                        action="{{ route('penalties.updateStatus', $penalty->penalty_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button class="dropdown-item" type="submit"
                                                                            name="status" value="Not Paid">Not
                                                                            Paid</button>
                                                                        <button class="dropdown-item" type="submit"
                                                                            name="status"
                                                                            value="Banned">Banned</button>
                                                                    </form>
                                                                </li>
                                                            @elseif ($penalty->status == 'Not Paid')
                                                                <li>
                                                                    <form
                                                                        action="{{ route('penalties.updateStatus', $penalty->penalty_id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <button class="dropdown-item" type="submit"
                                                                            name="status" value="Paid">Paid</button>
                                                                        <button class="dropdown-item" type="submit"
                                                                            name="status"
                                                                            value="Banned">Banned</button>
                                                                    </form>
                                                                </li>
                                                            @elseif ($penalty->status == 'Banned')
                                                                <li>
                                                                    <span
                                                                        class="dropdown-item text-danger">Banned</span>
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                @else
                                                    <span
                                                        class="badge @if ($penalty->status == 'Paid') badge-success @else badge-danger @endif">
                                                        {{ $penalty->status }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="form-button-action d-flex justify-content-center">
                                                    <a href="javascript:void(0)" class="btn btn-link btn-primary" 
                                                       data-bs-toggle="modal" 
                                                       data-bs-target="#viewPenaltyModal"
                                                       data-penalty-id="{{ $penalty->penalty_id }}"
                                                       data-driver-name="{{ $penalty->driver->first_name . ' ' . $penalty->driver->last_name }}"
                                                       data-penalty-type="{{ $penalty->penalty_type }}"
                                                       data-description="{{ $penalty->description }}"
                                                       data-additional-payment="{{ '₱' . number_format($penalty->additional_payment, 2) }}"
                                                       data-penalty-image="{{ json_encode($penalty->penalty_image) }}"
                                                       data-status="{{ $penalty->status }}"
                                                       data-payment-method="{{ optional($penalty->penaltyPayment)->payment_method }}"
                                                       data-gcash-name="{{ optional($penalty->penaltyPayment)->gcash_name }}"
                                                       data-gcash-number="{{ optional($penalty->penaltyPayment)->gcash_number }}"
                                                       data-image-receipt="{{ optional($penalty->penaltyPayment)->image_receipt }}">
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

    <!-- View Penalty Modal -->
    <div class="modal fade" id="viewPenaltyModal" tabindex="-1" aria-labelledby="viewPenaltyModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="viewPenaltyModalLabel">Penalty Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Driver:</strong> <span id="driver-name"></span></p>
                    <p><strong>Penalty Type:</strong> <span id="penalty-type"></span></p>
                    <p><strong>Description:</strong> <span id="description"></span></p>
                    <p><strong>Additional Payment:</strong> <span id="additional-payment"></span></p>
                    <p><strong>Status:</strong> <span id="status"></span></p>
                    
                    <hr>
                    <p id="payment-method-container"><strong>Payment Method:</strong> <span id="payment-method"></span></p>

                    <p id="gcash-name-container"><strong>Gcash Name:</strong> <span id="gcash-name"></span></p>

                    <p id="gcash-number-container"><strong>Gcash Number:</strong> <span id="gcash-number"></span></p>

                    <div id="penalty-image-container">
                    </div>

                    <div id="image-receipt-container">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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

    $('#viewPenaltyModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget); 
        var penaltyId = button.data('penalty-id');
        var driverName = button.data('driver-name');
        var penaltyType = button.data('penalty-type');
        var description = button.data('description');
        var additionalPayment = button.data('additional-payment');
        var status = button.data('status');
        var paymentMethod = button.data('payment-method');
        var gcashName = button.data('gcash-name');
        var gcashNumber = button.data('gcash-number');
        var imageReceipt = button.data('image-receipt');

        var modal = $(this);
        modal.find('#driver-name').text(driverName);
        modal.find('#penalty-type').text(penaltyType);
        modal.find('#description').text(description);
        modal.find('#additional-payment').text(additionalPayment);
        modal.find('#status').text(status);

        if (!paymentMethod || paymentMethod === 'Cash') {
            modal.find('#payment-method-container').hide(); 
        } else {
            modal.find('#payment-method-container').show(); 
            modal.find('#payment-method').text(paymentMethod);
        }

        if (!gcashName) {
            modal.find('#gcash-name-container').hide(); 
        } else {
            modal.find('#gcash-name-container').show(); 
            modal.find('#gcash-name').text(gcashName);
        }

        if (!gcashNumber) {
            modal.find('#gcash-number-container').hide(); 
        } else {
            modal.find('#gcash-number-container').show(); 
            modal.find('#gcash-number').text(gcashNumber);
        }

        if (imageReceipt) {
            var imageReceiptContainer = modal.find('#image-receipt-container');
            imageReceiptContainer.html('<a href="/storage/' + imageReceipt + '" target="_blank">View Receipt</a>');
            modal.find('#image-receipt-container').show(); 
        } else {
            modal.find('#image-receipt-container').hide(); 
        }
    });
</script>
