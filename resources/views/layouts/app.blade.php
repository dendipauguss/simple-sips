<!DOCTYPE html>
<html lang="en">

    <head>
        <meta name="generator" content="Hugo 0.87.0">
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <meta name="description"
            content="Nifty is a responsive admin dashboard template based on Bootstrap 5 framework. There are a lot of useful components.">
        <title>{{ $title }}</title>

        <link rel="shortcut icon" href="/img/kemendag-bappebti-logo.ico" type="image/x-icon">
        <!-- STYLESHEETS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->

        <!-- Fonts [ OPTIONAL ] -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;family=Ubuntu:wght@400;500;700&amp;display=swap"
            rel="stylesheet">
        <!-- Bootstrap CSS [ REQUIRED ] -->
        {{-- <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/bootstrap.min.css">

        <!-- Nifty CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/nifty.min.css"> --}}

        <!-- Bootstrap CSS [ REQUIRED ] -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/css/color-schemes/all-headers/night/bootstrap.min.css">

        <!-- Nifty CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/all-headers/night/nifty.min.css">

        <!-- Nifty Color Schemes -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/dark/nifty.min.css">

        {{-- <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/brand/night/nifty.min.css"> --}}

        <!-- Nifty Premium Line Icons [ OPTIONAL ] -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/premium/icon-sets/icons/line-icons/premium-line-icons.min.css">

        <!-- Nifty Premium Solid Icons -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css">

        <link rel="stylesheet" href="{{ env('DTABLES_LINK') }}/css/jquery.dataTables.min.css">

        <!-- Select2 Styles -->
        <link href="{{ env('SELECT2_LINK') }}/dist/css/select2.min.css" rel="stylesheet" />

        <link rel="stylesheet" href="{{ env('SELECT2_BOOTSTRAP_LINK') }}/dist/select2-bootstrap-5-theme.min.css" />

        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~---

    [ REQUIRED ]
    You must include this category in your project.


    [ OPTIONAL ]
    This is an optional plugin. You may choose to include it in your project.


    [ DEMO ]
    Used for demonstration purposes only. This category should NOT be included in your project.


    [ SAMPLE ]
    Here's a sample script that explains how to initialize plugins and/or components: This category should NOT be included in your project.


    Detailed information and more samples can be found in the documentation.

    ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->
        <style>
            .imageye-selected {
                outline: 2px solid black !important;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) !important;
            }

            /* Pagination container */
            .dataTables_wrapper .dataTables_paginate .paginate_button {
                background: transparent;
                color: #aaa !important;
                border: 1px solid #ddd;
                padding: 6px 12px;
                margin: 0 3px;
                border-radius: 6px;
                transition: 0.3s;
            }

            /* Hover */
            .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
                background: #00327d !important;
                color: #fff !important;
                border-color: #00327d !important;
            }

            /* Active (Halaman yang sedang dibuka) */
            .dataTables_wrapper .dataTables_paginate .paginate_button.current {
                background: #00327d !important;
                color: #fff !important;
                border-color: #00327d !important;
            }

            /* Disabled button */
            .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
                background: transparent !important;
                color: #aaa !important;
                border-color: #ddd !important;
            }

            /* Remove default shadows/border */
            .dataTables_wrapper .dataTables_paginate .paginate_button:active {
                box-shadow: none !important;
            }

            .select2-container--default .select2-selection--single {
                height: calc(1.5em + .75rem + 2px);
                display: flex;
                align-items: center;
            }

            .select2-container .select2-selection--single {
                height: calc(1.5em + .75rem + 2px);
                padding: .375rem .75rem;
                border: 1px solid rgba(var(--bs-info-rgb));
                border-radius: .375rem;
                background-color: rgba(var(--bs-primary-rgb));
            }

            .select2-container--default .select2-selection--single .select2-selection__rendered {
                line-height: calc(1.5em + .75rem);
                color: rgba(var(--bs-light-rgb));
            }

            .select2-container--default .select2-selection--single .select2-selection__arrow {
                height: 100%;
            }
        </style>

        <script src="{{ env('JQUERY_LINK') }}/jquery-3.7.1.min.js"></script>
    </head>

    <body class="jumping {{ request()->is('dashboard') ? 'centered-layout' : '' }}">

        <!-- PAGE CONTAINER -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div id="root"
            class="root hd--expanded {{ request()->is('dashboard') ? 'mn--slide' : 'mn--min' }} mn--sticky {{ request()->is('pengenaan-sp/create') ? '' : 'hd--sticky' }}">

            <!-- CONTENTS -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <section id="content" class="content">
                <div
                    class="content__header content__boxed {{ request()->is('dashboard') ? 'rounded-0' : 'overlapping' }}">
                    <div class="content__wrap">

                        <!-- Page title and information -->
                        <h1 class="page-title mb-2">{{ $title }}</h1>
                        <h2 class="h5">{{ $title }}</h2>

                        <!-- END : Page title and information -->

                    </div>

                </div>

                @yield('content')

                {{-- Alert Success --}}
                @if (session('success'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                        <div id="toastSuccess" class="toast align-items-center text-white bg-success border-0"
                            role="alert">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('success') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast"></button>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Alert Error --}}
                @if (session('error'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                        <div id="toastDanger" class="toast align-items-center text-white bg-danger border-0"
                            role="alert">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('error') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast"></button>
                            </div>
                        </div>
                    </div>
                @endif

                @if (session('info'))
                    <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                        <div id="toastInfo" class="toast align-items-center text-white bg-info border-0" role="alert">
                            <div class="d-flex">
                                <div class="toast-body">
                                    {{ session('info') }}
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                    data-bs-dismiss="toast"></button>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="position-fixed top-0 end-0 p-3" style="z-index: 1055;">
                    <div id="toastAjax" class="toast align-items-center text-white bg-success border-0" role="alert">
                        <div class="d-flex">
                            <div class="toast-body" id="toastAjaxMessage">
                                <!-- pesan AJAX -->
                            </div>
                            <button type="button" class="btn-close btn-close-white me-2 m-auto"
                                data-bs-dismiss="toast"></button>
                        </div>
                    </div>
                </div>

                <!-- FOOTER -->
                <footer class="content__boxed mt-auto">
                    <div class="content__wrap py-3 py-md-1 d-flex flex-column flex-md-row align-items-md-center">
                        <div class="text-nowrap mb-4 mb-md-0">Copyright © 2022 <a href="#"
                                class="ms-1 btn-link fw-bold">My Company</a></div>
                        <nav class="nav flex-column gap-1 flex-md-row gap-md-3 ms-md-auto"
                            style="row-gap: 0 !important;">
                            <a class="nav-link px-0" href="#">Policy Privacy</a>
                            <a class="nav-link px-0" href="#">Terms and conditions</a>
                            <a class="nav-link px-0" href="#">Contact Us</a>
                        </nav>
                    </div>
                </footer>
                <!-- END - FOOTER -->

            </section>

            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - CONTENTS -->

            <!-- HEADER -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <header class="header">
                <div class="header__inner">
                    <!-- Brand -->
                    <div class="header__brand">
                        <div class="brand-wrap">
                            <!-- Brand logo -->
                            <a href="#" class="brand-img stretched-link">
                                <img src="/img/kemendag-bappebti-logo.svg" alt="Bappebti Logo" class="rounded-4"
                                    width="40" height="40">
                            </a>
                            <!-- Brand title -->
                            <div class="brand-title">SiOMeS</div>
                            <!-- You can also use IMG or SVG instead of a text element. -->
                        </div>
                    </div>
                    <!-- End - Brand -->

                    <div class="header__content">

                        <!-- Content Header - Left Side: -->
                        <div class="header__content-start">

                            <!-- Navigation Toggler -->
                            <button type="button" class="nav-toggler header__btn btn btn-icon btn-sm"
                                aria-label="Nav Toggler">
                                <i class="psi-list-view"></i>
                            </button>

                            <!-- Searchbox -->
                            {{-- <div class="header-searchbox">

                                <!-- Searchbox toggler for small devices -->
                                <label for="header-search-input"
                                    class="header__btn d-md-none btn btn-icon rounded-pill shadow-none border-0 btn-sm"
                                    type="button">
                                    <i class="demo-psi-magnifi-glass"></i>
                                </label>

                                <!-- Searchbox input -->
                                <form class="searchbox searchbox--auto-expand searchbox--hide-btn input-group">
                                    <input id="header-search-input" class="searchbox__input form-control bg-transparent"
                                        type="search" placeholder="Type for search . . ." aria-label="Search">
                                    <div class="searchbox__backdrop">
                                        <button
                                            class="searchbox__btn header__btn btn btn-icon rounded shadow-none border-0 btn-sm"
                                            type="button" id="button-addon2">
                                            <i class="demo-pli-magnifi-glass"></i>
                                        </button>
                                    </div>
                                </form>
                            </div> --}}
                        </div>
                        <!-- End - Content Header - Left Side -->

                        <!-- Content Header - Right Side: -->
                        {{-- <div class="header__content-end">

                            <!-- Mega Dropdown -->
                            <div class="dropdown">

                                <!-- Toggler -->
                                <button class="header__btn btn btn-icon btn-sm" type="button" data-bs-toggle="dropdown"
                                    data-bs-auto-close="outside" aria-label="Megamenu dropdown" aria-expanded="false">
                                    <i class="demo-psi-layout-grid"></i>
                                </button>

                                <!-- Mega Dropdown Menu -->
                                <div class="dropdown-menu dropdown-menu-end p-3 mega-dropdown">
                                    <div class="row">
                                        <div class="col-md-3">

                                            <!-- Pages List Group -->
                                            <div class="list-group list-group-borderless">
                                                <div
                                                    class="list-group-item d-flex align-items-center border-bottom mb-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <i class="demo-pli-file fs-4"></i>
                                                    </div>
                                                    <h5 class="flex-grow-1 m-0">Pages</h5>
                                                </div>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">Profile</a>
                                                <a href="#" class="list-group-item list-group-item-action">Search
                                                    Result</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">FAQ</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">Screen Lock</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">Maintenance</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">Invoices</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action disabled"
                                                    tabindex="-1" aria-disabled="true">Disabled Item</a>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <!-- Mailbox list group -->
                                            <div class="list-group list-group-borderless mb-3">
                                                <div
                                                    class="list-group-item d-flex align-items-center border-bottom mb-2">
                                                    <div class="flex-shrink-0 me-2">
                                                        <i class="demo-pli-mail fs-4"></i>
                                                    </div>
                                                    <h5 class="flex-grow-1 m-0">Mailbox</h5>
                                                </div>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    Inbox <span class="badge bg-danger rounded-pill">14</span>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">Read
                                                    Messages</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">Compose</a>
                                                <a href="#"
                                                    class="list-group-item list-group-item-action">Template</a>
                                            </div>

                                            <!-- News -->
                                            <div class="list-group list-group-borderless">
                                                <div class="list-group-item d-flex align-items-center border-bottom">
                                                    <div class="flex-shrink-0 me-2">
                                                        <i class="demo-pli-calendar-4 fs-4"></i>
                                                    </div>
                                                    <h5 class="flex-grow-1 m-0">News</h5>
                                                </div>
                                                <small class="list-group-item">
                                                    Lorem ipsum dolor sit amet, consectetur adipisicing elit. Hic dolore
                                                    unde autem, molestiae eum laborum aliquid at commodi cum?
                                                    Blanditiis.
                                                </small>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <!-- List Group -->
                                            <div class="list-group list-group-borderless">
                                                <div
                                                    class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="demo-pli-data-settings fs-2"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ">
                                                        <div class="d-flex justify-content-between align-items-start">
                                                            <a href="#"
                                                                class="h6 d-block mb-1 stretched-link text-decoration-none">Data
                                                                Backup</a>
                                                            <span
                                                                class="badge bg-success rounded-pill ms-auto">40%</span>
                                                        </div>
                                                        <small class="text-muted">Current usage of disks for
                                                            backups.</small>
                                                    </div>
                                                </div>

                                                <div
                                                    class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="demo-pli-support fs-2"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ">
                                                        <a href="#"
                                                            class="h6 d-block mb-1 stretched-link text-decoration-none">Support</a>
                                                        <small class="text-muted">Have any questions ? please don't
                                                            hesitate to ask.</small>
                                                    </div>
                                                </div>

                                                <div
                                                    class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="demo-pli-computer-secure fs-2"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ">
                                                        <a href="#"
                                                            class="h6 d-block mb-1 stretched-link text-decoration-none">Security</a>
                                                        <small class="text-muted">Our devices are secure and
                                                            up-to-date.</small>
                                                    </div>
                                                </div>

                                                <div
                                                    class="list-group-item list-group-item-action d-flex align-items-start">
                                                    <div class="flex-shrink-0 me-3">
                                                        <i class="demo-pli-map-2 fs-2"></i>
                                                    </div>
                                                    <div class="flex-grow-1 ">
                                                        <a href="#"
                                                            class="h6 d-block mb-1 stretched-link text-decoration-none">Location</a>
                                                        <small class="text-muted">From our location up here, we kept in
                                                            close touch.</small>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-3">

                                            <!-- Simple gallery -->
                                            <div class="d-grid gap-2 ps-5 pe-2">
                                                <div class="row g-1 rounded-3 overflow-hidden">
                                                    <div class="col-6 mt-0">
                                                        <img class="img-fluid" src="./assets/img/megamenu/img-1.jpg"
                                                            alt="thumbnails" loading="lazy">
                                                    </div>
                                                    <div class="col-6 mt-0">
                                                        <img class="img-fluid" src="./assets/img/megamenu/img-3.jpg"
                                                            alt="thumbnails" loading="lazy">
                                                    </div>
                                                    <div class="col-6">
                                                        <img class="img-fluid" src="./assets/img/megamenu/img-2.jpg"
                                                            alt="thumbnails" loading="lazy">
                                                    </div>
                                                    <div class="col-6">
                                                        <img class="img-fluid" src="./assets/img/megamenu/img-4.jpg"
                                                            alt="thumbnails" loading="lazy">
                                                    </div>
                                                    <div class="col-6">
                                                        <img class="img-fluid" src="./assets/img/megamenu/img-6.jpg"
                                                            alt="thumbnails" loading="lazy">
                                                    </div>
                                                    <div class="col-6">
                                                        <img class="img-fluid" src="./assets/img/megamenu/img-5.jpg"
                                                            alt="thumbnails" loading="lazy">
                                                    </div>
                                                </div>
                                                <a href="#" class="btn btn-primary">Browse Gallery</a>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- End - Mega Dropdown -->

                            <!-- Notification Dropdown -->
                            <div class="dropdown">

                                <!-- Toggler -->
                                <button class="header__btn btn btn-icon btn-sm" type="button"
                                    data-bs-toggle="dropdown" aria-label="Notification dropdown"
                                    aria-expanded="false">
                                    <span class="d-block position-relative">
                                        <i class="demo-psi-bell"></i>
                                        <span class="badge badge-super rounded bg-danger p-1">

                                            <span class="visually-hidden">unread messages</span>
                                        </span>
                                    </span>
                                </button>

                                <!-- Notification dropdown menu -->
                                <div class="dropdown-menu dropdown-menu-end w-md-300px">
                                    <div class="border-bottom px-3 py-2 mb-3">
                                        <h5>Notifications</h5>
                                    </div>

                                    <div class="list-group list-group-borderless">

                                        <!-- List item -->
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-psi-data-settings text-muted fs-2"></i>
                                            </div>
                                            <div class="flex-grow-1 ">
                                                <a href="#"
                                                    class="h6 d-block mb-0 stretched-link text-decoration-none">Your
                                                    storage is full</a>
                                                <small class="text-muted">Local storage is nearly full.</small>
                                            </div>
                                        </div>

                                        <!-- List item -->
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-psi-file-edit text-blue-200 fs-2"></i>
                                            </div>
                                            <div class="flex-grow-1 ">
                                                <a href="#"
                                                    class="h6 d-block mb-0 stretched-link text-decoration-none">Writing
                                                    a New Article</a>
                                                <small class="text-muted">Wrote a news article for the John
                                                    Mike</small>
                                            </div>
                                        </div>

                                        <!-- List item -->
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <i class="demo-psi-speech-bubble-7 text-green-300 fs-2"></i>
                                            </div>
                                            <div class="flex-grow-1 ">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <a href="#"
                                                        class="h6 mb-0 stretched-link text-decoration-none">Comment
                                                        sorting</a>
                                                    <span class="badge bg-info rounded ms-auto">NEW</span>
                                                </div>
                                                <small class="text-muted">You have 1,256 unsorted comments.</small>
                                            </div>
                                        </div>

                                        <!-- List item -->
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <img class="img-xs rounded-circle"
                                                    src="./assets/img/profile-photos/7.png" alt="Profile Picture"
                                                    loading="lazy">
                                            </div>
                                            <div class="flex-grow-1 ">
                                                <a href="#"
                                                    class="h6 d-block mb-0 stretched-link text-decoration-none">Lucy
                                                    Sent you a message</a>
                                                <small class="text-muted">30 minutes ago</small>
                                            </div>
                                        </div>

                                        <!-- List item -->
                                        <div
                                            class="list-group-item list-group-item-action d-flex align-items-start mb-3">
                                            <div class="flex-shrink-0 me-3">
                                                <img class="img-xs rounded-circle"
                                                    src="./assets/img/profile-photos/3.png" alt="Profile Picture"
                                                    loading="lazy">
                                            </div>
                                            <div class="flex-grow-1 ">
                                                <a href="#"
                                                    class="h6 d-block mb-0 stretched-link text-decoration-none">Jackson
                                                    Sent you a message</a>
                                                <small class="text-muted">1 hours ago</small>
                                            </div>
                                        </div>

                                        <div class="text-center mb-2">
                                            <a href="#" class="btn-link">Show all Notifications</a>
                                        </div>

                                    </div>
                                </div>
                            </div>
                            <!-- End - Notification dropdown -->

                            <!-- User dropdown -->
                            <div class="dropdown">

                                <!-- Toggler -->
                                <button class="header__btn btn btn-icon btn-sm" type="button"
                                    data-bs-toggle="dropdown" aria-label="User dropdown" aria-expanded="false">
                                    <i class="demo-psi-male"></i>
                                </button>

                                <!-- User dropdown menu -->
                                <div class="dropdown-menu dropdown-menu-end w-md-450px">

                                    <!-- User dropdown header -->
                                    <div class="d-flex align-items-center border-bottom px-3 py-2">
                                        <div class="flex-shrink-0">
                                            <img class="img-sm rounded-circle" src="./assets/img/profile-photos/1.png"
                                                alt="Profile Picture" loading="lazy">
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h5 class="mb-0">Aaron Chavez</h5>
                                            <span class="text-muted fst-italic">aaron_chavez@example.com</span>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-7">

                                            <!-- Simple widget and reports -->
                                            <div class="list-group list-group-borderless mb-3">
                                                <div class="list-group-item text-center border-bottom mb-3">
                                                    <p class="h1 display-1 text-green">17</p>
                                                    <p class="h6 mb-0"><i class="demo-pli-basket-coins fs-3 me-2"></i>
                                                        New orders</p>
                                                    <small class="text-muted">You have new orders</small>
                                                </div>
                                                <div
                                                    class="list-group-item py-0 d-flex justify-content-between align-items-center">
                                                    Today Earning
                                                    <small class="fw-bolder">$578</small>
                                                </div>
                                                <div
                                                    class="list-group-item py-0 d-flex justify-content-between align-items-center">
                                                    Tax
                                                    <small class="fw-bolder text-danger">- $28</small>
                                                </div>
                                                <div
                                                    class="list-group-item py-0 d-flex justify-content-between align-items-center">
                                                    Total Earning
                                                    <span class="fw-bold text-primary">$6,578</span>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col-md-5">

                                            <!-- User menu link -->
                                            <div class="list-group list-group-borderless h-100 py-3">
                                                <a href="#"
                                                    class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                                    <span><i class="demo-pli-mail fs-5 me-2"></i> Messages</span>
                                                    <span class="badge bg-danger rounded-pill">14</span>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <i class="demo-pli-male fs-5 me-2"></i> Profile
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <i class="demo-pli-gear fs-5 me-2"></i> Settings
                                                </a>

                                                <a href="#"
                                                    class="list-group-item list-group-item-action mt-auto">
                                                    <i class="demo-pli-computer-secure fs-5 me-2"></i> Lock screen
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action">
                                                    <i class="demo-pli-unlock fs-5 me-2"></i> Logout
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- End - User dropdown -->

                            <!-- Sidebar Toggler -->
                            <button class="sidebar-toggler header__btn btn btn-icon btn-sm" type="button"
                                aria-label="Sidebar button">
                                <i class="demo-psi-dot-vertical"></i>
                            </button>

                        </div> --}}
                    </div>
                </div>
            </header>
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - HEADER -->

            <!-- MAIN NAVIGATION -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            @include('layouts.nav')
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - MAIN NAVIGATION -->

        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - PAGE CONTAINER -->

        <!-- SCROLL TO TOP BUTTON -->
        <div class="scroll-container">
            <a href="#root" class="scroll-page rounded-circle ratio ratio-1x1" aria-label="Scroll button"></a>
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - SCROLL TO TOP BUTTON -->

        <!-- JAVASCRIPTS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->

        <!-- Popper JS [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/vendors/popperjs/popper.min.js" defer=""></script>

        <!-- Bootstrap JS [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/vendors/bootstrap/bootstrap.min.js" defer=""></script>

        <!-- Nifty JS [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/js/nifty.js" defer=""></script>

        <!-- Nifty Settings [ DEMO ] -->
        <script src="{{ env('THM_LINK') }}/assets/js/demo-purpose-only.js" defer=""></script>

        <!-- Chart JS Scripts [ OPTIONAL ] -->
        <script src="{{ env('THM_LINK') }}/assets/vendors/chart.js/chart.min.js" defer=""></script>

        <!-- Initialize [ SAMPLE ] -->
        <script src="/chart.js" defer=""></script>

        <script src="{{ env('DTABLES_LINK') }}/js/jquery.dataTables.min.js"></script>

        <!-- Select2 JS -->
        <script src="{{ env('SELECT2_LINK') }}/dist/js/select2.min.js"></script>

        <script defer=""
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon="{&quot;version&quot;:&quot;2024.11.0&quot;,&quot;token&quot;:&quot;281c8ce144eb4533a36e841b30b677c5&quot;,&quot;r&quot;:1,&quot;server_timing&quot;:{&quot;name&quot;:{&quot;cfCacheStatus&quot;:true,&quot;cfEdge&quot;:true,&quot;cfExtPri&quot;:true,&quot;cfL4&quot;:true,&quot;cfOrigin&quot;:true,&quot;cfSpeedBrain&quot;:true},&quot;location_startswith&quot;:null}}"
            crossorigin="anonymous"></script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                new DataTable("#dataTables", {
                    dom: '<"row mb-3 justify-content-between"<"col-md-6 d-flex align-items-center gap-2"lB><"col-md-6"f>>rt<"row mt-3"<"col-md-6"i><"col-md-6"p>>',
                    buttons: [{
                            extend: 'excelHtml5',
                            title: 'Data Auditor',
                            className: 'btn btn-sm btn-success',
                            text: '<i class="psi-file-excel"></i> Excel'
                        },
                        {
                            extend: 'pdfHtml5',
                            title: 'Data Auditor',
                            orientation: 'landscape',
                            pageSize: 'A4',
                            className: 'btn btn-sm btn-danger',
                            text: '<i class="psi-file"></i> PDF'
                        },
                        {
                            extend: 'print',
                            title: 'Data Auditor',
                            className: 'btn btn-sm btn-info',
                            text: '<i class="psi-printer"></i> Print'
                        }
                    ],
                    lengthMenu: [
                        [5, 10, 25, 50, 100],
                        [5, 10, 25, 50, 100]
                    ], // Jumlah opsi untuk menampilkan data
                    pageLength: 5, // Tampilkan 5 data per halaman
                    ordering: true, // Aktifkan fitur sorting
                    searching: true, // Aktifkan fitur pencarian
                    language: {
                        lengthMenu: "Tampilkan _MENU_ data per halaman",
                        zeroRecords: "Tidak ada data ditemukan",
                        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                        infoEmpty: "Tidak ada data tersedia",
                        infoFiltered: "(difilter dari total _MAX_ data)",
                        search: "Cari:",
                        paginate: {
                            next: "<i class='psi-arrow-right'></i>",
                            previous: "<i class='psi-arrow-left'></i>"
                        }
                    },
                });
            });
        </script>

        <script>
            document.addEventListener("DOMContentLoaded", function() {
                @if (session('success') || request('updated'))
                    var toastElement = document.getElementById('toastSuccess');
                    var toast = new bootstrap.Toast(toastElement, {
                        delay: 3000
                    });
                    toast.show();
                @endif
                @if (session('error'))
                    var toastElement = document.getElementById('toastDanger');
                    var toast = new bootstrap.Toast(toastElement, {
                        delay: 3000
                    });
                    toast.show();
                @endif
                @if (session('info'))
                    var toastElement = document.getElementById('toastInfo');
                    var toast = new bootstrap.Toast(toastElement, {
                        delay: 3000
                    });
                    toast.show();
                @endif
            });

            function showAjaxToast(message) {
                $("#toastAjaxMessage").text(message);
                var toastEl = document.getElementById('toastAjax');
                var toast = new bootstrap.Toast(toastEl, {
                    delay: 2500
                });
                toast.show();
            }

            // Aktifkan Select2            
            $('.select2').select2({
                theme: 'default',
                width: '100%'
            });
        </script>
    </body>

</html>
