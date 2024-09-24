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
                        <div class="d-flex align-items-center">
                            <h4 class="card-title">List of Motorcycle</h4>
                            <a href="{{ route('admin.motorcycles.add-motorcycle') }}"
                                class="btn btn-secondary btn-round ms-auto">
                                <i class="fa fa-plus"></i>
                                Add Motorcycle
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
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Body Number</th>
                                        <th>Plate Number</th>
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
                                            <td>{{ $motorcycle->body_number }}</td>
                                            <td>{{ $motorcycle->plate_number }}</td>
                                            <td>
                                                <div class="form-button-action">
                                                    <a href="{{ route('admin.motorcycles.view-motorcycle', $motorcycle->motor_id) }}" 
                                                        class="btn btn-link btn-primary" 
                                                        data-bs-toggle="tooltip" 
                                                        title="View Motorcycle" 
                                                        data-original-title="View">
                                                        <i class="fa fa-eye"></i>
                                                     </a>
                                                     

                                                    <button type="button" data-bs-toggle="tooltip"
                                                        title="Edit Motorcycle" class="btn btn-link btn-primary "
                                                        data-original-title="Edit Motorcycle"
                                                        onclick="window.location.href='{{ route('admin.motorcycles.edit-motorcycle', $motorcycle->motor_id) }}'">
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <button type="button"
                                                        class="btn btn-link btn-danger delete-motorcycle" title="Delete Motorcycle"
                                                        data-bs-toggle="tooltip" data-original-title="Delete Motorcycle"
                                                        data-id="{{ $motorcycle->motor_id }}">
                                                        <i class="fa fa-trash"></i>
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
        $(document).on('click', '.delete-motorcycle', function() {
            var motorId = $(this).data('id');
            var row = $(this).closest('tr'); 

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/motorcycles/${motorId}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector(
                                    'meta[name="csrf-token"]').content,
                                'Accept': 'application/json',
                                'Content-Type': 'application/json'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                Swal.fire(
                                    'Deleted!',
                                    'The motorcycle has been deleted.',
                                    'success'
                                );

                                row.remove(); 

                                // update row numbers
                                updateRowNumbers();
                            } else {
                                Swal.fire(
                                    'Error!',
                                    'There was an error deleting the motorcycle.',
                                    'error'
                                );
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire(
                                'Error!',
                                'There was an error processing your request.',
                                'error'
                            );
                        });
                }
            });
        });

        // update row
        function updateRowNumbers() {
            $('#basic-datatables tbody tr').each(function(index) {
                $(this).find('td:first').text(index + 1); 
            });
        }

    });
</script>
