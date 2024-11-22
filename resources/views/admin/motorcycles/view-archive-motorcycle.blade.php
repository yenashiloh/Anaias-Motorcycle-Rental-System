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
                <h3 class="fw-bold mb-3">View Motorcycle</h3>
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
                        <a href="{{ route('admin.motorcycles.archived-motorcycles') }}">Archived Motorcycles</a>
                    </li>
                    <li class="separator">
                        <i class="icon-arrow-right"></i>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.motorcycles.view-archive-motorcycle', $motorcycle->motor_id) }}"
                            class="fw-bold">View Motorcycle</a>
                    </li>
                </ul>
            </div>
            <section class="py-5">
                <div class="container">
                    <div class="row gx-5">
                        <div class="col-lg-12">
                            <div class="card border rounded-4 mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <aside class="col-lg-6">
                                            <div class="d-flex justify-content-center" id="main-image-container">
                                                @if ($motorcycle->images)
                                                    @php
                                                        $images = json_decode($motorcycle->images);
                                                    @endphp
                                                    <img id="main-image"
                                                        style="max-width: 100%; max-height: 100vh; margin: auto;"
                                                        class="rounded-4 fit"
                                                        src="{{ asset('storage/' . $images[0]) }}" />
                                                @endif
                                            </div>

                                            <div class="d-flex justify-content-center mb-3">
                                                @if ($motorcycle->images)
                                                    @php
                                                        $images = json_decode($motorcycle->images);
                                                    @endphp
                                                    @foreach ($images as $image)
                                                        <a href="javascript:void(0);" class="border mx-1 rounded-2"
                                                            onclick="showImage('{{ asset('storage/' . $image) }}')"
                                                            class="item-thumb">
                                                            <img width="60" height="60" class="rounded-2"
                                                                src="{{ asset('storage/' . $image) }}"
                                                                style="width: 60px; height: 60px; object-fit: cover;" />
                                                        </a>
                                                    @endforeach
                                                @endif
                                            </div>
                                        </aside>

                                        <div class="col-lg-1 d-flex align-items-center justify-content-center">
                                            <div class="border-start"
                                                style="height: 100%; border-left: 1px solid #ddd;"></div>
                                        </div>

                                        <main class="col-lg-5">
                                            <h3 class="title text-dark fw-bold">
                                                {{ $motorcycle->name }}
                                            </h3>

                                            <div class="mb-3">
                                                <span class="h5">₱{{ number_format($motorcycle->price, 2) }}</span>
                                                <span class="text-muted">/per day</span>
                                            </div>

                                            <p>
                                                {{ $motorcycle->description }}
                                            </p>

                                            <div class="row">
                                                <dt class="col-6">Brand:</dt>
                                                <dd class="col-6">{{ $motorcycle->brand }}</dd>

                                                <dt class="col-6">Model:</dt>
                                                <dd class="col-6">{{ $motorcycle->model }}</dd>

                                                <dt class="col-6">Engine Capacity (CC):</dt>
                                                <dd class="col-6">{{ $motorcycle->cc }}</dd>

                                                <dt class="col-6">Year:</dt>
                                                <dd class="col-6">{{ $motorcycle->year }}</dd>

                                                <dt class="col-6">Gas:</dt>
                                                <dd class="col-6">{{ $motorcycle->gas }}</dd>

                                                <dt class="col-6">Color:</dt>
                                                <dd class="col-6">{{ $motorcycle->color }}</dd>

                                                <dt class="col-6">Body Number:</dt>
                                                <dd class="col-6">{{ $motorcycle->body_number }}</dd>

                                                <dt class="col-6">Plate Number:</dt>
                                                <dd class="col-6">{{ $motorcycle->plate_number }}</dd>
                                            </div>
                                        </main>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    @include('partials.admin-footer')
    <script>
        function showImage(imageUrl) {
            const mainImage = document.getElementById('main-image');
            mainImage.src = imageUrl;
        }

        document.addEventListener('DOMContentLoaded', function() {

            if ($.fn.DataTable) {
                $("#basic-datatables").DataTable();
            }
        })
    </script>

</body>

</html>
