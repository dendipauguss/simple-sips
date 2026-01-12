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
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/css/color-schemes/all-headers/night/bootstrap.min.css">

        <!-- Nifty CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/all-headers/night/nifty.min.css">

        <!-- Nifty Color Schemes -->
        <link rel="stylesheet" href="{{ env('THM_LINK') }}/assets/css/color-schemes/dark/nifty.min.css">

        <!-- Nifty Premium Line Icons [ OPTIONAL ] -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/premium/icon-sets/icons/line-icons/premium-line-icons.min.css">

        <!-- Nifty Premium Solid Icons -->
        <link rel="stylesheet"
            href="{{ env('THM_LINK') }}/assets/premium/icon-sets/icons/solid-icons/premium-solid-icons.min.css">

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
        </style>

        <script src="{{ env('JQUERY_LINK') }}/jquery-3.7.1.min.js"></script>
    </head>

    <body class="jumping">

        <!-- PAGE CONTAINER -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div id="root" class="root front-container">

            <!-- CONTENTS -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <section id="content" class="content">
                <div
                    class="content__boxed w-100 min-vh-100 d-flex flex-column align-items-center justify-content-center">
                    <div class="content__wrap">
                        <!-- Login card -->
                        <div class="card shadow-lg">
                            <div class="card-body">

                                <div class="text-center">
                                    <h1 class="h3">Masuk</h1>
                                </div>

                                <form class="mt-4" action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <input type="text"
                                            class="form-control @error('username_or_email') is-invalid @enderror"
                                            placeholder="Username or Email" name="username_or_email" autofocus=""
                                            id="username_or_email">
                                        @error('username_or_email')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group has-validation">
                                            <input type="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Password" name="password" id="password">
                                            <button type="button" id="togglePassword" class="input-group-text">
                                                <i class="psi-eye-visible"></i>
                                            </button>
                                            @error('password')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="d-grid mt-5">
                                        <button class="btn btn-primary btn-lg" type="submit">Sign In</button>
                                    </div>
                                </form>

                                {{-- <div class="d-flex justify-content-between mt-4">
                                    <a href="./front-pages-password-reminder.html"
                                        class="btn-link text-decoration-none">Forgot password ?</a>
                                    <a href="./front-pages-register.html" class="btn-link text-decoration-none">Create a
                                        new account</a>
                                </div>

                                <div class="d-flex align-items-center justify-content-between border-top pt-3 mt-3">
                                    <h5 class="m-0">Login with</h5>

                                    <!-- Social media buttons -->
                                    <div class="ms-3">
                                        <a href="#"
                                            class="btn btn-sm btn-icon btn-hover btn-primary text-inherit">
                                            <i class="demo-psi-facebook fs-5"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-icon btn-hover btn-info text-inherit">
                                            <i class="demo-psi-twitter fs-5"></i>
                                        </a>
                                        <a href="#" class="btn btn-sm btn-icon btn-hover btn-danger text-inherit">
                                            <i class="demo-psi-google-plus fs-5"></i>
                                        </a>
                                        <a href="#"
                                            class="btn btn-sm btn-icon btn-hover btn-warning text-inherit">
                                            <i class="demo-psi-instagram fs-5"></i>
                                        </a>
                                    </div>
                                    <!-- END : Social media buttons -->

                                </div> --}}

                            </div>
                        </div>
                        <!-- END : Login card -->


                    </div>
                </div>
            </section>

            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - CONTENTS -->
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - PAGE CONTAINER -->

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

        <script defer=""
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon="{&quot;version&quot;:&quot;2024.11.0&quot;,&quot;token&quot;:&quot;281c8ce144eb4533a36e841b30b677c5&quot;,&quot;r&quot;:1,&quot;server_timing&quot;:{&quot;name&quot;:{&quot;cfCacheStatus&quot;:true,&quot;cfEdge&quot;:true,&quot;cfExtPri&quot;:true,&quot;cfL4&quot;:true,&quot;cfOrigin&quot;:true,&quot;cfSpeedBrain&quot;:true},&quot;location_startswith&quot;:null}}"
            crossorigin="anonymous"></script>

        <script>
            $('#togglePassword').on('click', function() {
                const pass = $('#password');

                // Ganti type
                const type = pass.attr('type') === 'password' ? 'text' : 'password';
                pass.attr('type', type);

                // Ganti icon (optional)
                $(this).html(type === 'password' ? '<i class="psi-eye-visible"></i>' :
                    '<i class="psi-eye-invisible"></i>');
            });
        </script>
    </body>

</html>
