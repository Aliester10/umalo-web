<!-- Sidebar -->
<div class="sidebar" data-background-color="light">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="light">
            <a href="{{ route('member.dashboard') }}" class="logo">
                <img src="{{ asset('assets/img/logo.png') }}" alt="navbar brand" class="navbar-brand" width="120" />
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

                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="{{ route('member.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>

                <!-- Member Management -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Kelola Produk</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#member-management">
                        <i class="fas fa-user-friends"></i>
                        <p>Produk</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="member-management">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('member.products.index') }}">
                                    <span class="sub-item">Produk Saya</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <!-- Ticketing -->
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Kelola Ticketing</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#ticket-management">
                        <i class="fas fa-ticket-alt"></i>
                        <p>Ticketing</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="ticket-management">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('member.ticketing.index') }}">
                                    <span class="sub-item">Ticketing</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->
