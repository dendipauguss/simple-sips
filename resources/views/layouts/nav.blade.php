<nav id="mainnav-container" class="mainnav">
    <div class="mainnav__inner">

        <!-- Navigation menu -->
        <div class="mainnav__top-content scrollable-content pb-5">

            <!-- Profile Widget -->
            <div class="mainnav__profile mt-3 d-flex3">

                <div class="mt-2 d-mn-max"></div>


                <div class="mininav-content collapse d-mn-max">
                    <div class="d-grid">

                        <!-- User name and position -->
                        <div class="d-block btn shadow-none p-2">
                            <span class="d-flex justify-content-center align-items-center">
                                <h6 class="mb-0">{{ auth()->user()->nama }}</h6>
                            </span>
                            <small class="text-muted">{{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</small>
                        </div>

                        <!-- Collapsed user menu -->

                    </div>
                </div>

            </div>
            <!-- End - Profile widget -->

            <!-- Navigation Category -->
            <div class="mainnav__categoriy py-3">
                <h6 class="mainnav__caption mt-0 px-3 fw-bold">
                    {{ ucwords(str_replace('_', ' ', auth()->user()->role)) }}</h6>
                <ul class="mainnav__menu nav flex-column">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}"
                            class="nav-link mininav-toggle collapsed {{ request()->is('dashboard') || request()->is('/') ? 'active' : '' }}"><i
                                class="psi-home fs-5 me-2"></i>

                            <span class="nav-label mininav-content ms-1">Dashboard</span>
                        </a>
                    </li>
                    <!-- END : Dashboard -->

                    <li class="nav-item has-sub">
                        <a href="#"
                            class="mininav-toggle nav-link collapsed {{ request()->is('pengenaan-sp*') || request()->is('laporan*') ? 'active' : '' }}"><i
                                class="psi-pantheon fs-5 me-2"></i>
                            <span class="nav-label ms-1">Manajemen Sanksi</span>
                        </a>

                        <!-- Dashboard submenu list -->
                        <ul class="mininav-content nav collapse" style="">
                            <li class="nav-item">
                                <a href="{{ route('pengenaan-sp.create') }}"
                                    class="nav-link {{ request()->is('pengenaan-sp/create*') ? 'active' : '' }}">
                                    Input Sanksi
                                </a>
                            </li>
                            <!-- END : Pengenaan SP -->

                            <!-- Pengenaan Sanksi -->
                            <li class="nav-item">
                                <a href="{{ route('pengenaan-sp.index') }}"
                                    class="nav-link {{ request()->is('pengenaan-sp*') && !request()->is('pengenaan-sp/create*') && !request()->is('pengenaan-sp/laporan*') ? 'active' : '' }}">
                                    Monitoring Pengenaan Sanksi
                                </a>
                            </li>
                            <!-- END : Pengenaan Sanksi -->

                            <!-- Buat Laporan -->
                            <li class="nav-item">
                                <a href="{{ url('laporan') }}"
                                    class="nav-link {{ request()->is('laporan*') ? 'active' : '' }}">
                                    Laporan Pengenaan Sanksi
                                </a>
                            </li>

                        </ul>
                        <!-- END : Dashboard submenu list -->

                    </li>
                    {{-- <li class="nav-item has-sub">
                        <a href="#"
                            class="mininav-toggle nav-link collapsed {{ request()->is('pengenaan-sp*') ? 'active' : '' }}"><i
                                class="psi-pantheon fs-5 me-2"></i>
                            <span class="nav-label ms-1">Manajemen Sanksi</span>
                        </a>
                        <!-- Menu Levels submenu list -->
                        <ul class="mininav-content nav collapse">
                            
                            <!-- END : Buat Laporan -->
                        </ul>
                        <!-- END : Menu Levels submenu list -->
                    </li> --}}
                    <!-- END : Link with submenu -->

                    <!-- Pengenaan SP -->

                    @if (auth()->user()->role == 'admin')
                        <!-- Link with submenu -->
                        <li class="nav-item has-sub">
                            <a href="#"
                                class="mininav-toggle nav-link collapsed {{ request()->is('pengaturan*') ? 'active' : '' }}"><i
                                    class="psi-gear fs-5 me-2"></i>
                                <span class="nav-label ms-1">Pengaturan</span>
                            </a>
                            <!-- Menu Levels submenu list -->
                            <ul class="mininav-content nav collapse">

                                <!-- Jenis Pelaku Usaha -->
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/jenis-pelaku-usaha') }}"
                                        class="nav-link mininav-toggle collapsed {{ request()->is('pengaturan/jenis-pelaku-usaha*') ? 'active' : '' }}">
                                        {{-- <i class="psi-building fs-5 me-2"></i> --}}
                                        Jenis Pelaku Usaha
                                    </a>
                                </li>
                                <!-- END : Jenis Pelaku Usaha -->

                                <!-- Pelaku Usaha -->
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/pelaku-usaha') }}"
                                        class="nav-link mininav-toggle collapsed {{ request()->is('pengaturan/pelaku-usaha*') ? 'active' : '' }}">
                                        {{-- <i class="psi-building fs-5 me-2"></i> --}}
                                        Pelaku Usaha
                                    </a>
                                </li>
                                <!-- END : Pelaku Usaha -->

                                <!-- Jenis Pelanggaran -->
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/jenis-pelanggaran') }}"
                                        class="nav-link mininav-toggle collapsed {{ request()->is('pengaturan/jenis-pelanggaran*') ? 'active' : '' }}">
                                        {{-- <i class="psi-building fs-5 me-2"></i> --}}
                                        Jenis Pelanggaran
                                    </a>
                                </li>
                                <!-- END : Jenis Pelanggaran -->

                                <!-- Kategori SP -->
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/kategori-sp') }}"
                                        class="nav-link mininav-toggle collapsed {{ request()->is('pengaturan/kategori-sp*') ? 'active' : '' }}">
                                        {{-- <i class="psi-building fs-5 me-2"></i> --}}
                                        Kategori Sanksi
                                    </a>
                                </li>
                                <!-- END : Kategori SP -->

                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/sanksi') }}"
                                        class="nav-link {{ request()->is('pengaturan/sanksi*') ? 'active' : '' }}">
                                        Bentuk Sanksi
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/perintah-sanksi') }}"
                                        class="nav-link {{ request()->is('pengaturan/perintah-sanksi*') ? 'active' : '' }}">Perintah
                                        Bentuk Sanksi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/users') }}"
                                        class="nav-link {{ request()->is('pengaturan/users*') ? 'active' : '' }}">Users</a>
                                </li>
                            </ul>
                            <!-- END : Menu Levels submenu list -->
                        </li>
                        <!-- END : Link with submenu -->
                    @endif
                </ul>
            </div>
            <!-- END : Navigation Category -->


        </div>
        <!-- End - Navigation menu -->

        <!-- Bottom navigation menu -->
        <div class="mainnav__bottom-content border-top pb-2">
            <ul id="mainnav" class="mainnav__menu nav flex-column">
                <li class="nav-item has-sub">
                    <form action="{{ route('logout') }}" method="post">
                        @csrf
                        <button type="submit" class="btn nav-link mininav-toggle collapsed" aria-expanded="false"><i
                                class="psi-unlock fs-5 me-2"></i>
                            <span class="nav-label ms-1"><b>Logout</b></span></button>
                    </form>
                </li>
            </ul>
        </div>
        <!-- End - Bottom navigation menu -->

    </div>
</nav>
