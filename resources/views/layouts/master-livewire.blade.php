<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    {{--    <link rel="icon" type="image/png')}}" href="{{ asset('assets/img/favicon.ico')}}"> --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    {{--    <meta http-equiv="refresh" content="{{ config('session.lifetime') * 60 }}"> --}}
    {{--    <meta name="_token" content="{!! csrf_token() !!}" /> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{--    <meta name="csrf-token" content="{{ csrf_token() }}"> --}}

    <title>{{ config('app.name') }}</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
          href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="{{ asset('assets/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/select2-bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/css/parsley.css') }}" rel="stylesheet" />

    <link href="{{ asset('plugins/datatables-buttons/css/buttons.dataTables.min.css') }}" rel="stylesheet" />
    {{--    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet"> --}}
    {{--    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet"> --}}
    {{--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> --}}

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Styles -->
    <style>
        body {
            font-family: 'Nunito', sans-serif;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr" defer></script>

    <script crossorigin src="https://unpkg.com/react@17/umd/react.production.min.js"></script>
    <script crossorigin src="https://unpkg.com/react-dom@17/umd/react-dom.production.min.js"></script>

    @livewireStyles
</head>

<body class="hold-transition sidebar-mini layout-fixed  {{ Auth::user()->hasRole('agent')?"sidebar-collapse":"" }}" id="agent-body">
<div class="wrapper">

    {{-- NAV BAR --}}
    @include('layouts.navbar')
    {{-- NAV BAR --}}

    {{-- SIDE BAR --}}
    @include('layouts.sidebar')
    {{-- SIDE BAR --}}

    {{-- MAIN CONTENT --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
{{--            <div class="container-fluid">--}}
{{--                <div class="row mb-2">--}}
{{--                    <div class="col-sm-6">--}}
{{--                        <h4>{{ Breadcrumbs::render() }}</h4>--}}
{{--                    </div>--}}
{{--                    <div class="col-sm-6">--}}
{{--                        <ol class="breadcrumb float-sm-right">--}}
{{--                            --}}{{--                            <li class="breadcrumb-item"><a href="#">Home</a></li> --}}
{{--                            --}}{{--                            <li class="breadcrumb-item active">Simple Tables</li> --}}
{{--                        </ol>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div><!-- /.container-fluid -->--}}
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{ $slot }}
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    {{-- MAIN CONTENT --}}


    {{-- FOOTER --}}
    @include('layouts.footer')
    {{-- FOOTER --}}

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<script src="https://code.highcharts.com/modules/variable-pie.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<!-- jQuery -->
{{-- <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
{{--
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
--}}

<script src="{{ asset('assets/js/parsley.js') }}" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>


<!-- jQuery UI 1.11.4 -->
<script src=" {{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/select2.min.js') }}" type="text/javascript"></script> --}}
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>

<script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
{{-- <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script> --}}
<!-- JQVMap -->
<script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<!-- ChartJS -->
<script src="{{ asset('bower_components/chart.js/Chart.js') }}"></script>
<!-- ChartJS -->
<!-- FastClick -->
<script src="{{ asset('bower_components/fastclick/lib/fastclick.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
{{-- <script src="{{ asset('dist/js/pages/dashboard.js') }}"></script> --}}
<!-- AdminLTE for demo purposes -->
{{-- <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> --}}
{{-- <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script> --}}
<script src="{{ asset('dist/js/demo.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>

<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

@livewireScripts
@stack('custom-scripts')

{{-- <script src="//unpkg.com/alpinejs" defer></script> --}}
{{-- <script>
    window.addEventListener('showAlert', event => {
        alert(event.detail.message);
    })
</script> --}}
</body>

</html>
