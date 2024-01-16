<aside class="main-sidebar sidebar-dark-navy elevation-4" style="height: 100vh">

    <!-- System title and logo -->
    <a href="{{ route('dashboard') }}" class="brand-link text-center">
        {{-- <a href="" class="brand-link text-center"> --}}
        {{-- <img src="{{ asset('public/images/pricon_logo2.png') }}" --}}
        <img src="" class="brand-image img-circle elevation-3" style="opacity: .8">

        <span class="brand-text font-weight-light font-size">
            <h5>PATS-PPD</h5>
        </span>
    </a> <!-- System title and logo -->

    <!-- Sidebar -->
    <div class="sidebar">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                {{-- <li class="nav-item has-treeview">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}
                <li class="nav-header">ADMINISTRATOR</li>
                <li class="nav-item">
                    <a href="{{ route('user') }}" class="nav-link">
                        <i class="fas fa-users"></i>
                        <p>
                            User
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('process') }}" class="nav-link">
                        <i class="fas fa-list-ol"></i>
                        <p>
                            Process
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('materialprocess') }}" class="nav-link">
                        <i class="fas fa-list-ol"></i>
                        <p>
                            Material Process
                        </p>
                    </a>
                </li>

                {{-- </li class="nav-header">User</li> --}}
                <li class="nav-header mt-3">QUALITY CONTROL</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-search"></i>
                        <p> QC Database </p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('iqc_inspection') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>IQC Inspection</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header mt-3">PRODUCTION</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-box-open"></i>
                        <p> First Stamping </p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('first_stamping_prod') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Production</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('ipqc_inspection') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>IPQC</p>
                            </a>
                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('oqc_inspection') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>OQC Inspection</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header mt-3">PACKING LIST</li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="fas fa-shipping-fast"></i>
                        <p> Packing List Details</p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"></i>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('packing_list_settings') }}" class="nav-link">
                                {{-- <i class="fas fa-map-marked-alt"></i> --}}
                                {{-- <i class="fas fa-cog"></i> --}}
                                <i class="far fa-circle nav-icon"></i>
                                <p>Packing List Settings</p>
                            </a>
                        </li>
                    </ul>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('packing_list') }}" class="nav-link">
                                {{-- <i class="fas fa-dolly"></i> --}}
                                <i class="far fa-circle nav-icon"></i>
                                <p>Packing List </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-header mt-3">RECEIVING</li>
                <li class="nav-item has-treeview">
                        <li class="nav-item">
                            <a href="{{ route('receiving') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Receiving</p>
                            </a>
                        </li>
                </li>
            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>
