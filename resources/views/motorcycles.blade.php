<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <title>Motorcycles</title>
    @include('partials.customer-link')
    <link href="{{ asset('assets/css/motorcycles.css') }}" rel="stylesheet">
</head>

<body>
    @include('partials.customer-header')

    <div class="container-fluid">
        <div class="container pt-5 pb-3">
            <div class="text-center mx-auto pb-5" style="max-width: 800px;">
                <h1 class="display-5 text-capitalize mb-3">Motorcycle <span class="text-primary">Categories</span></h1>
                <p class="mb-0">Choose your motorcycle from the categories below</p>
            </div>

            <!-- Search and Filter Section -->
            <div class="row mb-4">
                <div class="col-md-4 mb-2">
                    <input type="text" id="searchInput" class="form-control" placeholder="Search Motorcycles..."
                        value="{{ old('searchQuery', $searchQuery) }}">
                </div>
                <div class="col-md-4 mb-2">
                    <select class="form-select" id="priceFilter">
                        <option value="">Select Price Range</option>
                        <option value="100-500">₱100 - ₱500</option>
                        <option value="500-1000">₱500 - ₱1000</option>
                        <option value="1000-1500">₱1,000 - ₱1,500</option>
                        <option value="1500-2000">₱1,500 - ₱2,000</option>
                        <option value="2000-2500">₱2,000 - ₱2,500</option>
                        <option value="2500-3000">₱2,500 - ₱3,000</option>
                    </select>
                </div>

                <div class="col-md-4 mb-2">
                    <select class="form-select" id="statusFilter">
                        <option value="">All Motorcycle Status</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                        <option value="Maintenance">Maintenance</option>
                    </select>
                </div>

            </div>

            <div class="row" id="motorcycleList">
                @include('motorcycle.motorcycle_list', ['motorcycles' => $motorcycles])
            </div>
        </div>
    </div>

    @include('partials.customer-footer')
</body>

</html>
<script>
    document.getElementById('searchInput').addEventListener('input', fetchMotorcycles);
    document.getElementById('priceFilter').addEventListener('change', fetchMotorcycles);
    document.getElementById('statusFilter').addEventListener('change', fetchMotorcycles);

    function fetchMotorcycles() {
        const searchQuery = document.getElementById('searchInput').value;
        const priceRange = document.getElementById('priceFilter').value;
        const status = document.getElementById('statusFilter').value;

        const url = new URL('{{ route('motorcycles.search') }}');
        url.searchParams.append('search', searchQuery);
        if (priceRange) url.searchParams.append('price', priceRange);
        if (status) url.searchParams.append('status', status);

        fetch(url)
            .then(response => response.text())
            .then(data => {
                document.getElementById('motorcycleList').innerHTML = data;
            })
            .catch(error => console.error('Error:', error));
    }
</script>
