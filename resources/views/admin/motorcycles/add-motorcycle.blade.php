<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Manage Motorcycles</title>
    @include('partials.admin-link')
</head>
<style>
    .upload-label {
        border: 2px dashed #ccc;
        border-radius: 5px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        background-color: #f8f9fa;
        display: block;
        margin-bottom: 15px;
    }

    .upload-icon {
        font-size: 28px;
        color: #6c757d;
    }

    .upload-text {
        margin-top: 10px;
        color: #6c757d;
    }

    .image-preview {
        position: relative;
        width: 100px;
        height: 100px;
        margin: 5px;
        overflow: hidden;
        border-radius: 10px;
        /* Adjust this value for more or less curvature */
        transition: background-color 0.3s;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 10px;
    }

    .image-preview:hover::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        z-index: 1;
    }

    .image-preview:hover .image-actions {
        display: block;
        /* Show action buttons on hover */
    }

    .image-actions {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 2;
        display: none;
    }


    .image-preview:hover .image-actions {
        display: block;
    }

    .btn-image-action {
        padding: 2px 5px;
        font-size: 12px;
        margin-left: 2px;
    }
</style>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Add Motorcycle</h3>
                <ul class="breadcrumbs mb-3">
                    <li class="nav-home">
                        <a href="{{route ('admin.admin-dashboard')}}">
                            <i class="icon-home"></i>
                        </a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{route ('admin.motorcycles.manage-motorcycles')}}">Manage Motorcycles</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{route ('admin.motorcycles.add-motorcycle')}}">Add Motorcycle</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <!-- Basic Information Card -->

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
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="color:green;">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('motorcycles.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Basic Information</div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control" id="name" name="name"
                                                required placeholder="Enter Name" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand">Brand</label>
                                            <input type="text" class="form-control" id="brand" name="brand"
                                                required placeholder="Enter Brand" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Vehicle Specifications Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Vehicle Specifications</div>
                            </div>
                            <div class="card-body">
                                <div class="row mb-4">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="model">Model</label>
                                            <input type="text" class="form-control" id="model" name="model"
                                                required placeholder="Enter Model" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cc">CC</label>
                                            <input type="number" class="form-control" id="cc" name="cc"
                                                required placeholder="Enter CC" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year">Year</label>
                                            <select class="form-select form-control" id="year" name="year"
                                                required>
                                                @php
                                                    $startYear = 2000;
                                                    $endYear = date('Y');
                                                @endphp
                                                @for ($i = $endYear; $i >= $startYear; $i--)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gas">Gas</label>
                                            <input type="text" class="form-control" id="gas" name="gas"
                                                required placeholder="Enter Gas Type" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Details Card -->
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="card-title">Additional Details</div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="color">Color</label>
                                            <input type="text" class="form-control" id="color" name="color"
                                                required placeholder="Enter Color" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="body_number">Body Number</label>
                                            <input type="text" class="form-control" id="body_number"
                                                name="body_number" required placeholder="Enter Body Number" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="plate_number">Plate Number</label>
                                            <input type="text" class="form-control" id="plate_number"
                                                name="plate_number" required placeholder="Enter Plate Number" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price"
                                                required placeholder="Enter Price" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <div class="card-title">Motorcycle Images</div>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image-description">Description</label>
                                                <textarea class="form-control" id="image-description" rows="10" placeholder="Enter description here"
                                                    name="description" required></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image-upload">Upload Image</label>
                                                <div class="image-upload-container">
                                                    <div id="image-upload-area" class="mb-3">
                                                        <input type="file" id="image-upload" accept="image/*"
                                                            name="images[]" required multiple style="display: none;">
                                                        <label for="image-upload" class="upload-label">
                                                            <div class="upload-icon">
                                                                <i class="fas fa-cloud-upload-alt"></i>
                                                            </div>
                                                            <div class="upload-text">Click to upload or drag and drop
                                                            </div>
                                                        </label>
                                                    </div>
                                                    <div id="image-preview-container" class="d-flex flex-wrap">
                                                        <!-- Preview images will be added here dynamically -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit/Cancel Buttons -->

                        <div class="card-action mt-4">
                            <button class="btn btn-success">Submit</button>
                            <button class="btn btn-danger">Cancel</button>

                        </div>

                </div>


                </form>
            </div>
        </div>
    </div>

    </div>
    </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    @include('partials.admin-footer')
</body>

</html>
<script>
    function handleImageUpload(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('image-preview-container');

        for (let i = 0; i < files.length; i++) {
            const file = files[i];
            const reader = new FileReader();

            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
                previewDiv.innerHTML = `
        <img src="${e.target.result}" alt="Preview">
        <div class="image-actions">
          <button type="button" class="btn btn-image-action mb-1" style="background-color:white; color:black;" onclick="replaceImage(this)">Replace</button>
          <button type="button" class="btn btn-image-action" style="background-color:white; color:black;" onclick="removeImage(this)">Remove</button>
        </div>
      `;
                previewContainer.appendChild(previewDiv);
            }

            reader.readAsDataURL(file);
        }
    }

    function replaceImage(button) {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.onchange = function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = button.parentElement.parentElement.querySelector('img');
                    img.src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        };
        input.click();
    }

    function removeImage(button) {
        const previewDiv = button.parentElement.parentElement;
        previewDiv.remove();
    }

    document.getElementById('image-upload').addEventListener('change', handleImageUpload);

    // Prevent form submission on button clicks
    document.addEventListener('click', function(event) {
        if (event.target.matches('.btn-image-action')) {
            event.preventDefault();
        }
    });
</script>
