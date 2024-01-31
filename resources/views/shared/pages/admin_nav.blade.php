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
                        <i class="nav-icon fas fa-tachometer-alt"> </i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li> --}}
                @auth
                    @if (in_array(Auth::user()->user_level_id, [1,2]))
                        <li class="nav-header"><strong>ADMINISTRATOR</strong></li>
                        <li class="nav-item">
                            <a href="{{ route('user') }}" class="nav-link">
                                <i class="fas fa-users"> </i>
                                <p>
                                    User
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('defectsinfo') }}" class="nav-link">
                                <i class="fas fa-bolt"> </i>
                                <p>
                                    Defects
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('process') }}" class="nav-link">
                                <i class="fas fa-list-ol"> </i>
                                <p>
                                    Process
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('materialprocess') }}" class="nav-link">
                                <i class="fas fa-list-ol"> </i>
                                <p>
                                    Material Process
                                </p>
                            </a>
                        </li>
                    @endif

                    @if (in_array(Auth::user()->position, [0,2,5]))
                        <li class="nav-header mt-3"><strong>QUALITY CONTROL</strong></li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-search"> </i>
                                <p> IQC Inspection </p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"> </i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('first_stamping_iqc_inspection') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>IQC</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('second_stamping_iqc_inspection') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>IQC (2nd Stamping)</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-microscope"> </i>
                                    <p> IPQC </p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"> </i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('ipqc_inspection_1st_stamping') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>IPQC 1st Stamping</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('ipqc_inspection_2nd_stamping') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>IPQC 2nd Stamping</p>
                                    </a>
                                </li>
                            </ul>
                        </li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-tasks"> </i>
                                <p> OQC Inspection </p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"> </i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('first_stamping_oqc_inspection') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>OQC 1st Stamping</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('second_stamping_oqc_inspection') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>OQC 2nd Stamping</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif
                    @if (in_array(Auth::user()->position, [0,1,4,11]))
                        <li class="nav-header mt-3"><strong>PRODUCTION</strong></li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                {{-- <i class="fa-solid fa-box-open"> </i> --}}
                                <i class="fa-solid fa-stamp"> </i>
                                <p> Stamping </p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"> </i>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('first_stamping_prod') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>1st Stamping</p>
                                    </a>
                                </li>
                            </ul>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('second_stamping_prod') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>2nd Stamping</p>
                                    </a>
                                </li>
                            </ul>
                            {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('second_stamping_prod') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>2nd Stamping</p>
                                    </a>
                                </li>
                            </ul> --}}

                        </li>
                    @endif

                    @if (in_array(Auth::user()->position, [0,6,7,9,11,13,2]))
                        <li class="nav-header mt-3"><strong>PACKING</strong></li>

                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fa-solid fa-box-open"></i>
                                <p> Packing</p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"> </i>
                            </a>


                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('packing_details') }}" class="nav-link">
                                        {{-- <i class="fas fa-dolly"> </i> --}}
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>Packing Details to</p>
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;SANNO</p>
                                    </a>
                                    <a href="{{ route('packing_details_molding') }}" class="nav-link">
                                        {{-- <i class="fas fa-dolly"> </i> --}}
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>Packing Details to</p>
                                        <p>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;MOLDING</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (in_array(Auth::user()->position, [0,8,9,10]))
                        <li class="nav-header mt-3"><strong>PPC</strong></li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <i class="fas fa-shipping-fast"> </i>
                                <p> Packing List Details</p>&nbsp;&nbsp;&nbsp;<i class="fas fa-angle-down"> </i>
                            </a>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('packing_list_settings') }}" class="nav-link">
                                        {{-- <i class="fas fa-map-marked-alt"> </i> --}}
                                        {{-- <i class="fas fa-cog"> </i> --}}
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>Packing List Settings</p>
                                    </a>
                                </li>
                            </ul>

                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('packing_list') }}" class="nav-link">
                                        {{-- <i class="fas fa-dolly"> </i> --}}
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>Packing List </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    @endif

                    @if (in_array(Auth::user()->position, [0,6]))
                        <li class="nav-header mt-3"><strong>WAREHOUSE</strong></li>
                        <li class="nav-item has-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('receiving') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"> </i>
                                        <p>Receiving from SANNO</p>
                                    </a>
                                </li>
                        </li>
                    @endif

                    @if (in_array(Auth::user()->position, [0]))
                        <li class="nav-header mt-3 font-weight-bold">MOLDING</li>
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p><i class="fa-solid fa-shapes"> </i> Molding </p>
                                    <i class="fas fa-angle-down"> </i>
                                </div>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('first_molding') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>1st Molding</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('second_molding') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>2nd Molding</p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ route('cn_assembly') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>Assy</p>
                                    </a>
                                </li>
                            </ul>
                            {{-- <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ route('oqc_inspection_molding') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>OQC Inspection Molding</p>
                                    </a>
                                </li>
                            </ul> --}}
                        </li>
                         <li class="nav-item">
                            <a href="{{ route('production_history') }}" class="nav-link">
                                <i class="fas fa-gears"> </i>
                                <p>
                                    Production History
                                </p>
                            </a>
                        </li>
                    @endif

                    @if (in_array(Auth::user()->position, [0]))
                        {{-- <li class="nav-header mt-3 font-weight-bold">ASSEMBLY</li>
                        <li class="nav-item has-treeview"> --}}
                            {{-- <a href="#" class="nav-link">
                                <div class="d-flex justify-content-between align-items-center">
                                    <p><i class="fa-solid fa-shapes"> </i> Molding </p>
                                    <i class="fas fa-angle-down"> </i>
                                </div>
                            </a> --}}
                            {{-- <ul class="nav nav-treeview"> --}}
                                {{-- <li class="nav-item">
                                    <a href="{{ route('cn_assembly') }}" class="nav-link">
                                        <i class="fa-brands fa-phabricator fa-xl" style="color: #29d6a2;"> </i>
                                        <p>CN Assembly</p>
                                    </a>
                                </li> --}}
                                {{-- <li class="nav-item">
                                    <a href="{{ route('second_molding') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon ml-2"> </i>
                                        <p>2nd Molding</p>
                                    </a>
                                </li> --}}
                            {{-- </ul> --}}
                        {{-- </li> --}}
                    @endif

                    @if (in_array(Auth::user()->position, [0]))
                    <li class="nav-header mt-3 font-weight-bold">MOLDING PACKING</li>
                    <li class="nav-item has-treeview">
                        <a href="#" class="nav-link">
                            <div class="d-flex justify-content-between align-items-center">
                                <p><i class="fa-solid fa-shapes"> </i> PPTS </p>
                                <i class="fas fa-angle-down"> </i>
                            </div>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route("ppts_oqc_inspection") }}" class="nav-link">
                                    <i class="far fa-circle nav-icon ml-2"> </i>
                                    <p>OQC Inspection</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="" class="nav-link">
                                    <i class="far fa-circle nav-icon ml-2"> </i>
                                    <p>Packing and Shipping</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endif
                @endauth

            </ul>
        </nav>
    </div><!-- Sidebar -->
</aside>
