<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Manage Motorcycles</title>
    @include('partials.admin-link')
    <link rel="stylesheet" href="../../admin-assets-final/css/edit.css" />
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="page-header">
                <h3 class="fw-bold mb-3">Edit Motorcycle</h3>
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
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.motorcycles.add-motorcycle') }}">Edit Motorcycle</a>
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

                    <form action="{{ route('admin.motorcycles.update', $motorcycle->motor_id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                required placeholder="Enter Name" value="{{ $motorcycle->name }}" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand">Brand</label>
                                            <input type="text" class="form-control" id="brand" name="brand"
                                                required placeholder="Enter Brand" value="{{ $motorcycle->brand }}" />
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
                                                value="{{ $motorcycle->model }}" required placeholder="Enter Model" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cc">CC</label>
                                            <input type="number" class="form-control" id="cc" name="cc"
                                                value="{{ $motorcycle->cc }}" required placeholder="Enter CC" />
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
                                                    <option value="{{ $i }}"
                                                        {{ isset($motorcycle) && $motorcycle->year == $i ? 'selected' : '' }}>
                                                        {{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gas">Gas</label>
                                            <input type="text" class="form-control" id="gas" name="gas"
                                                value="{{ $motorcycle->gas }}" required
                                                placeholder="Enter Gas Type" />
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
                                                value="{{ $motorcycle->color }}" required
                                                placeholder="Enter Color" />
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="body_number">Body Number</label>
                                            <input type="text" class="form-control" id="body_number"
                                                value="{{ $motorcycle->body_number }}" name="body_number" required
                                                placeholder="Enter Body Number" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="plate_number">Plate Number</label>
                                            <input type="text" class="form-control" id="plate_number"
                                                value="{{ $motorcycle->plate_number }}" name="plate_number" required
                                                placeholder="Enter Plate Number" disabled/>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Price</label>
                                            <input type="number" class="form-control" id="price" name="price"
                                                value="{{ $motorcycle->price }}" required
                                                placeholder="Enter Price" />
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
                                                <textarea class="form-control" id="image-description" rows="10" name="description" required>{{ $motorcycle->description }}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image-upload">Upload Image <span
                                                        class="text-danger">*</span></label>
                                                <div class="image-upload-container">
                                                    <div id="image-upload-area" class="mb-3">
                                                        <input type="file" id="image-upload" accept="image/*"
                                                            name="images[]" multiple style="display: none;">
                                                        <label for="image-upload" class="upload-label">
                                                            <div class="upload-icon">
                                                                <i class="fas fa-cloud-upload-alt"></i>
                                                            </div>
                                                            <div class="upload-text">Click to upload or drag and drop
                                                            </div>

                                                        </label>
                                                    </div>
                                                </div>
                                                <div id="image-preview-container" class="d-flex flex-wrap">
                                                    @if ($motorcycle->images)
                                                        @php
                                                            $images = json_decode($motorcycle->images);
                                                        @endphp
                                                        @foreach ($images as $index => $image)
                                                            <div class="image-preview"
                                                                data-index="{{ $index }}">
                                                                <img src="{{ asset('storage/' . $image) }}"
                                                                    alt="Preview"
                                                                    style="max-width: 100px; margin: 5px;">
                                                                <div class="image-actions">
                                                                    <button type="button"
                                                                        class="btn btn-image-action mb-1"
                                                                        style="background-color:white; color:black;"
                                                                        onclick="replaceImage(this, {{ $index }})">Replace</button>
                                                                    <button type="button"
                                                                        class="btn btn-image-action"
                                                                        style="background-color:white; color:black;"
                                                                        onclick="removeImage(this, {{ $index }})">Remove</button>
                                                                </div>
                                                                <input type="hidden" name="existing_images[]"
                                                                    value="{{ $image }}">
                                                            </div>
                                                        @endforeach
                                                    @endif
                                                </div>
                                                @error('images')
                                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                                @enderror
                                                @error('image_processing')
                                                    @foreach ($errors->get('image_processing') as $error)
                                                        <div class="alert alert-danger mt-2">{{ $error }}</div>
                                                    @endforeach
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Submit/Cancel Buttons -->
                        <div class="card-action mt-4">
                            <button class="btn btn-success">Update</button>
                        </div>
                </div>
                </form>
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
        const maxFileSize = 2 * 1024 * 1024; // 2MB
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];

        // clear previous error messages
        clearErrorMessages();

        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            // validate file type
            if (!allowedTypes.includes(file.type)) {
                showError(
                    `File "${file.name}" is not a valid image type. Allowed types are: JPEG, PNG, JPG, GIF, WEBP`);
                continue;
            }

            // validate file size
            if (file.size > maxFileSize) {
                showError(`File "${file.name}" is too large. Maximum file size is 2MB`);
                continue;
            }

            const reader = new FileReader();

            reader.onload = function(e) {
                const previewDiv = document.createElement('div');
                previewDiv.className = 'image-preview';
                previewDiv.innerHTML = `
                <img src="${e.target.result}" alt="Preview" style="max-width: 100px; margin: 5px;">
                <div class="image-actions">
                    <button type="button" class="btn btn-image-action mb-1" style="background-color:white; color:black;" onclick="replaceImage(this)">Replace</button>
                    <button type="button" class="btn btn-image-action" style="background-color:white; color:black;" onclick="removeImage(this)">Remove</button>
                </div>
            `;

                const fileInput = document.createElement('input');
                fileInput.type = 'file';
                fileInput.name = 'new_images[]';
                fileInput.style.display = 'none';

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(file);
                fileInput.files = dataTransfer.files;

                previewDiv.appendChild(fileInput);
                previewContainer.appendChild(previewDiv);
            }

            reader.readAsDataURL(file);
        }

        validateImageCount();
    }

    document.addEventListener('DOMContentLoaded', function() {
        const imageUpload = document.getElementById('image-upload');
        if (imageUpload) {
            imageUpload.addEventListener('change', handleImageUpload);
        }

        // add drag and drop functionality
        const uploadArea = document.getElementById('image-upload-area');
        if (uploadArea) {
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');
                const files = e.dataTransfer.files;
                const input = document.getElementById('image-upload');

                // update the input's files
                const dataTransfer = new DataTransfer();
                Array.from(files).forEach(file => dataTransfer.items.add(file));
                input.files = dataTransfer.files;

                // trigger the handleImageUpload function
                handleImageUpload({
                    target: {
                        files: files
                    }
                });
            });
        }

        // initialize validation on page load
        validateImageCount();
    });

    function replaceImage(button, index) {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';

        input.onchange = function(event) {
            const file = event.target.files[0];
            if (file) {
                // validate file size and type
                if (file.size > 2 * 1024 * 1024) {
                    showError('Replacement image is too large. Maximum file size is 2MB');
                    return;
                }

                const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif', 'image/webp'];
                if (!allowedTypes.includes(file.type)) {
                    showError('Invalid file type. Please upload a JPEG, PNG, JPG, GIF, or WEBP image');
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    const previewDiv = button.closest('.image-preview');
                    const img = previewDiv.querySelector('img');
                    img.src = e.target.result;

                    let fileInput = previewDiv.querySelector('input[type="file"]');
                    if (!fileInput) {
                        fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.style.display = 'none';
                        previewDiv.appendChild(fileInput);
                    }
                    fileInput.name = `replaced_images[${index}]`;

                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(file);
                    fileInput.files = dataTransfer.files;

                    previewDiv.dataset.modified = 'true';
                    previewDiv.dataset.index = index;
                }
                reader.readAsDataURL(file);
            }
        };
        input.click();
    }

    function removeImage(button, index) {
        const previewDiv = button.closest('.image-preview');
        let hiddenInput = previewDiv.querySelector('input[name="removed_images[]"]');

        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'removed_images[]';
            previewDiv.appendChild(hiddenInput);
        }

        hiddenInput.value = index;
        previewDiv.style.display = 'none';
        previewDiv.classList.add('removed-image');

        validateImageCount();
    }

    function validateImageCount() {
        const visibleImages = document.querySelectorAll('.image-preview:not(.removed-image)').length;
        const errorContainer = document.getElementById('image-error-container');

        if (visibleImages === 0) {
            if (!errorContainer) {
                const container = document.createElement('div');
                container.id = 'image-error-container';
                container.className = 'alert alert-danger mt-2';
                container.textContent = 'At least one image is required for the motorcycle.';
                document.getElementById('image-preview-container').parentNode.appendChild(container);
            }
            return false;
        } else {
            if (errorContainer) {
                errorContainer.remove();
            }
            return true;
        }
    }

    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'alert alert-danger mt-2 image-error';
        errorDiv.textContent = message;
        document.getElementById('image-preview-container').parentNode.appendChild(errorDiv);
    }

    function clearErrorMessages() {
        document.querySelectorAll('.image-error').forEach(error => error.remove());
    }

    // form submission validation
    document.querySelector('form').addEventListener('submit', function(event) {
        if (!validateImageCount()) {
            event.preventDefault();
            return;
        }

        document.querySelectorAll('.removed-image').forEach(div => {
            div.style.display = 'none';
        });
    });

    // initialize validation on page load
    document.addEventListener('DOMContentLoaded', function() {
        validateImageCount();
    });
</script>
