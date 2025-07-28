@include('layouts.header')
<body class="hold-transition sidebar-collapse layout-top-nav">
<div class="wrapper">

@include('layouts.navbar')

<!-- Main Sidebar Container -->
@include('layouts.sidebar')
<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container">
                <div class="row mb-2">
                    <div class="col-sm-12">
                        {{ Breadcrumbs::render() }}
                    </div><!-- /.col -->
                    {{--                    <div class="col-sm-6">--}}

                    {{--                    </div><!-- /.col -->--}}
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">
            {{$slot}}
        </div>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
        <div class="p-3">
            <h5>Title</h5>
            <p>Sidebar content</p>
        </div>
    </aside>
    <!-- /.control-sidebar -->

    <!-- Main Footer -->
    <footer class="main-footer">
        <!-- To the right -->
        <div class="float-right d-none d-sm-inline">
{{--            Anything you want--}}
        </div>
        <!-- Default to the left -->
        <strong>Copyright &copy; <?php echo date('Y'); ?> <a href="https://adminlte.io">ZESCO LTD</a>.</strong> All rights reserved.
    </footer>
</div>
@stack('js')



@include('layouts.footer')

