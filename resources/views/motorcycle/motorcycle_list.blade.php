@if ($motorcycles->isEmpty())
    <div class="col-12">
        <h5 class="text-center fw-bold mt-5">No motorcycles found.</h5>
    </div>
    <br>
    <br>
@else
    @foreach ($motorcycles as $motorcycle)
        <div class="col-md-3 mb-4">
            <div class="rental-card">
                @if ($motorcycle->images)
                    @php
                        $images = json_decode($motorcycle->images);
                        $firstImage = $images[0] ?? null;
                    @endphp
                    @if ($firstImage)
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $firstImage) }}" alt="{{ $motorcycle->name }}" class="img-fluid">
                            <span class="badge bg-{{ $motorcycle->status === 'Available' ? 'success' : 'danger' }} position-absolute m-2">
                                {{ $motorcycle->status }}
                            </span>
                        </div>
                    @endif
                @endif
                <div class="rental-card-body m-2">
                    <h3 class="rental-card-title">{{ $motorcycle->name }}</h3>
                    <p class="rental-card-year">{{ $motorcycle->year }}</p>
                    <span class="rental-card-feature"><i class="fas fa-cog"></i> Engine CC: {{ $motorcycle->cc }}</span>
                    <p class="rental-card-price">₱{{ number_format($motorcycle->price, 2) }} / day</p>
                    <a href="{{ route('motorcycle.details-motorcycle', $motorcycle->motor_id) }}" class="btn-rent-now">View Details</a>
                </div>
            </div>
        </div>
    @endforeach
@endif
