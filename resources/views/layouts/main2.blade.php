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


</div>
@stack('js')



@include('layouts.footer')

