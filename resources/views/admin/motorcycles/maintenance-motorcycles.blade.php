<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Motorcycle Maintenance</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Motorcycles</h3>
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
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}">Motorcycle Maintenance</a>
                    </li>

                </ul>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color:red;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>

                    <ul style="list-style-type: none; padding-left: 0;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert" style="color:green;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            @endif

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">List of Motorcycle Maintenance</h4>
                            <a href="{{ route('export.maintenance') }}" class="btn btn-secondary btn-round ms-auto">
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
                                        <th>Name</th>
                                        <th>Plate Number</th>
                                        <th>Engine</th>
                                        <th>Break Inspection</th>
                                        <th>Tire Condition</th>
                                        <th>Change Oil</th>
                                        <th>Lights and Signals</th>
                                        <th>Overall Inspection</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($motorcycles as $motorcycle)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $motorcycle->name }}</td>
                                            <td>{{ $motorcycle->plate_number }}</td>
                                            <td class="text-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="maintenance-checkbox"
                                                        data-field="engine_status"
                                                        data-motor-id="{{ $motorcycle->motor_id }}"
                                                        {{ $motorcycle->engine_status ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="maintenance-checkbox"
                                                        data-field="brake_status"
                                                        data-motor-id="{{ $motorcycle->motor_id }}"
                                                        {{ $motorcycle->brake_status ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="maintenance-checkbox"
                                                        data-field="tire_condition"
                                                        data-motor-id="{{ $motorcycle->motor_id }}"
                                                        {{ $motorcycle->tire_condition ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="maintenance-checkbox"
                                                        data-field="oil_status"
                                                        data-motor-id="{{ $motorcycle->motor_id }}"
                                                        {{ $motorcycle->oil_status ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="maintenance-checkbox"
                                                        data-field="lights_status"
                                                        data-motor-id="{{ $motorcycle->motor_id }}"
                                                        {{ $motorcycle->lights_status ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>
                                            <td class="text-center">
                                                <label class="custom-checkbox">
                                                    <input type="checkbox" class="maintenance-checkbox"
                                                        data-field="overall_condition"
                                                        data-motor-id="{{ $motorcycle->motor_id }}"
                                                        {{ $motorcycle->overall_condition ? 'checked' : '' }}>
                                                    <span class="checkmark"></span>
                                                </label>
                                            </td>

                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-link" type="button"
                                                        id="dropdownMenuButton{{ $motorcycle->motor_id }}"
                                                        data-bs-toggle="dropdown" aria-expanded="false">
                                                        @if ($motorcycle->status === 'Available')
                                                            <span class="badge bg-success">
                                                                Available <i class="fas fa-chevron-down"></i>
                                                            </span>
                                                        @elseif ($motorcycle->status === 'Not Available')
                                                            <span class="badge bg-danger">
                                                                Not Available <i class="fas fa-chevron-down"></i>
                                                            </span>
                                                        @elseif ($motorcycle->status === 'Maintenance')
                                                            <span class="badge bg-warning">
                                                                Maintenance <i class="fas fa-chevron-down"></i>
                                                            </span>
                                                        @endif
                                                    </button>
                                                    <ul class="dropdown-menu"
                                                        aria-labelledby="dropdownMenuButton{{ $motorcycle->motor_id }}">
                                                        @if ($motorcycle->status === 'Available')
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status"
                                                                        value="Not Available">
                                                                    <button type="submit" class="dropdown-item">Set
                                                                        to Not Available</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status"
                                                                        value="Maintenance">
                                                                    <button type="submit" class="dropdown-item">Set
                                                                        to Maintenance</button>
                                                                </form>
                                                            </li>
                                                        @elseif ($motorcycle->status === 'Not Available')
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status"
                                                                        value="Available">
                                                                    <button type="submit" class="dropdown-item">Set
                                                                        to Available</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status"
                                                                        value="Maintenance">
                                                                    <button type="submit" class="dropdown-item">Set
                                                                        to Maintenance</button>
                                                                </form>
                                                            </li>
                                                        @elseif ($motorcycle->status === 'Maintenance')
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status"
                                                                        value="Available">
                                                                    <button type="submit" class="dropdown-item">Set
                                                                        to Available</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <input type="hidden" name="status"
                                                                        value="Not Available">
                                                                    <button type="submit" class="dropdown-item">Set
                                                                        to Not Available</button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
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

    $(document).ready(function() {
        $('.maintenance-checkbox').on('change', function() {
            var field = $(this).data('field');
            var motorId = $(this).data('motor-id');
            var status = $(this).prop('checked') ? 1 : 0;
            var data = {
                _token: $('meta[name="csrf-token"]').attr('content'),
                field: field,
                [field]: status
            };

            $.ajax({
                url: '/admin/motorcycles/update-maintenance/' + motorId,
                method: 'POST',
                data: data,
                success: function(response) {
                    if (response.success) {
                        toastr.success('Maintenance status updated successfully');
                    }
                },
                error: function(xhr) {
                    toastr.error('Error updating maintenance status');
                    $(this).prop('checked', !status);
                }
            });
        });
    });
</script>
