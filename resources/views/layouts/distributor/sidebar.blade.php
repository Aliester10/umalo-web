<!-- Sidebar -->
<div class="sidebar" data-background-color="light">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="light">
            <a href="{{ route('distributor.dashboard') }}" class="logo">
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
                    <a href="{{ route('distributor.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Beranda</p>
                    </a>
                </li>

                <!-- Member Management -->
                 <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Kelola Quotation</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#quotation-management">
                        <i class="fas fa-file-invoice"></i>
                        <p>Quotation</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse" id="quotation-management">
                        <ul class="nav nav-collapse">
                            <li>
                                <a href="{{ route('distributor.quotations.index') }}">
                                    <span class="sub-item">Quotation Saya</span>
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
