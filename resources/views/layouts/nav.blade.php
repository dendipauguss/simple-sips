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
                            <small class="text-muted">{{ auth()->user()->role }}</small>
                        </div>

                        <!-- Collapsed user menu -->

                    </div>
                </div>

            </div>
            <!-- End - Profile widget -->

            <!-- Navigation Category -->
            <div class="mainnav__categoriy py-3">
                <h6 class="mainnav__caption mt-0 px-3 fw-bold">{{ auth()->user()->role }}</h6>
                <ul class="mainnav__menu nav flex-column">

                    <!-- Dashboard -->
                    <li class="nav-item">
                        <a href="{{ url('dashboard') }}"
                            class="nav-link mininav-toggle collapsed {{ request()->is('dashboard') ? 'active' : '' }}"><i
                                class="psi-home fs-5 me-2"></i>

                            <span class="nav-label mininav-content ms-1">Dashboard</span>
                        </a>
                    </li>
                    <!-- END : Dashboard -->

                    <!-- Perusahaan -->
                    <li class="nav-item">
                        <a href="{{ url('perusahaan') }}"
                            class="nav-link mininav-toggle collapsed {{ request()->is('perusahaan') ? 'active' : '' }}"><i
                                class="psi-building fs-5 me-2"></i>

                            <span class="nav-label mininav-content ms-1">Perusahaan</span>
                        </a>
                    </li>
                    <!-- END : Perusahaan -->

                    <!-- Pengenaan Sanksi -->
                    <li class="nav-item">
                        <a href="{{ url('penindakan') }}"
                            class="nav-link mininav-toggle collapsed {{ request()->is('penindakan*') && !request()->is('penindakan/laporan') ? 'active' : '' }}"><i
                                class="psi-board fs-5 me-2"></i>

                            <span class="nav-label mininav-content ms-1">Pengenaan Sanksi</span>
                        </a>
                    </li>
                    <!-- END : Pengenaan Sanksi -->

                    <!-- Buat Laporan -->
                    <li class="nav-item">
                        <a href="{{ url('penindakan/laporan') }}"
                            class="nav-link mininav-toggle collapsed {{ request()->is('penindakan/laporan') ? 'active' : '' }}"><i
                                class="psi-notepad fs-5 me-2"></i>

                            <span class="nav-label mininav-content ms-1">Laporan Pengenaan Sanksi</span>
                        </a>
                    </li>
                    <!-- END : Buat Laporan -->

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
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/sanksi') }}"
                                        class="nav-link {{ request()->is('pengaturan/sanksi*') ? 'active' : '' }}">Bentuk
                                        Sanksi</a>
                                </li>
                                <li class="nav-item">
                                    <a href="{{ url('pengaturan/perintah-sanksi') }}"
                                        class="nav-link {{ request()->is('pengaturan/perintah-sanksi*') ? 'active' : '' }}">Perintah
                                        Bentuk Sanksi</a>
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
