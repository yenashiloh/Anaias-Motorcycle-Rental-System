<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Manage Motorcycles</title>
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
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}">Manage Motorcycles</a>
                    </li>

                </ul>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert" style="color:red;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <ul>
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
                        <div class="d-flex justify-content-between w-100">
                            <h4 class="card-title">List of Motorcycles</h4>
                            <div>
                                <a href="{{ route('admin.motorcycles.add-motorcycle') }}" class="btn btn-primary btn-round me-2">
                                    <i class="fa fa-plus"></i>
                                    Add Motorcycle
                                </a>
                                <a href="{{ route('export.motorcycle') }}" class="btn btn-secondary btn-round">
                                    <i class="fas fa-file-export"></i>
                                    Export 
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatables" class="display table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Plate Number</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($motorcycles as $motorcycle)
                                        <tr id="motorcycle-{{ $motorcycle->motor_id }}">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $motorcycle->name }}</td>
                                            <td>{{ $motorcycle->brand }}</td>
                                            <td>{{ $motorcycle->model }}</td>
                                            <td>{{ $motorcycle->plate_number }}</td>
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
                                                                    <button type="submit" class="dropdown-item">Set to
                                                                        Not Available</button>
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
                                                                    <button type="submit" class="dropdown-item">Set to
                                                                        Available</button>
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
                                                                    <button type="submit" class="dropdown-item">Set to
                                                                        Available</button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.motorcycles.update-status', $motorcycle->motor_id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                <input type="hidden" name="status"
                                                                        value="Not Available">
                                                                    <button type="submit" class="dropdown-item">Set to
                                                                        Not Available</button>
                                                                </form>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="form-button-action d-flex justify-content-center">
                                                    <a href="{{ route('admin.motorcycles.view-motorcycle', $motorcycle->motor_id) }}"
                                                        class="btn btn-link btn-primary" data-bs-toggle="tooltip"
                                                        title="View Motorcycle" data-original-title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                            
                                                    <button type="button" data-bs-toggle="tooltip"
                                                        title="Edit Motorcycle" class="btn btn-link btn-warning"
                                                        data-original-title="Edit Motorcycle"
                                                        onclick="window.location.href='{{ route('admin.motorcycles.edit-motorcycle', $motorcycle->motor_id) }}'">
                                                        <i class="fa fa-edit"></i>
                                                    </button>
                                            
                                                    <button type="button"
                                                    class="btn btn-link btn-danger archive-motorcycle"
                                                    title="Archive" 
                                                    data-bs-toggle="tooltip"
                                                    data-id="{{ $motorcycle->motor_id }}"
                                                    data-status="{{ $motorcycle->status }}">
                                                    <i class="fa fa-archive"></i>
                                                </button>
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

    <!-- Archive Reason Modal -->
    <div class="modal fade" id="archiveReasonModal" tabindex="-1" role="dialog"
        aria-labelledby="archiveReasonModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="archiveReasonModalLabel">Archive Motorcycle</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="archiveForm">
                        <div class="form-group">
                            <label for="archiveReason">Reason for Archiving</label>
                            <textarea class="form-control" id="archiveReason" name="reason" rows="6" required></textarea>
                        </div>
                        <input type="hidden" id="archiveMotorId" name="motor_id">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-dark" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-secondary" id="confirmArchive">Submit</button>
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
    const dataTable = $("#basic-datatables").DataTable();

    let motorId;
    let motorStatus;

    $(document).on('click', '.archive-motorcycle', function() {
        motorId = $(this).data('id');
        motorStatus = $(this).data('status'); 

        if (motorStatus !== 'Not Available') {
            Swal.fire({
                icon: 'error',
                title: 'Cannot Archive',
                text: 'Only motorcycles with "Not Available" status can be archived.',
                confirmButtonText: 'OK'
            });
            return;
        }

        $('#archiveMotorId').val(motorId);
        $('#archiveReasonModal').modal('show');
    });

    $('#confirmArchive').on('click', function() {
        const reason = $('#archiveReason').val().trim();
        if (!reason) {
            Swal.fire('Error', 'Please provide a reason for archiving.', 'error');
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/admin/motorcycles/archive/${motorId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    reason: reason
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire(
                        'Archived!',
                        'The motorcycle has been archived successfully.',
                        'success'
                    );

                    $('#archiveReasonModal').modal('hide');
                    const row = $(`#motorcycle-${motorId}`).closest('tr');
                    dataTable.row(row).remove().draw();

                } else {
                    Swal.fire(
                        'Error!',
                        data.message || 'Failed to archive the motorcycle.',
                        'error'
                    );
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire(
                    'Error!',
                    'An error occurred during the archive process.',
                    'error'
                );
            });
    });
});
</script>
