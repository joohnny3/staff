<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Staff Repo</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

    @include('components.navbar')

    @yield('content')

    @yield('script')

    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
    {{-- <script src="{{ asset('js/index.js') }}"></script> --}}

    <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/plugins/jquery-mousewheel/jquery.mousewheel.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/plugins/raphael/raphael.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/plugins/jquery-mapael/jquery.mapael.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/plugins/jquery-mapael/maps/usa_states.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/dist/js/demo.js') }}"></script> --}}
    {{-- <script src="{{ asset('adminlte/dist/js/pages/dashboard2.js') }}"></script> --}}
</body>

</html>
