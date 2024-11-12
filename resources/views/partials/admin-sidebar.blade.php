<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="white">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="white">
                <a href="index.html" class="logo mt-3">

                    <img src="../../../../assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="60" />
                </a>
                <div class="nav-toggle">
                    <button class="btn btn-toggle toggle-sidebar">
                        <i class="gg-menu-right"></i>
                    </button>
                    <button class="btn btn-toggle sidenav-toggler">
                        <i class="gg-menu-left"></i>
                    </button>
                </div>
                <button class="topbar-toggler more">
                    <i class="gg-more-vertical-alt"></i>
                </button>
            </div>
            <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
            <div class="sidebar-content">
                <ul class="nav nav-secondary">
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Menu</h4>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.admin-dashboard') ? 'active' : '' }}">
                        <a href="{{ route('admin.admin-dashboard') }}" class="collapsed" aria-expanded="false">
                            <i class="fas fa-home"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Motorcycle Management</h4>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('admin.motorcycles.manage-motorcycles', 'admin.motorcycles.add-motorcycle', 'admin.motorcycles.edit-motorcycle', 'admin.motorcycles.view-motorcycle') ? 'active' : '' }}">
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}">
                            <i class="fas fa-motorcycle"></i>
                            <p>Motorcycles</p>
                        </a>
                    </li>
                    <li
                    class="nav-item {{ request()->routeIs('admin.motorcycles.maintenance-motorcycles', 'admin.reservation.view-bookings-specific') ? 'active' : '' }}">
                    <a href="{{ route('admin.motorcycles.maintenance-motorcycles') }}">
                        <i class="fa fa-wrench"></i>
                        <p>Motorcycle Maintenance</p>
                    </a>
                </li>
                  
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Reservation Management</h4>
                    </li>

                    {{-- <li class="nav-item">
                        <a href="#sidebarLayouts">
                            <i class="fas fa-users"></i>
                            <p>Customers</p>
                        </a>
                    </li> --}}
                    <li class="nav-item {{ request()->routeIs('admin.reservation.bookings', 'admin.reservation.view-bookings') ? 'active' : '' }}">
                        <a href="{{ route('admin.reservation.bookings') }}">
                            <i class="fas fa-calendar"></i>
                            <p>Bookings</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.reservation.ongoing-bookings', 'admin.reservation.view-ongoing-bookings') ? 'active' : '' }}">
                        <a href="{{ route('admin.reservation.ongoing-bookings') }}">
                            <i class="fas fa-calendar-check"></i>
                            <p>Ongoing Bookings</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.reservation.all-bookings-record', 'admin.reservation.view-all-bookings') ? 'active' : '' }}">
                        <a href="{{ route('admin.reservation.all-bookings-record') }}">
                            <i class="fas fa-clipboard-list"></i>
                            <p>All Bookings Record</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.reservation.penalties') ? 'active' : '' }}">
                        <a href="{{ route('admin.reservation.penalties') }}">
                            <i class="fas fa-exclamation-triangle"></i>
                            <p>Penalties</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->
