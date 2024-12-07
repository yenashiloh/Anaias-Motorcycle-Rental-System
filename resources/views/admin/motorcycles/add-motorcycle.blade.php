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
                <h3 class="fw-bold mb-3">Add Motorcycle</h3>
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
                        <a href="{{ route('admin.motorcycles.add-motorcycle') }}">Add Motorcycle</a>
                    </li>
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">

                    <!-- Basic Information Card -->
                    {{-- @if ($errors->any())
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
                    @endif --}}

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
                                            <label for="name">Name<span style="color: red"> *</span></label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                name="name" required value="{{ old('name') }}"
                                                placeholder="Enter Name" />
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="brand">Brand<span style="color: red"> *</span></label>
                                            <input type="text"
                                                class="form-control @error('brand') is-invalid @enderror" id="brand"
                                                name="brand" required value="{{ old('brand') }}"
                                                placeholder="Enter Brand" />
                                            @error('brand')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                            <label for="model">Model<span style="color: red"> *</span></label>
                                            <input type="text"
                                                class="form-control @error('model') is-invalid @enderror" id="model"
                                                name="model" required value="{{ old('model') }}"
                                                placeholder="Enter Model" />
                                            @error('model')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="cc">CC<span style="color: red"> *</span></label>
                                            <input type="number" class="form-control @error('cc') is-invalid @enderror"
                                                id="cc" name="cc" required value="{{ old('cc') }}"
                                                placeholder="Enter CC" />
                                            @error('cc')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="year">Year<span style="color: red"> *</span></label>
                                            <select class="form-select form-control @error('year') is-invalid @enderror"
                                                id="year" name="year" required>
                                                @php
                                                    $startYear = 2000;
                                                    $endYear = date('Y');
                                                @endphp
                                                @for ($i = $endYear; $i >= $startYear; $i--)
                                                    <option value="{{ $i }}"
                                                        {{ old('year') == $i ? 'selected' : '' }}>{{ $i }}
                                                    </option>
                                                @endfor
                                            </select>
                                            @error('year')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="gas">Gas<span style="color: red"> *</span></label>
                                            <input type="text"
                                                class="form-control @error('gas') is-invalid @enderror" id="gas"
                                                name="gas" required value="{{ old('gas') }}"
                                                placeholder="Enter Gas Type" />
                                            @error('gas')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                            <label for="color">Color<span style="color: red"> *</span></label>
                                            <input type="text"
                                                class="form-control @error('color') is-invalid @enderror"
                                                id="color" name="color" required value="{{ old('color') }}"
                                                placeholder="Enter Color" />
                                            @error('color')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="body_number">Body Number</label>
                                            <input type="text"
                                                class="form-control @error('body_number') is-invalid @enderror"
                                                id="body_number" name="body_number" required
                                                value="{{ old('body_number') }}" placeholder="Enter Body Number" />
                                            @error('body_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="plate_number">Plate Number</label>
                                            <input type="text"
                                                class="form-control @error('plate_number') is-invalid @enderror"
                                                id="plate_number" name="plate_number" required
                                                value="{{ old('plate_number') }}" placeholder="Enter Plate Number" />
                                            @error('plate_number')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="price">Price<span style="color: red"> *</span></label>
                                            <input type="number"
                                                class="form-control @error('price') is-invalid @enderror"
                                                id="price" name="price" required value="{{ old('price') }}"
                                                placeholder="Enter Price" />
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
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
                                                <label for="image-description">Description<span style="color: red"> *</span></label>
                                                <textarea class="form-control @error('description') is-invalid @enderror" id="image-description" rows="10"
                                                    placeholder="Enter description here" name="description" required>{{ old('description') }}</textarea>
                                                @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="image-upload">Upload Image<span style="color: red"> *</span></label>
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
                                                    <div id="image-preview-container" class="d-flex flex-wrap">
                                                        @if (old('image_data'))
                                                            @foreach (old('image_data') as $index => $imageData)
                                                                <div class="image-preview">
                                                                    <img src="{{ $imageData }}" alt="Preview">
                                                                    <input type="hidden" name="image_data[]"
                                                                        value="{{ $imageData }}">
                                                                    <div class="image-actions">
                                                                        <button type="button"
                                                                            class="btn btn-image-action mb-1"
                                                                            style="background-color:white; color:black;"
                                                                            onclick="replaceImage(this)">Replace</button>
                                                                        <button type="button"
                                                                            class="btn btn-image-action"
                                                                            style="background-color:white; color:black;"
                                                                            onclick="removeImage(this)">Remove</button>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        @endif
                                                    </div>
                                                    @error('images')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                    @error('images.*')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
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
                <button type="submit" class="btn btn-success">Submit</button>
                <button type="button" class="btn btn-danger">Cancel</button>
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
    document.addEventListener('DOMContentLoaded', function() {
        const uploadInput = document.getElementById('image-upload');
        const previewContainer = document.getElementById('image-preview-container');
        const form = uploadInput.closest('form'); 

        function handleImageUpload(event) {
            const files = event.target.files;

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    addImagePreview(e.target.result);
                }

                reader.readAsDataURL(file);
            }
            uploadInput.value = ''; 
        }

        function addImagePreview(imageData) {
            const previewDiv = document.createElement('div');
            previewDiv.className = 'image-preview';
            previewDiv.innerHTML = `
                <img src="${imageData}" alt="Preview">
                <input type="hidden" name="image_data[]" value="${imageData}">
                <div class="image-actions">
                    <button type="button" class="btn btn-image-action mb-1" style="background-color:white; color:black;" onclick="replaceImage(this)">Replace</button>
                    <button type="button" class="btn btn-image-action" style="background-color:white; color:black;" onclick="removeImage(this)">Remove</button>
                </div>
            `;
            previewContainer.appendChild(previewDiv);
        }

        window.replaceImage = function(button) {
            const input = document.createElement('input');
            input.type = 'file';
            input.accept = 'image/*';
            input.onchange = function(event) {
                const file = event.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const previewDiv = button.closest('.image-preview');
                        const img = previewDiv.querySelector('img');
                        const hiddenInput = previewDiv.querySelector('input[type="hidden"]');
                        img.src = e.target.result;
                        hiddenInput.value = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            };
            input.click();
        }

        window.removeImage = function(button) {
            const previewDiv = button.closest('.image-preview');
            previewDiv.remove();
        }

        uploadInput.addEventListener('change', handleImageUpload);

        document.addEventListener('click', function(event) {
            if (event.target.matches('.btn-image-action')) {
                event.preventDefault();
            }
        });

        form.addEventListener('submit', function(event) {
            const submitButton = event.target.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true; 
                submitButton.innerHTML = 'Submitting...'; 
            }
        });
    });
</script>