<!DOCTYPE html>
<html lang="en">

    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1">
        <meta name="description"
            content="a temporary placeholder for times when a site or app needs to be taken offline for updates, backups or maintenance.">
        <title>Maintenance | {{ config('assets.app-name') }}</title>

        <!-- STYLESHEETS -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~--- -->

        <!-- Fonts [ OPTIONAL ] -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin="">
        <link
            href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;700&amp;family=Ubuntu:wght@400;500;700&amp;display=swap"
            rel="stylesheet">

        <!-- Bootstrap CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ config('assets.theme') }}/assets/css/bootstrap.min.css">

        <!-- Nifty CSS [ REQUIRED ] -->
        <link rel="stylesheet" href="{{ config('assets.theme') }}/assets/css/nifty.min.css">

        <!-- Nifty Demo Icons [ OPTIONAL ] -->
        <link rel="stylesheet" href="{{ config('assets.theme') }}/assets/css/demo-purpose/demo-icons.min.css">

        <!-- Demo purpose CSS [ DEMO ] -->
        <link rel="stylesheet" href="{{ config('assets.theme') }}/assets/css/demo-purpose/demo-settings.min.css">

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
    </head>

    <body class="">

        <!-- PAGE CONTAINER -->
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <div id="root" class="root front-container">

            <!-- CONTENTS -->
            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <section id="content" class="content bg-dark">
                <div
                    class="content__boxed w-100 min-vh-100 d-flex flex-column align-items-stretch justify-content-center">
                    <div class="content__wrap">

                        <div class="text-center">
                            <div class="mb-4">
                                <i class="demo-psi-gears error-code text-gray-600"></i>
                            </div>
                            <h3 class="mb-5">
                                <div class="badge bg-secondary">Website Under Maintenance...</div>
                            </h3>
                            <p class="lead text-white">Sistem sedang ada pemeliharaan. <br> Mohon maaf, layanan sedang
                                diperbarui. Silahkan coba kembali nanti. 🙏😌</p>
                        </div>

                    </div>
                </div>
            </section>

            <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
            <!-- END - CONTENTS -->
        </div>
        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
        <!-- END - PAGE CONTAINER -->

        <script defer=""
            src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
            integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
            data-cf-beacon="{&quot;version&quot;:&quot;2024.11.0&quot;,&quot;token&quot;:&quot;281c8ce144eb4533a36e841b30b677c5&quot;,&quot;r&quot;:1,&quot;server_timing&quot;:{&quot;name&quot;:{&quot;cfCacheStatus&quot;:true,&quot;cfEdge&quot;:true,&quot;cfExtPri&quot;:true,&quot;cfL4&quot;:true,&quot;cfOrigin&quot;:true,&quot;cfSpeedBrain&quot;:true},&quot;location_startswith&quot;:null}}"
            crossorigin="anonymous"></script>


    </body>

</html>
