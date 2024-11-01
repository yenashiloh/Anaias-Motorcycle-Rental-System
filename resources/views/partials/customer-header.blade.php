    <!-- Spinner Start -->
    <div id="spinner"
        class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    <!-- Topbar Start -->
    <div class="container-fluid topbar bg-secondary d-none d-xl-block w-100">
        <div class="container">
            <div class="row gx-0 align-items-center" style="height: 45px;">
                <div class="col-lg-6 text-center text-lg-start mb-lg-0">
                    <div class="d-flex flex-wrap">
                        <a href="#" class="text-muted me-4"><i
                                class="fas fa-map-marker-alt text-primary me-2"></i>Bacoor, Philippines</a>
                        <a href="tel:0917 623 1426" class="text-muted me-4"><i
                                class="fas fa-phone-alt text-primary me-2"></i>0917 623 1426</a>
                        <a href="jpineda132020@gmail.com" class="text-muted me-0"><i
                                class="fas fa-envelope text-primary me-2"></i>jpineda132020@gmail.com</a>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <a href="https://www.facebook.com/anaiasmotorcyclerental?mibextid=ZbWKwL"
                            class="btn btn-light btn-sm-square rounded-circle me-3"><i
                                class="fab fa-facebook-f"></i></a>
                        <a href="https://www.tiktok.com/@anaiasmotorcyclerental?fbclid=IwY2xjawFOsdBleHRuA2FlbQIxMAABHaRSECzRyrt2cz7SMQxcrUWYxVO6joVboqFytFJR0w0WoyRj21wAT_eysw_aem_eYOUzZHNEccOJFS0Pu3gaw"
                            class="btn btn-light btn-sm-square rounded-circle me-3"><i class="fab fa-tiktok"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar & Hero Start -->
    <div class="container-fluid nav-bar sticky-top px-0 px-lg-4 py-2 py-lg-0">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light">
                <a href="" class="navbar-brand p-0">
                    <img src="../../assets/img/logo.png" class="logo" alt="Logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <div class="navbar-nav mx-auto py-0">
                        <a href="{{ route('home') }}#home" class="nav-item nav-link" data-section="home">Home</a>
                        <a href="{{ route('home') }}#features" class="nav-item nav-link"
                            data-section="features">Features</a>
                        <a href="{{ route('home') }}#process" class="nav-item nav-link"
                            data-section="process">Process</a>
                        <a href="{{ route('home') }}#services" class="nav-item nav-link"
                            data-section="services">Services</a>
                        <a href="{{ route('motorcycles') }}" class="nav-item nav-link"
                            data-section="motorcycles">Motorcycles</a>
                    </div>
                    <div class="d-flex align-items-center">
                        @if (Auth::guard('customer')->check())
                            <!-- Notification Bell -->
                            <div class="me-3 position-relative">
                                <a href="#" id="notificationDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-bell notification-bell" style="color: black;"></i>
                                    <span class="visually-hidden">unread notifications</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown">
                                    <li>
                                        <div class="dropdown-title text-center">Notifications</div>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item notification-item" href="#">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0">
                                                    <i class="fas fa-user-circle fa-2x me-2"></i>
                                                </div>
                                                <div class="flex-grow-1 ms-2">
                                                    <p class="mb-0"><strong>Ezekielle Cortez</strong></p>
                                                    <p class="mb-0 small">Approved your rent motorcycle</p>
                                                    <small class="time">2 hours ago</small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item text-center" href="#">View all notifications</a>
                                    </li>
                                </ul>
                            </div>

                            <!-- User Dropdown -->
                            <div class="me-3 position-relative">
                                <a href="#" id="userDropdown" role="button" data-bs-toggle="dropdown"
                                    aria-expanded="false">
                                    <i class="fas fa-user-circle" style="color: black; font-size: 24px;"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                    @if (Auth::guard('customer')->check())
                                        <li class="text-center mb-2 px-3 py-2">
                                            <p class="mb-0 text-truncate"
                                                style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                                <strong>{{ Auth::guard('customer')->user()->email }}</strong>
                                            </p>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                    @endif
                                    <li><a class="dropdown-item" href="{{ route('customer.customer-dashboard')}}">History Bookings</a></li>
                                    <li><a class="dropdown-item" href="">Settings</a></li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <form id="logoutForm" action="{{ route('customer.logout') }}" method="POST"
                                            class="m-0">
                                            @csrf
                                            <button type="button" class="dropdown-item"
                                                id="logoutButton">Logout</button>
                                        </form>
                                    </li>
                                </ul>

                            </div>
                        @else
                            <!-- Login Button -->
                            <a href="{{ route('login') }}" class="btn btn-danger rounded-pill py-2 px-4">Login</a>
                        @endif
                    </div>
            </nav>
        </div>
    </div>
    <!-- Navbar & Hero End -->

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const navLinks = document.querySelectorAll('.nav-item.nav-link');

            function setActiveLink() {
                const currentPath = window.location.pathname;
                const currentHash = window.location.hash;
                const currentSection = currentHash.slice(1) || 'home';

                navLinks.forEach(link => {
                    const section = link.getAttribute('data-section');
                    if (currentPath === '/' || currentPath === '/home') {
                        link.classList.toggle('active', section === currentSection);
                    } else if (currentPath.startsWith('/details-motorcycle')) {
                        link.classList.toggle('active', section === 'motorcycles');
                    } else {
                        link.classList.toggle('active', `/${section}` === currentPath);
                    }
                });
            }

            navLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    const section = this.getAttribute('data-section');

                    if (section !== 'motorcycles' && (window.location.pathname === '/' || window
                            .location.pathname === '/home')) {
                        e.preventDefault();
                        const targetElement = document.getElementById(section);

                        if (targetElement) {
                            targetElement.scrollIntoView({
                                behavior: 'smooth'
                            });
                            history.pushState(null, '', href);
                            setActiveLink();
                        }
                    } else {
                        setActiveLink();
                    }
                });
            });

            setActiveLink();
            window.addEventListener('popstate', setActiveLink);
        });

        document.getElementById('logoutButton').addEventListener('click', function() {
            Swal.fire({
                title: 'Logout',
                text: "Are you sure you want to logout?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, logout!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logoutForm').submit();
                }
            });
        });
    </script>
