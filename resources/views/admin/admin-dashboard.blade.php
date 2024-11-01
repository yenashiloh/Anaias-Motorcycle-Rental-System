<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Dashboard</title>
    @include('partials.admin-link')
</head>

<body>

    @include('partials.admin-sidebar')
    @include('partials.admin-header')

    <div class="container">
        <div class="page-inner">
            <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                <div>
                    <h3 class="fw-bold mb-3">Dashboard</h3>
                    <h6 class="op-7 mb-2">All reports are displayed in this dashboard</h6>
                </div>
                {{-- <div class="ms-md-auto py-2 py-md-0">
                    <a href="#" class="btn btn-secondary btn-round">Generate Report</a>
                </div> --}}
            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-primary bubble-shadow-small">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Users</p>
                                        <h4 class="card-title">{{ $customerCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-info bubble-shadow-small">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Maintenance</p>
                                        <h4 class="card-title">{{$maintenanceMotorcycleCount}}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-secondary bubble-shadow-small">
                                        <i class="fas fa-motorcycle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Motorcycles</p>
                                        <h4 class="card-title">{{ $motorcycleCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-warning bubble-shadow-small">
                                        <i class="far fa-calendar-alt"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Total Bookings</p>
                                        <h4 class="card-title">{{ $reservationCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-success bubble-shadow-small">
                                        <i class="fas fa-check-circle"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Available Motorcycles</p>
                                        <h4 class="card-title">{{ $availableMotorcycleCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="card card-stats card-round">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-icon">
                                    <div class="icon-big text-center icon-danger bubble-shadow-small">
                                        <i class="fas fa-ban"></i>
                                    </div>
                                </div>
                                <div class="col col-stats ms-3 ms-sm-0">
                                    <div class="numbers">
                                        <p class="card-category">Not Available Motorcycles</p>
                                        <h4 class="card-title">{{ $notAvailableMotorcycleCount }}</h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Customer's Gender</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="genderChart" style="width: 50%; height: auto;"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Customer's Age</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="ageChart" style="width: 50%; height: auto;"></canvas>
                        </div>
                    </div>
                </div>
            </div>



            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Motorcycle Rentals Count</h4>
                    </div>
                    <div class="card-body">
                        <canvas id="motorcycleChart" style="width: 100%; height: 400px;"></canvas>
                    </div>
                </div>
            </div>

        </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    @include('partials.admin-footer')
</body>

</html>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Gender Chart
        const genderCounts = @json($genderCounts);
        const labels = Object.keys(genderCounts);
        const data = Object.values(genderCounts);

        const ctx = document.getElementById('genderChart').getContext('2d');
        const genderChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Gender Distribution',
                    data: data,
                    backgroundColor: [
                        'rgba(54, 162, 235, 0.5)', // Semi-transparent blue
                        'rgba(255, 99, 132, 0.5)' // Semi-transparent red
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: 'Driver Gender Distribution'
                    }
                }
            }
        });

        // Motorcycle Reservations Chart
        const motorcycleReservations = @json($motorcycleReservations);
        const motorcycleNames = @json($motorcycleNames);
        const motorcycleLabels = Object.keys(motorcycleReservations).map(id => motorcycleNames[id] ||
        'Unknown');
        const motorcycleData = Object.values(motorcycleReservations);

        const ctxMotorcycle = document.getElementById('motorcycleChart').getContext('2d');

        // Function to generate a random RGBA color
        function getRandomColor() {
            const r = Math.floor(Math.random() * 256);
            const g = Math.floor(Math.random() * 256);
            const b = Math.floor(Math.random() * 256);
            const a = 0.6; // Set transparency
            return `rgba(${r}, ${g}, ${b}, ${a})`;
        }

        // Create an array of random colors for each bar
        const colors = motorcycleLabels.map(() => getRandomColor());

        const motorcycleChart = new Chart(ctxMotorcycle, {
            type: 'bar',
            data: {
                labels: motorcycleLabels,
                datasets: [{
                    label: 'Number of Reservations',
                    data: motorcycleData,
                    backgroundColor: colors, // Use the random colors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Motorcycle Reservation Counts'
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });

        // Customer's Age Distribution as a Pie Chart
        const ageCounts = @json($ageCounts);
        const ageLabels = Object.keys(ageCounts).map(age => `${age} yrs old`); // Add "yrs old" to each label
        const ageData = Object.values(ageCounts);

        // Generate random colors for each age group
        const ageColors = ageLabels.map(() => getRandomColor());

        const ctxAge = document.getElementById('ageChart').getContext('2d');
        const ageChart = new Chart(ctxAge, {
            type: 'pie',
            data: {
                labels: ageLabels, // Now contains "23 yrs old" instead of just "23"
                datasets: [{
                    label: "Customer's Age Distribution",
                    data: ageData,
                    backgroundColor: ageColors
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    title: {
                        display: true,
                        text: "Customer's Age Distribution"
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.raw || 0;
                                return `${label}: ${value}`; // Will now show "23 yrs old: 6"
                            }
                        }
                    }
                }
            }
        });
    });
</script>
