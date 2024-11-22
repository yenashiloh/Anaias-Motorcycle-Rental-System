<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Archived Motorcycles</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Archived Motorcycles</h3>
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
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}">Archived Motorcycles</a>
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
                                        <th>Archive Reason</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($motorcycles as $motorcycle)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $motorcycle->name }}</td>
                                            <td>{{ $motorcycle->brand }}</td>
                                            <td>{{ $motorcycle->model }}</td>
                                            <td>{{ $motorcycle->plate_number }}</td>
                                            <td>{{ $motorcycle->archive_reason }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.motorcycles.view-archive-motorcycle', $motorcycle->motor_id) }}"
                                                        class="btn btn-link btn-primary" data-bs-toggle="tooltip"
                                                        title="View Motorcycle" data-original-title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                    <button type="button"
                                                        class="btn btn-link btn-success restore-motorcycle"
                                                        title="Restore" data-bs-toggle="tooltip"
                                                        data-original-title="Restore"
                                                        data-id="{{ $motorcycle->motor_id }}">
                                                        <i class="fas fa-history"></i>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @include('partials.admin-footer')
</body>

</html>
<script>
    $(document).ready(function() {
        const dataTable = $("#basic-datatables").DataTable();

        $(document).on('click', '.restore-motorcycle', function() {
            const motorId = $(this).data('id');
            const row = $(this).closest('tr');

            Swal.fire({
                title: 'Are you sure?',
                text: "Do you want to restore this motorcycle?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, restore it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    const token = document.querySelector('meta[name="csrf-token"]')
                        .getAttribute('content');

                    fetch(`/admin/motorcycles/restore/${motorId}`, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': token,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                _token: token
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Restored!',
                                    'The motorcycle has been restored.',
                                    'success'
                                );

                                dataTable.row(row).remove().draw();
                            } else {
                                throw new Error(data.message || 'Failed to restore');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'There was an error restoring the motorcycle.',
                                'error'
                            );
                        });
                }
            });
        });
    });
</script>
