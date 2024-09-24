<div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="white">
        <div class="sidebar-logo">
            <!-- Logo Header -->
            <div class="logo-header" data-background-color="white">
                <a href="index.html" class="logo mt-3">

                    <img src="../../assets/img/logo.png" alt="navbar brand" class="navbar-brand" height="60" />
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
                      <h4 class="text-section">Motorcycle</h4>
                    </li>
                    <li
                        class="nav-item {{ request()->routeIs('admin.motorcycles.manage-motorcycles', 'admin.motorcycles.add-motorcycle', 'admin.motorcycles.edit-motorcycle', 'admin.motorcycles.view-motorcycle') ? 'active' : '' }}">
                        <a href="{{ route('admin.motorcycles.manage-motorcycles') }}">
                            <i class="fas fa-motorcycle"></i>
                            <p>Manage Motorcycles</p>
                        </a>
                    </li>

                    <li class="nav-section">
                      <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                      </span>
                      <h4 class="text-section">Reservation</h4>
                    </li>
                    <li class="nav-item">
                        <a href="#sidebarLayouts">
                            <i class="fas fa-users"></i>
                            <p>Customer Management</p>
                        </a>

                    </li>
                    <li class="nav-item">
                        <a href="#forms">
                            <i class="fas fa-calendar"></i>
                            <p>Bookings Management</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- End Sidebar -->
