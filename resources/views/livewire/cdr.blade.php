<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />



    <meta name="csrf-token" content="AubtkQCduHGrxB9ppBqSbLM1yozwUSTSPQhkh3Co">



    <title>CCIVR Dashboars</title>

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="http://127.0.0.1:8000/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="http://127.0.0.1:8000/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    <link href="http://127.0.0.1:8000/assets/css/select2.min.css" rel="stylesheet" />
    <link href="http://127.0.0.1:8000/assets/css/select2-bootstrap4.min.css" rel="stylesheet" />
    <link href="http://127.0.0.1:8000/assets/css/parsley.css" rel="stylesheet" />

    <link href="http://127.0.0.1:8000/plugins/datatables-buttons/css/buttons.dataTables.min.css" rel="stylesheet" />




    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.css" />

    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    <!-- Livewire Styles -->
    <style>
        [wire\:loading],
        [wire\:loading\.delay],
        [wire\:loading\.inline-block],
        [wire\:loading\.inline],
        [wire\:loading\.block],
        [wire\:loading\.flex],
        [wire\:loading\.table],
        [wire\:loading\.grid],
        [wire\:loading\.inline-flex] {
            display: none;
        }

        [wire\:loading\.delay\.shortest],
        [wire\:loading\.delay\.shorter],
        [wire\:loading\.delay\.short],
        [wire\:loading\.delay\.long],
        [wire\:loading\.delay\.longer],
        [wire\:loading\.delay\.longest] {
            display: none;
        }

        [wire\:offline] {
            display: none;
        }

        [wire\:dirty]:not(textarea):not(input):not(select) {
            display: none;
        }

        input:-webkit-autofill,
        select:-webkit-autofill,
        textarea:-webkit-autofill {
            animation-duration: 50000s;
            animation-name: livewireautofill;
        }

        @keyframes livewireautofill {
            from {}
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">


        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link"><strong></strong></a>

                </li>



            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="nav-item dropdown  user-menu">
                    <a href="#" class="nav-link" data-toggle="dropdown">
                        <img src="http://127.0.0.1:8000/assets/img/faces/face-0.jpg" class="user-image"
                            alt="User Image">
                        <span class="hidden-xs">KELLY KINYAMA</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header bg-gradient-orange" style="height: auto">
                            <img src="http://127.0.0.1:8000/assets/img/faces/face-0.jpg" class="img-circle"
                                alt="User Image">

                            <p>
                                KELLY KINYAMA
                                <br> Developer
                            </p>
                        </li>
                        <!-- Menu Body -->
                        <!-- Menu Footer-->
                        <li class="card-footer">




                            <a href="http://127.0.0.1:8000/logout" class="btn btn-default btn-flat float-right"
                                onclick="event.preventDefault();  document.getElementById('logout-form').submit();">
                                Logout
                            </a>
                            <form id="logout-form" action="http://127.0.0.1:8000/logout" method="POST" class="d-none">
                                <input type="hidden" name="_token" value="AubtkQCduHGrxB9ppBqSbLM1yozwUSTSPQhkh3Co">
                            </form>

                        </li>
                    </ul>
                </li>






            </ul>
        </nav>



        <aside class="main-sidebar sidebar-light-gray elevation-5">
            <!-- Brand Logo -->
            <a href="#" class="brand-link bg-gradient-orange">
                <img src="http://127.0.0.1:8000/assets/img/zesco_logo.png" alt="System Logo" class="brand-image"
                    style="opacity: .9">
                <span class="brand-text font-weight-light">CCIVR Dashboars</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar sidebar-background">
                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview"
                        role="menu" data-accordion="false">
                        <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->


                        <li class="nav-item" style="display: none">
                            <a href="https://adminlte.io/docs/3.0" class="nav-link">
                                <i class="nav-icon fas fa-file"></i>
                                <p>Documentation</p>

                            </a>
                        </li>

                        <li class="nav-header ">Admin</li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/reports/index" class="nav-link">
                                <i class="far fa-circle nav-icon text-green"></i>
                                <p>Admin</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/reports/call/detail/records" class="nav-link">
                                <i class="far fa-circle nav-icon text-green"></i>
                                <p>Call Details Report</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/config/destinations" class="nav-link">
                                <i class="far fa-circle nav-icon text-green"></i>
                                <p>Destinations</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/config/contexts" class="nav-link">
                                <i class="far fa-circle nav-icon text-green"></i>
                                <p>Contexts</p>
                            </a>
                        </li>


                        <li class="nav-header ">Reports</li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/reports/index" class="nav-link">
                                <i class="far fa-circle nav-icon text-green"></i>
                                <p>Main Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/reports/call/summary/records" class="nav-link">
                                <i class="far fa-circle nav-icon text-green"></i>
                                <p>Call Summary Report</p>
                            </a>
                        </li>
                        <li class="nav-header">USERS</li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8000/users/create-user" class="nav-link">
                                <i class="far fa-user nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>

                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>



        <meta name="csrf-token" content="AubtkQCduHGrxB9ppBqSbLM1yozwUSTSPQhkh3Co">

        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4>
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">

                                        <li class="breadcrumb-item active" aria-current="page">Call Detail Records
                                        </li>

                                    </ol>
                                </nav>
                            </h4>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">


                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div wire:id="58UCobKeyiZQP6b0pRLJ"
                        wire:initial-data="{&quot;fingerprint&quot;:{&quot;id&quot;:&quot;58UCobKeyiZQP6b0pRLJ&quot;,&quot;name&quot;:&quot;reports.call-detail-records&quot;,&quot;locale&quot;:&quot;en&quot;,&quot;path&quot;:&quot;reports\/call\/detail\/records&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;v&quot;:&quot;acj&quot;},&quot;effects&quot;:{&quot;listeners&quot;:[],&quot;path&quot;:&quot;http:\/\/127.0.0.1:8000\/reports\/call\/detail\/records?&quot;},&quot;serverMemo&quot;:{&quot;children&quot;:{&quot;l4141506424-0&quot;:{&quot;id&quot;:&quot;pjCZjC7RMR6V2bjh4AlY&quot;,&quot;tag&quot;:&quot;div&quot;}},&quot;errors&quot;:[],&quot;htmlHash&quot;:&quot;1c055cfc&quot;,&quot;data&quot;:{&quot;searchTerm&quot;:null,&quot;totalUsers&quot;:14,&quot;from&quot;:null,&quot;to&quot;:null,&quot;cdrRecord_id&quot;:null,&quot;cdrRecord_src&quot;:null,&quot;cdrRecord_dcontext&quot;:null,&quot;page&quot;:1,&quot;paginators&quot;:{&quot;page&quot;:1}},&quot;dataMeta&quot;:[],&quot;checksum&quot;:&quot;f9fd8a6a4f5b98c0e2993051b823fe219b3dad0686fad680f03c80e97e7fcad4&quot;}}"
                        class="row">

                        <div class="container">
                            <div class="card card-body">


                                <form wire:submit.prevent="search">
                                    <div class="row d-flex">
                                        <div class="col d-flex">
                                            <label for="from">From:</label>
                                            <input type="datetime-local" class="form-control" id="from"
                                                placeholder="Enter Date" wire:model.defer="from">
                                        </div>
                                        <div class="col d-flex">
                                            <label for="to">To:</label>
                                            <input type="datetime-local" class="form-control" id="to"
                                                placeholder="Enter Date" wire:model.defer="to">

                                        </div>

                                        <div class="col">
                                            <button type="submit" class="btn btn-success btn-block">
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm mr-4" role="status"
                                                        aria-hidden="true"></span>
                                                </div>
                                                <span class="mr-4">Search</span>
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>
                        </div>

                        <div class="container">


                            <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4">
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-3 border-info">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Total Calls Today</p>
                                                    <h4 class="my-1 text-info">1,292</h4>


                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-scooter text-white ms-auto">
                                                    <i class="fa fa-shopping-cart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-3 border-danger">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Total Calls Yesterday</p>
                                                    <h4 class="my-1 text-danger">5,381</h4>

                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-bloody text-white ms-auto">
                                                    <i class="fa fa-dollar"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-3 border-success">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Total Calls This Month</p>
                                                    <h4 class="my-1 text-success">190,069</h4>

                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-ohhappiness text-white ms-auto">
                                                    <i class="fa fa-bar-chart"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="card radius-10 border-start border-0 border-3 border-warning">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center">
                                                <div>
                                                    <p class="mb-0 text-secondary">Total Calls Year</p>
                                                    <h4 class="my-1 text-warning">521,228</h4>

                                                </div>
                                                <div
                                                    class="widgets-icons-2 rounded-circle bg-gradient-blooker text-white ms-auto">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="row ">

                                <div class="col">
                                    <div class="card">

                                        <div class="card-header">
                                            Latest 15 Calls out of 1292
                                            Calls Today
                                        </div>
                                        <div class="card-body">



                                            <div class="bg-white p-4 border border-gray-200 rounded">
                                                <div wire:id="pjCZjC7RMR6V2bjh4AlY"
                                                    wire:initial-data="{&quot;fingerprint&quot;:{&quot;id&quot;:&quot;pjCZjC7RMR6V2bjh4AlY&quot;,&quot;name&quot;:&quot;c-d-r-model&quot;,&quot;locale&quot;:&quot;en&quot;,&quot;path&quot;:&quot;reports\/call\/detail\/records&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;v&quot;:&quot;acj&quot;},&quot;effects&quot;:{&quot;listeners&quot;:[&quot;pg:datePicker-default&quot;,&quot;pg:editable-default&quot;,&quot;pg:toggleable-default&quot;,&quot;pg:multiSelect-default&quot;,&quot;pg:toggleColumn-default&quot;,&quot;pg:eventRefresh-default&quot;,&quot;pg:softDeletes-default&quot;],&quot;path&quot;:&quot;http:\/\/127.0.0.1:8000\/reports\/call\/detail\/records&quot;},&quot;serverMemo&quot;:{&quot;children&quot;:[],&quot;errors&quot;:[],&quot;htmlHash&quot;:&quot;b1e13c58&quot;,&quot;data&quot;:{&quot;headers&quot;:[],&quot;search&quot;:&quot;&quot;,&quot;columns&quot;:[{&quot;title&quot;:&quot;ID&quot;,&quot;field&quot;:&quot;id&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:false,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:false,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;number&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;ACCOUNTCODE&quot;,&quot;field&quot;:&quot;accountcode&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;SRC&quot;,&quot;field&quot;:&quot;src&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;DST&quot;,&quot;field&quot;:&quot;dst&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;DCONTEXT&quot;,&quot;field&quot;:&quot;dcontext&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;CLID&quot;,&quot;field&quot;:&quot;clid&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;CHANNEL&quot;,&quot;field&quot;:&quot;channel&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;DSTCHANNEL&quot;,&quot;field&quot;:&quot;dstchannel&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;LASTAPP&quot;,&quot;field&quot;:&quot;lastapp&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;LASTDATA&quot;,&quot;field&quot;:&quot;lastdata&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;CALLDATE&quot;,&quot;field&quot;:&quot;calldate_formatted&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;calldate&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;date_picker&quot;:{&quot;enabled&quot;:true,&quot;class&quot;:&quot;&quot;,&quot;config&quot;:[]}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;ANSWERDATE&quot;,&quot;field&quot;:&quot;answerdate_formatted&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;answerdate&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;date_picker&quot;:{&quot;enabled&quot;:true,&quot;class&quot;:&quot;&quot;,&quot;config&quot;:[]}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;HANGUPDATE&quot;,&quot;field&quot;:&quot;hangupdate_formatted&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;hangupdate&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;date_picker&quot;:{&quot;enabled&quot;:true,&quot;class&quot;:&quot;&quot;,&quot;config&quot;:[]}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;DURATION&quot;,&quot;field&quot;:&quot;duration&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:false,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:false,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;number&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;BILLSEC&quot;,&quot;field&quot;:&quot;billsec&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:false,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:false,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;number&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;DISPOSITION&quot;,&quot;field&quot;:&quot;disposition&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;AMAFLAGS&quot;,&quot;field&quot;:&quot;amaflags&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;UNIQUEID&quot;,&quot;field&quot;:&quot;uniqueid&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]},{&quot;title&quot;:&quot;USERFIELD&quot;,&quot;field&quot;:&quot;userfield&quot;,&quot;headerClass&quot;:&quot;&quot;,&quot;headerStyle&quot;:&quot;&quot;,&quot;bodyClass&quot;:&quot;&quot;,&quot;bodyStyle&quot;:&quot;&quot;,&quot;dataField&quot;:&quot;&quot;,&quot;placeholder&quot;:&quot;&quot;,&quot;hidden&quot;:false,&quot;forceHidden&quot;:false,&quot;visibleInExport&quot;:null,&quot;editable&quot;:[],&quot;searchable&quot;:true,&quot;searchableRaw&quot;:&quot;&quot;,&quot;sortable&quot;:true,&quot;sum&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;count&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;avg&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;min&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;max&quot;:{&quot;header&quot;:false,&quot;footer&quot;:false},&quot;inputs&quot;:{&quot;input_text&quot;:{&quot;enabled&quot;:true}},&quot;toggleable&quot;:[],&quot;clickToCopy&quot;:[]}],&quot;filtered&quot;:[],&quot;primaryKey&quot;:&quot;id&quot;,&quot;isCollection&quot;:false,&quot;currentTable&quot;:&quot;cdr&quot;,&quot;datasource&quot;:null,&quot;withoutPaginatedData&quot;:null,&quot;relationSearch&quot;:[],&quot;ignoreTablePrefix&quot;:true,&quot;tableName&quot;:&quot;default&quot;,&quot;headerTotalColumn&quot;:false,&quot;footerTotalColumn&quot;:false,&quot;setUp&quot;:{&quot;exportable&quot;:{&quot;name&quot;:&quot;exportable&quot;,&quot;csvSeparator&quot;:&quot;,&quot;,&quot;csvDelimiter&quot;:&quot;\&quot;&quot;,&quot;type&quot;:[&quot;excel&quot;,&quot;csv&quot;],&quot;striped&quot;:&quot;d0d3d8&quot;,&quot;columnWidth&quot;:[],&quot;deleteFileAfterSend&quot;:true,&quot;fileName&quot;:&quot;export&quot;},&quot;header&quot;:{&quot;name&quot;:&quot;header&quot;,&quot;searchInput&quot;:true,&quot;toggleColumns&quot;:false,&quot;softDeletes&quot;:false,&quot;showMessageSoftDeletes&quot;:false,&quot;includeViewOnTop&quot;:&quot;&quot;,&quot;includeViewOnBottom&quot;:&quot;&quot;},&quot;footer&quot;:{&quot;name&quot;:&quot;footer&quot;,&quot;perPage&quot;:10,&quot;perPageValues&quot;:[10,25,50,100,0],&quot;recordCount&quot;:&quot;full&quot;,&quot;pagination&quot;:null,&quot;includeViewOnTop&quot;:&quot;&quot;,&quot;includeViewOnBottom&quot;:&quot;&quot;}},&quot;inputRangeConfig&quot;:[],&quot;showErrorBag&quot;:false,&quot;softDeletes&quot;:&quot;&quot;,&quot;total&quot;:521228,&quot;totalCurrentPage&quot;:10,&quot;page&quot;:1,&quot;paginators&quot;:{&quot;page&quot;:1},&quot;exportOptions&quot;:[],&quot;sortField&quot;:&quot;id&quot;,&quot;sortDirection&quot;:&quot;asc&quot;,&quot;withSortStringNumber&quot;:false,&quot;checkbox&quot;:true,&quot;checkboxAll&quot;:false,&quot;checkboxValues&quot;:[],&quot;checkboxAttribute&quot;:&quot;id&quot;,&quot;makeFilters&quot;:{&quot;number&quot;:[{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;id&quot;,&quot;field&quot;:&quot;id&quot;,&quot;label&quot;:&quot;ID&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;duration&quot;,&quot;field&quot;:&quot;duration&quot;,&quot;label&quot;:&quot;DURATION&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;billsec&quot;,&quot;field&quot;:&quot;billsec&quot;,&quot;label&quot;:&quot;BILLSEC&quot;}],&quot;input_text&quot;:[{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;accountcode&quot;,&quot;field&quot;:&quot;accountcode&quot;,&quot;label&quot;:&quot;ACCOUNTCODE&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;src&quot;,&quot;field&quot;:&quot;src&quot;,&quot;label&quot;:&quot;SRC&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;dst&quot;,&quot;field&quot;:&quot;dst&quot;,&quot;label&quot;:&quot;DST&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;dcontext&quot;,&quot;field&quot;:&quot;dcontext&quot;,&quot;label&quot;:&quot;DCONTEXT&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;clid&quot;,&quot;field&quot;:&quot;clid&quot;,&quot;label&quot;:&quot;CLID&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;channel&quot;,&quot;field&quot;:&quot;channel&quot;,&quot;label&quot;:&quot;CHANNEL&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;dstchannel&quot;,&quot;field&quot;:&quot;dstchannel&quot;,&quot;label&quot;:&quot;DSTCHANNEL&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;lastapp&quot;,&quot;field&quot;:&quot;lastapp&quot;,&quot;label&quot;:&quot;LASTAPP&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;lastdata&quot;,&quot;field&quot;:&quot;lastdata&quot;,&quot;label&quot;:&quot;LASTDATA&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;disposition&quot;,&quot;field&quot;:&quot;disposition&quot;,&quot;label&quot;:&quot;DISPOSITION&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;amaflags&quot;,&quot;field&quot;:&quot;amaflags&quot;,&quot;label&quot;:&quot;AMAFLAGS&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;uniqueid&quot;,&quot;field&quot;:&quot;uniqueid&quot;,&quot;label&quot;:&quot;UNIQUEID&quot;},{&quot;enabled&quot;:true,&quot;dataField&quot;:&quot;userfield&quot;,&quot;field&quot;:&quot;userfield&quot;,&quot;label&quot;:&quot;USERFIELD&quot;}],&quot;date_picker&quot;:[{&quot;enabled&quot;:true,&quot;class&quot;:&quot;&quot;,&quot;config&quot;:[],&quot;dataField&quot;:&quot;calldate&quot;,&quot;field&quot;:&quot;calldate_formatted&quot;,&quot;label&quot;:&quot;CALLDATE&quot;},{&quot;enabled&quot;:true,&quot;class&quot;:&quot;&quot;,&quot;config&quot;:[],&quot;dataField&quot;:&quot;answerdate&quot;,&quot;field&quot;:&quot;answerdate_formatted&quot;,&quot;label&quot;:&quot;ANSWERDATE&quot;},{&quot;enabled&quot;:true,&quot;class&quot;:&quot;&quot;,&quot;config&quot;:[],&quot;dataField&quot;:&quot;hangupdate&quot;,&quot;field&quot;:&quot;hangupdate_formatted&quot;,&quot;label&quot;:&quot;HANGUPDATE&quot;}]},&quot;filters&quot;:[],&quot;enabledFilters&quot;:[],&quot;select&quot;:[],&quot;inputTextOptions&quot;:{&quot;contains&quot;:&quot;livewire-powergrid::datatable.input_text_options.contains&quot;,&quot;contains_not&quot;:&quot;livewire-powergrid::datatable.input_text_options.contains_not&quot;,&quot;is&quot;:&quot;livewire-powergrid::datatable.input_text_options.is&quot;,&quot;is_not&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_not&quot;,&quot;starts_with&quot;:&quot;livewire-powergrid::datatable.input_text_options.starts_with&quot;,&quot;ends_with&quot;:&quot;livewire-powergrid::datatable.input_text_options.ends_with&quot;,&quot;is_empty&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_empty&quot;,&quot;is_not_empty&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_not_empty&quot;,&quot;is_null&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_null&quot;,&quot;is_not_null&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_not_null&quot;,&quot;is_blank&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_blank&quot;,&quot;is_not_blank&quot;:&quot;livewire-powergrid::datatable.input_text_options.is_not_blank&quot;},&quot;batchExporting&quot;:false,&quot;batchFinished&quot;:false,&quot;batchId&quot;:&quot;&quot;,&quot;batchName&quot;:&quot;Powergrid batch export&quot;,&quot;onConnection&quot;:&quot;sync&quot;,&quot;onQueue&quot;:&quot;default&quot;,&quot;queues&quot;:0,&quot;showExporting&quot;:true,&quot;batchProgress&quot;:0,&quot;exportedFiles&quot;:[],&quot;exportableJobClass&quot;:&quot;PowerComponents\\LivewirePowerGrid\\Jobs\\ExportJob&quot;,&quot;batchErrors&quot;:false,&quot;persist&quot;:[],&quot;actionRoutes&quot;:[],&quot;actionHeader&quot;:[],&quot;actions&quot;:[]},&quot;dataMeta&quot;:{&quot;collections&quot;:[&quot;makeFilters&quot;]},&quot;checksum&quot;:&quot;d9b169ca1dcdd345770d7796f271cbfaca14f41a20b6770056592c372b9b751b&quot;}}"
                                                    class="flex flex-col">
                                                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                                        <div
                                                            class="py-2 align-middle inline-block min-w-full w-full sm:px-6 lg:px-8">

                                                            <div>
                                                                <div
                                                                    class="md:flex md:flex-row w-full justify-between items-center">
                                                                    <div class="md:flex md:flex-row w-full">
                                                                        <div>
                                                                            <div class="w-full md:w-auto">
                                                                                <div class="flex flex-wrap gap-2 mr-2">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="flex flex-row justify-center items-center text-sm">
                                                                            <div class="mr-2 mt-2 sm:mt-0"
                                                                                id="pg-header-export">
                                                                                <div x-data="{ open: false }"
                                                                                    @click.outside="open = false">
                                                                                    <button
                                                                                        @click.prevent="open = ! open"
                                                                                        class="block bg-slate-50 text-slate-700 border border-slate-300 rounded py-1.5 px-3 leading-tight
                   focus:outline-none focus:bg-white focus:border-slate-600 dark:border-slate-500 dark:bg-slate-700
                   2xl:dark:placeholder-slate-300 dark:text-slate-200 dark:text-slate-300">
                                                                                        <div class="flex">
                                                                                            <svg class="h-6 w-6 text-slate-500 dark:text-slate-300"
                                                                                                fill="none"
                                                                                                viewBox="0 0 24 24"
                                                                                                stroke="currentColor">
                                                                                                <path
                                                                                                    stroke-linecap="round"
                                                                                                    stroke-linejoin="round"
                                                                                                    stroke-width="2"
                                                                                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                                                            </svg>

                                                                                        </div>
                                                                                    </button>

                                                                                    <div x-show="open" x-cloak
                                                                                        x-transition:enter="transform duration-200"
                                                                                        x-transition:enter-start="opacity-0 scale-90"
                                                                                        x-transition:enter-end="opacity-100 scale-100"
                                                                                        x-transition:leave="transform duration-200"
                                                                                        x-transition:leave-start="opacity-100 scale-100"
                                                                                        x-transition:leave-end="opacity-0 scale-90"
                                                                                        class="mt-2 w-auto bg-white shadow-xl absolute z-10 dark:bg-slate-600">

                                                                                        <div
                                                                                            class="flex px-4 py-2 text-slate-400 dark:text-slate-300">
                                                                                            <span
                                                                                                class="w-12">Excel</span>
                                                                                            <a x-on:click="$wire.call('exportToXLS'); open = false"
                                                                                                href="#"
                                                                                                class="px-2 block text-slate-800 hover:bg-slate-50 hover:text-black-300 dark:text-slate-200 dark:hover:bg-slate-700 rounded">
                                                                                                All </a>
                                                                                            <a x-on:click="$wire.call('exportToXLS', true); open = false"
                                                                                                href="#"
                                                                                                class="px-2 block text-slate-800 hover:bg-slate-50 hover:text-black-300 dark:text-slate-200 dark:hover:bg-slate-700 rounded">
                                                                                                Selected </a>
                                                                                        </div>
                                                                                        <div
                                                                                            class="flex px-4 py-2 text-slate-400 dark:text-slate-300">
                                                                                            <span
                                                                                                class="w-12">Csv</span>
                                                                                            <a x-on:click="$wire.call('exportToCsv'); open = false"
                                                                                                href="#"
                                                                                                class="px-2 block text-slate-800 hover:bg-slate-50 hover:text-black-300 dark:text-slate-200 dark:hover:bg-slate-700 rounded">
                                                                                                All </a>
                                                                                            <a x-on:click="$wire.call('exportToCsv', true); open = false"
                                                                                                href="#"
                                                                                                class="px-2 block text-slate-800 hover:bg-slate-50 hover:text-black-300 dark:text-slate-200 dark:hover:bg-slate-700 rounded">
                                                                                                Selected </a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div wire:loading class="mt-2">
                                                                            <div
                                                                                class="loader ease-linear rounded-full border-2 border-t-2 border-slate-200 h-6 w-6">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div
                                                                        class="flex flex-row mt-2 md:mt-0 w-full rounded-full flex justify-start sm:justify-center md:justify-end">
                                                                        <div
                                                                            class="relative rounded-full w-full md:w-4/12 float-end float-right md:w-full lg:w-1/2">
                                                                            <span
                                                                                class="absolute inset-y-0 left-0 flex items-center pl-1">
                                                                                <span
                                                                                    class="p-1 focus:outline-none focus:shadow-outline">
                                                                                    <svg class="h-6 w-6 text-slate-300 dark:text-slate-200"
                                                                                        fill="none"
                                                                                        stroke="currentColor"
                                                                                        stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        viewBox="0 0 24 24"
                                                                                        class="w-6 h-6 dark:text-gray-300 text-gray-400">
                                                                                        <path
                                                                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z">
                                                                                        </path>
                                                                                    </svg>

                                                                                </span>
                                                                            </span>
                                                                            <input wire:model.debounce.600ms="search"
                                                                                type="text"
                                                                                style="padding-left: 36px !important;"
                                                                                class="placeholder-slate-400 block w-full float-right bg-white text-slate-700 border border-slate-300 rounded-full py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 pl-10 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                placeholder="Search...">
                                                                        </div>
                                                                    </div>
                                                                </div>


                                                            </div>




                                                            <div class="my-3 overflow-x-auto bg-white shadow-lg rounded-lg overflow-y-auto relative"
                                                                style="">
                                                                <div>
                                                                    <table
                                                                        class="table power-grid-table rounded-lg min-w-full border border-slate-200 dark:bg-slate-600 dark:border-slate-500"
                                                                        style="">
                                                                        <thead
                                                                            class="shadow-sm bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-500"
                                                                            style="">
                                                                            <tr class="" style="">

                                                                                <div>
                                                                                    <th scope="col"
                                                                                        class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                        style=""
                                                                                        wire:key="6547d51e9e434565ea44367ab89a0beb">
                                                                                        <div class="">
                                                                                            <label
                                                                                                class="flex items-center space-x-3">
                                                                                                <input class="h-4 w-4"
                                                                                                    type="checkbox"
                                                                                                    wire:click="selectCheckboxAll()"
                                                                                                    wire:model.defer="checkboxAll">
                                                                                            </label>
                                                                                        </div>
                                                                                    </th>
                                                                                </div>

                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="b80bb7740288fda1f201890375a60c8f"
                                                                                    style="; width: max-content;   ">
                                                                                    <div class="">
                                                                                        <span>ID</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="1b55b0ee6b777354af8ed6344bcdab00"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('accountcode')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>ACCOUNTCODE</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="25d902c24283ab8cfbac54dfa101ad31"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('src')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>SRC</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="28e3d688a3c077b887921cea3fb1dbc7"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('dst')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>DST</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="9d26de67358a25fbcdc1fdef151e10d3"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('dcontext')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>DCONTEXT</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="4ec41d2cae76ee98fdf10a095df2b92c"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('clid')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>CLID</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="c485d2ed5cc4ce64fcccca710c7a0bb7"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('channel')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>CHANNEL</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="b3d6c27e342d5ae5d1ca06c2d39518f2"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('dstchannel')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>DSTCHANNEL</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="f5af672f9600da2541e8a870bb240691"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('lastapp')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>LASTAPP</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="a4dbed560959417e54032dbfc62e2fa1"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('lastdata')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>LASTDATA</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="0de6303bc2c9f318715d231e8ab4325d"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('calldate')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>CALLDATE</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="552cc586ff983ad4f70ed3f7009d3381"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('answerdate')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>ANSWERDATE</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="0004229d2041ad5c40e5b75e0af50d6a"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('hangupdate')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>HANGUPDATE</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="b85ec314bf443b797ef8a66b3b03f8a4"
                                                                                    style="; width: max-content;   ">
                                                                                    <div class="">
                                                                                        <span>DURATION</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="205d09422705d593761768e5281bf960"
                                                                                    style="; width: max-content;   ">
                                                                                    <div class="">
                                                                                        <span>BILLSEC</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="6cfe0c68cd195b63c8486325b447b1c7"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('disposition')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>DISPOSITION</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="d5aa4bb1461fe3d863bd95fb137e2284"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('amaflags')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>AMAFLAGS</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="ad6f74111cf7845baae01b25dbc589b9"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('uniqueid')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>UNIQUEID</span>
                                                                                    </div>
                                                                                </th>
                                                                                <th class="font-semibold px-2 pr-4 py-3 text-left text-xs font-semibold text-slate-700 tracking-wider whitespace-nowrap dark:text-slate-300 "
                                                                                    wire:key="f1b3bc5c15a60742f44288c7a927361f"
                                                                                    style="; width: max-content;  cursor:pointer;   ">
                                                                                    <div class=""
                                                                                        wire:click="sortBy('userfield')">
                                                                                        <span class="text-md pr-2">
                                                                                            &#8597;
                                                                                        </span>
                                                                                        <span>USERFIELD</span>
                                                                                    </div>
                                                                                </th>

                                                                            </tr>
                                                                        </thead>
                                                                        <tbody class="text-slate-800" style="">
                                                                            <div>
                                                                                <tr class=" bg-white shadow-sm dark:bg-slate-700"
                                                                                    style=" ">
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style=""></td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <input
                                                                                                            wire:model.debounce.800ms="filters.number.id.start"
                                                                                                            wire:input.debounce.800ms="filterNumberStart('id', $event.target.value, 'ID')"
                                                                                                            style=" "
                                                                                                            type="text"
                                                                                                            class="power_grid block bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 min-w-[5rem] "
                                                                                                            placeholder="Min">
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            wire:model.debounce.800ms="filters.number.id.end"
                                                                                                            wire:input.debounce.800ms="filterNumberEnd('id',$event.target.value, 'ID')"
                                                                                                            style=" "
                                                                                                            type="text"
                                                                                                            class="power_grid block bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 min-w-[5rem] "
                                                                                                            placeholder="Max">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.accountcode"
                                                                                                                wire:input.lazy="filterInputTextOptions('accountcode', $event.target.value, 'ACCOUNTCODE')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="accountcode"
                                                                                                            wire:model.debounce.800ms="filters.input_text.accountcode"
                                                                                                            wire:input.debounce.800ms="filterInputText('accountcode', $event.target.value, 'ACCOUNTCODE')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="ACCOUNTCODE" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.src"
                                                                                                                wire:input.lazy="filterInputTextOptions('src', $event.target.value, 'SRC')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="src"
                                                                                                            wire:model.debounce.800ms="filters.input_text.src"
                                                                                                            wire:input.debounce.800ms="filterInputText('src', $event.target.value, 'SRC')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="SRC" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.dst"
                                                                                                                wire:input.lazy="filterInputTextOptions('dst', $event.target.value, 'DST')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="dst"
                                                                                                            wire:model.debounce.800ms="filters.input_text.dst"
                                                                                                            wire:input.debounce.800ms="filterInputText('dst', $event.target.value, 'DST')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="DST" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.dcontext"
                                                                                                                wire:input.lazy="filterInputTextOptions('dcontext', $event.target.value, 'DCONTEXT')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="dcontext"
                                                                                                            wire:model.debounce.800ms="filters.input_text.dcontext"
                                                                                                            wire:input.debounce.800ms="filterInputText('dcontext', $event.target.value, 'DCONTEXT')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="DCONTEXT" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.clid"
                                                                                                                wire:input.lazy="filterInputTextOptions('clid', $event.target.value, 'CLID')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="clid"
                                                                                                            wire:model.debounce.800ms="filters.input_text.clid"
                                                                                                            wire:input.debounce.800ms="filterInputText('clid', $event.target.value, 'CLID')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="CLID" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.channel"
                                                                                                                wire:input.lazy="filterInputTextOptions('channel', $event.target.value, 'CHANNEL')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="channel"
                                                                                                            wire:model.debounce.800ms="filters.input_text.channel"
                                                                                                            wire:input.debounce.800ms="filterInputText('channel', $event.target.value, 'CHANNEL')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="CHANNEL" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.dstchannel"
                                                                                                                wire:input.lazy="filterInputTextOptions('dstchannel', $event.target.value, 'DSTCHANNEL')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="dstchannel"
                                                                                                            wire:model.debounce.800ms="filters.input_text.dstchannel"
                                                                                                            wire:input.debounce.800ms="filterInputText('dstchannel', $event.target.value, 'DSTCHANNEL')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="DSTCHANNEL" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.lastapp"
                                                                                                                wire:input.lazy="filterInputTextOptions('lastapp', $event.target.value, 'LASTAPP')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="lastapp"
                                                                                                            wire:model.debounce.800ms="filters.input_text.lastapp"
                                                                                                            wire:input.debounce.800ms="filterInputText('lastapp', $event.target.value, 'LASTAPP')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="LASTAPP" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.lastdata"
                                                                                                                wire:input.lazy="filterInputTextOptions('lastdata', $event.target.value, 'LASTDATA')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="lastdata"
                                                                                                            wire:model.debounce.800ms="filters.input_text.lastdata"
                                                                                                            wire:input.debounce.800ms="filterInputText('lastdata', $event.target.value, 'LASTDATA')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="LASTDATA" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div wire:ignore
                                                                                            x-data="pgFlatpickr({
                                                                                                dataField: 'calldate',
                                                                                                tableName: 'default',
                                                                                                type: 'datetime',
                                                                                                filterKey: 'enabledFilters.date_picker.calldate',
                                                                                                label: 'CALLDATE',
                                                                                                locale: null,
                                                                                                onlyFuture: false,
                                                                                                noWeekEnds: false,
                                                                                                customConfig: []
                                                                                            })">
                                                                                            <div class="p-2"
                                                                                                style="">
                                                                                                <form
                                                                                                    autocomplete="off">
                                                                                                    <input
                                                                                                        id="input_calldate_formatted"
                                                                                                        x-ref="rangeInput"
                                                                                                        autocomplete="off"
                                                                                                        data-field="calldate"
                                                                                                        style="min-width: 12rem "
                                                                                                        class="power_grid flatpickr flatpickr-input block my-1 bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                        type="text"
                                                                                                        readonly
                                                                                                        placeholder="Select a period">
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>

                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div wire:ignore
                                                                                            x-data="pgFlatpickr({
                                                                                                dataField: 'answerdate',
                                                                                                tableName: 'default',
                                                                                                type: 'datetime',
                                                                                                filterKey: 'enabledFilters.date_picker.answerdate',
                                                                                                label: 'ANSWERDATE',
                                                                                                locale: null,
                                                                                                onlyFuture: false,
                                                                                                noWeekEnds: false,
                                                                                                customConfig: []
                                                                                            })">
                                                                                            <div class="p-2"
                                                                                                style="">
                                                                                                <form
                                                                                                    autocomplete="off">
                                                                                                    <input
                                                                                                        id="input_answerdate_formatted"
                                                                                                        x-ref="rangeInput"
                                                                                                        autocomplete="off"
                                                                                                        data-field="answerdate"
                                                                                                        style="min-width: 12rem "
                                                                                                        class="power_grid flatpickr flatpickr-input block my-1 bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                        type="text"
                                                                                                        readonly
                                                                                                        placeholder="Select a period">
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>

                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div wire:ignore
                                                                                            x-data="pgFlatpickr({
                                                                                                dataField: 'hangupdate',
                                                                                                tableName: 'default',
                                                                                                type: 'datetime',
                                                                                                filterKey: 'enabledFilters.date_picker.hangupdate',
                                                                                                label: 'HANGUPDATE',
                                                                                                locale: null,
                                                                                                onlyFuture: false,
                                                                                                noWeekEnds: false,
                                                                                                customConfig: []
                                                                                            })">
                                                                                            <div class="p-2"
                                                                                                style="">
                                                                                                <form
                                                                                                    autocomplete="off">
                                                                                                    <input
                                                                                                        id="input_hangupdate_formatted"
                                                                                                        x-ref="rangeInput"
                                                                                                        autocomplete="off"
                                                                                                        data-field="hangupdate"
                                                                                                        style="min-width: 12rem "
                                                                                                        class="power_grid flatpickr flatpickr-input block my-1 bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                        type="text"
                                                                                                        readonly
                                                                                                        placeholder="Select a period">
                                                                                                </form>
                                                                                            </div>
                                                                                        </div>

                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <input
                                                                                                            wire:model.debounce.800ms="filters.number.duration.start"
                                                                                                            wire:input.debounce.800ms="filterNumberStart('duration', $event.target.value, 'DURATION')"
                                                                                                            style=" "
                                                                                                            type="text"
                                                                                                            class="power_grid block bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 min-w-[5rem] "
                                                                                                            placeholder="Min">
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            wire:model.debounce.800ms="filters.number.duration.end"
                                                                                                            wire:input.debounce.800ms="filterNumberEnd('duration',$event.target.value, 'DURATION')"
                                                                                                            style=" "
                                                                                                            type="text"
                                                                                                            class="power_grid block bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 min-w-[5rem] "
                                                                                                            placeholder="Max">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <input
                                                                                                            wire:model.debounce.800ms="filters.number.billsec.start"
                                                                                                            wire:input.debounce.800ms="filterNumberStart('billsec', $event.target.value, 'BILLSEC')"
                                                                                                            style=" "
                                                                                                            type="text"
                                                                                                            class="power_grid block bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 min-w-[5rem] "
                                                                                                            placeholder="Min">
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            wire:model.debounce.800ms="filters.number.billsec.end"
                                                                                                            wire:input.debounce.800ms="filterNumberEnd('billsec',$event.target.value, 'BILLSEC')"
                                                                                                            style=" "
                                                                                                            type="text"
                                                                                                            class="power_grid block bg-white border border-slate-300 text-slate-700 py-2 px-3 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 min-w-[5rem] "
                                                                                                            placeholder="Max">
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.disposition"
                                                                                                                wire:input.lazy="filterInputTextOptions('disposition', $event.target.value, 'DISPOSITION')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="disposition"
                                                                                                            wire:model.debounce.800ms="filters.input_text.disposition"
                                                                                                            wire:input.debounce.800ms="filterInputText('disposition', $event.target.value, 'DISPOSITION')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="DISPOSITION" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.amaflags"
                                                                                                                wire:input.lazy="filterInputTextOptions('amaflags', $event.target.value, 'AMAFLAGS')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="amaflags"
                                                                                                            wire:model.debounce.800ms="filters.input_text.amaflags"
                                                                                                            wire:input.debounce.800ms="filterInputText('amaflags', $event.target.value, 'AMAFLAGS')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="AMAFLAGS" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.uniqueid"
                                                                                                                wire:input.lazy="filterInputTextOptions('uniqueid', $event.target.value, 'UNIQUEID')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="uniqueid"
                                                                                                            wire:model.debounce.800ms="filters.input_text.uniqueid"
                                                                                                            wire:input.debounce.800ms="filterInputText('uniqueid', $event.target.value, 'UNIQUEID')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="UNIQUEID" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200"
                                                                                        style="; ">
                                                                                        <div>
                                                                                            <div class="min-w-[9.5rem]"
                                                                                                style="">
                                                                                                <div
                                                                                                    class="flex flex-col">
                                                                                                    <div
                                                                                                        class="">
                                                                                                        <div
                                                                                                            class="relative">
                                                                                                            <select
                                                                                                                class="power_grid appearance-none block bg-white border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500 w-full active dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500 "
                                                                                                                style=""
                                                                                                                wire:model.lazy="filters.input_text_options.userfield"
                                                                                                                wire:input.lazy="filterInputTextOptions('userfield', $event.target.value, 'USERFIELD')">
                                                                                                                <option
                                                                                                                    value="contains">
                                                                                                                    Contains
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="contains_not">
                                                                                                                    Does
                                                                                                                    not
                                                                                                                    contain
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is">
                                                                                                                    Is
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="starts_with">
                                                                                                                    Starts
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="ends_with">
                                                                                                                    Ends
                                                                                                                    with
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_empty">
                                                                                                                    Is
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_empty">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    empty
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_null">
                                                                                                                    Is
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_null">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    null
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_blank">
                                                                                                                    Is
                                                                                                                    blank
                                                                                                                </option>
                                                                                                                <option
                                                                                                                    value="is_not_blank">
                                                                                                                    Is
                                                                                                                    not
                                                                                                                    blank
                                                                                                                </option>
                                                                                                            </select>
                                                                                                            <div
                                                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                                                <svg class="pointer-events-none w-4 h-4 dark:text-gray-300"
                                                                                                                    fill="none"
                                                                                                                    viewBox="0 0 24 24"
                                                                                                                    stroke="currentColor">
                                                                                                                    <path
                                                                                                                        stroke-linecap="round"
                                                                                                                        stroke-linejoin="round"
                                                                                                                        stroke-width="2"
                                                                                                                        d="M19 9l-7 7-7-7" />
                                                                                                                </svg>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div
                                                                                                        class="mt-1">
                                                                                                        <input
                                                                                                            data-id="userfield"
                                                                                                            wire:model.debounce.800ms="filters.input_text.userfield"
                                                                                                            wire:input.debounce.800ms="filterInputText('userfield', $event.target.value, 'USERFIELD')"
                                                                                                            type="text"
                                                                                                            class="power_grid w-full block bg-white text-slate-700 border border-slate-300 rounded py-2 px-3 leading-tight focus:outline-none focus:bg-white focus:border-slate-500 dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500"
                                                                                                            placeholder="USERFIELD" />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </td>
                                                                                </tr>
                                                                            </div>


                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="c4ca4238a0b923820dcc509a6f75849b">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="1">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6667
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            from-zesco
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000000
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            Hangup
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:29:34
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:29:34
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:29:35
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683552574.0
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="c81e728d9d4c2f636f067f89cc14862c">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="2">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            2
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6667
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            from-zesco
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000001
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            Hangup
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:29:54
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:29:54
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:29:55
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683552594.2
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="eccbc87e4b5ce2fe28308fd9f2a7baf3">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="3">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            3
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6667
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            from-zesco
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000002
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            Hangup
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:03
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:03
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:05
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683552603.4
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="a87ff679a2f3e71d9181a67b7542122c">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="4">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            4
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6667
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            from-zesco
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000003
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            Hangup
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:17
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:17
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:19
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683552617.6
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="e4da3b7fbbce2345d7772b0674a318d5">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="5">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            5
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6667
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            from-zesco
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000004
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            Hangup
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:39
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:39
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:30:41
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683552639.8
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="1679091c5a880faf6fb5e6087eb1b2dc">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="6">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            6667
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            from-zesco
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000005
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            Hangup
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:52:59
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:52:59
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 13:53:00
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683553979.10
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="8f14e45fceea167a5a36dedd4bea2543">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="7">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            7
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            s
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            IVR-14
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000001
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            WaitExten
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            10
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:15:09
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:15:09
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:15:18
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            9
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            9
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683555309.1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="c9f0f895fb98ab9159f51fd0297e236d">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="8">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            8
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            s
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            IVR-14
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000002
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            WaitExten
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            10
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:16:04
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:16:04
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:16:05
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683555364.3
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="45c48cce2e2d7fbdea1afc51c7c6ad26">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="9">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            9
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            s
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            IVR-14
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000003
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            WaitExten
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            10
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:21:05
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:21:05
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:21:07
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            2
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            2
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683555665.5
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>

                                                                            <tr style=""
                                                                                class="border border-slate-100 dark:border-slate-400 hover:bg-slate-50 dark:bg-slate-700 dark:odd:bg-slate-800 dark:odd:hover:bg-slate-900 dark:hover:bg-slate-700"
                                                                                wire:key="d3d9446802a44259755d38e6d163e820">



                                                                                <td class="px-6 py-3 text-left text-xs font-medium text-slate-500 tracking-wider"
                                                                                    style="">
                                                                                    <div class="">
                                                                                        <label
                                                                                            class="flex items-center space-x-3">
                                                                                            <input class="h-4 w-4"
                                                                                                type="checkbox"
                                                                                                wire:model.defer="checkboxValues"
                                                                                                value="10">
                                                                                        </label>
                                                                                    </div>
                                                                                </td>

                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            10
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            00260972462922
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            s
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            IVR-14
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            &quot;ZAMTEL&quot;
                                                                                            &lt;00260972462922&gt;
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            SIP/7000-00000004
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            WaitExten
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            10
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:22:42
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:22:42
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            08/05/2023 14:22:45
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            3
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            3
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            ANSWERED
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            DOCUMENTATION
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>
                                                                                            1683555762.7
                                                                                        </div>
                                                                                    </span>
                                                                                </td>
                                                                                <td class="px-3 py-2 whitespace-nowrap dark:text-slate-200 "
                                                                                    style=";  ">
                                                                                    <span class="">
                                                                                        <div>

                                                                                        </div>
                                                                                    </span>
                                                                                </td>


                                                                                <div>
                                                                                </div>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <div>
                                                                <div
                                                                    class="justify-between md:flex md:flex-row w-full items-center pt-3 bg-white overflow-y-auto pl-2 pr-2 pb-1 relative
         dark:bg-slate-700">
                                                                    <div
                                                                        class="flex flex-row justify-center md:justify-start mb-2 md:mb-0">
                                                                        <div class="relative h-10">
                                                                            <select
                                                                                wire:model.lazy="setUp.footer.perPage"
                                                                                class="block appearance-none bg-slate-50 border border-slate-300 text-slate-700 py-2 px-3 pr-8 rounded leading-tight focus:outline-none focus:bg-white focus:border-slate-500  dark:bg-slate-600 dark:text-slate-200 dark:placeholder-slate-200 dark:border-slate-500">
                                                                                <option value="10">
                                                                                    10
                                                                                </option>
                                                                                <option value="25">
                                                                                    25
                                                                                </option>
                                                                                <option value="50">
                                                                                    50
                                                                                </option>
                                                                                <option value="100">
                                                                                    100
                                                                                </option>
                                                                                <option value="0">
                                                                                    All
                                                                                </option>
                                                                            </select>

                                                                            <div
                                                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-slate-700">
                                                                                <svg class="pointer-events-none w-4 h-4"
                                                                                    fill="none"
                                                                                    viewBox="0 0 24 24"
                                                                                    stroke="currentColor">
                                                                                    <path stroke-linecap="round"
                                                                                        stroke-linejoin="round"
                                                                                        stroke-width="2"
                                                                                        d="M19 9l-7 7-7-7" />
                                                                                </svg>
                                                                            </div>
                                                                        </div>
                                                                        <div class="pl-4 hidden sm:block md:block lg:block w-full"
                                                                            style="padding-top: 6px;">
                                                                        </div>
                                                                    </div>

                                                                    <div>
                                                                        <div
                                                                            class="items-center justify-between sm:flex">
                                                                            <div
                                                                                class="items-center justify-between w-full sm:flex-1 sm:flex">
                                                                                <div>
                                                                                    <div
                                                                                        class="mr-2 leading-5 text-center text-slate-700 text-md dark:text-slate-300 sm:text-right">
                                                                                        Showing
                                                                                        <span
                                                                                            class="font-semibold firstItem">1</span>
                                                                                        to
                                                                                        <span
                                                                                            class="font-semibold lastItem">10</span>
                                                                                        of
                                                                                        <span
                                                                                            class="font-semibold total">521228</span>
                                                                                        Results
                                                                                    </div>
                                                                                </div>

                                                                                <nav role="navigation"
                                                                                    aria-label="Pagination Navigation"
                                                                                    class="items-center justify-between sm:flex">
                                                                                    <div
                                                                                        class="flex justify-center mt-2 md:flex-none md:justify-end sm:mt-0">




                                                                                        <span
                                                                                            class="px-2 py-1 m-1 text-center border-slate-400 rounded cursor-pointer border-1 dark:bg-slate-700 dark:text-white dark:text-slate-300">1</span>


                                                                                        <a class="px-2 py-1 m-1 text-center text-white bg-slate-500 border-slate-400 rounded cursor-pointer border-1 hover:bg-slate-600 hover:border-slate-800 dark:text-slate-300"
                                                                                            wire:click="gotoPage(2)">2</a>


                                                                                        <a class="px-2 py-1 m-1 text-center text-white bg-slate-500 border-slate-400 rounded cursor-pointer border-1 hover:bg-slate-600 hover:border-slate-800 dark:text-slate-300"
                                                                                            wire:click="gotoPage(3)">3</a>



















                                                                                        <div
                                                                                            class="mx-1 mt-1 text-slate-600 dark:text-slate-300">
                                                                                            <span>.</span>
                                                                                            <span>.</span>
                                                                                            <span>.</span>
                                                                                        </div>




                                                                                        <a class="px-2 py-1 pt-2 m-1 text-center text-white bg-slate-500 border-slate-400 rounded cursor-pointer border-1 hover:bg-slate-600 hover:border-slate-800 dark:text-slate-300"
                                                                                            wire:click="nextPage"
                                                                                            rel="next">
                                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                                width="16"
                                                                                                height="16"
                                                                                                fill="currentColor"
                                                                                                class="bi bi-chevron-compact-right"
                                                                                                viewBox="0 0 16 16">
                                                                                                <path
                                                                                                    fill-rule="evenodd"
                                                                                                    d="M6.776 1.553a.5.5 0 0 1 .671.223l3 6a.5.5 0 0 1 0 .448l-3 6a.5.5 0 1 1-.894-.448L9.44 8 6.553 2.224a.5.5 0 0 1 .223-.671z" />
                                                                                            </svg>
                                                                                        </a>
                                                                                        <a class="px-2 py-1 pt-2 m-1 text-center text-white bg-slate-500 border-slate-400 rounded cursor-pointer border-1 hover:bg-slate-600 hover:border-slate-800 dark:text-slate-300"
                                                                                            wire:click="gotoPage(52123)">
                                                                                            <svg width="16"
                                                                                                height="16"
                                                                                                fill="currentColor"
                                                                                                class="bi bi-chevron-double-right"
                                                                                                viewBox="0 0 16 16">
                                                                                                <path
                                                                                                    fill-rule="evenodd"
                                                                                                    d="M3.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L9.293 8 3.646 2.354a.5.5 0 0 1 0-.708z" />
                                                                                                <path
                                                                                                    fill-rule="evenodd"
                                                                                                    d="M7.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L13.293 8 7.646 2.354a.5.5 0 0 1 0-.708z" />
                                                                                            </svg>
                                                                                        </a>
                                                                                    </div>
                                                                                </nav>

                                                                                <div>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Livewire Component wire-end:pjCZjC7RMR6V2bjh4AlY -->
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            </div>


                        </div>



                    </div>


                    <!-- Livewire Component wire-end:58UCobKeyiZQP6b0pRLJ -->
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>




        <footer class="main-footer">
            <strong>Copyright &copy; 2023 <a href="https://www.zesco.co.zm/">ZESCO Limited</a>.</strong>
            Designed by Innovation and Systems Development Division - ICT. All Rights Reserved
            <div class="float-right d-none d-sm-inline-block">
                <strong>Version</strong> 2.0.0
            </div>
        </footer>


        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="http://127.0.0.1:8000/plugins/jquery/jquery.min.js"></script>
    <script src="http://127.0.0.1:8000/assets/js/parsley.js" type="text/javascript"></script>


    <!-- jQuery UI 1.11.4 -->
    <script src=" http://127.0.0.1:8000/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="http://127.0.0.1:8000/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="http://127.0.0.1:8000/assets/js/select2.min.js" type="text/javascript"></script>
    <!-- DataTables -->
    <script src="http://127.0.0.1:8000/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>

    <script src="http://127.0.0.1:8000/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/jszip/jszip.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="http://127.0.0.1:8000/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <!-- ChartJS -->
    <script src="http://127.0.0.1:8000/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->

    <!-- JQVMap -->
    <script src="http://127.0.0.1:8000/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="http://127.0.0.1:8000/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="http://127.0.0.1:8000/plugins/moment/moment.min.js"></script>
    <script src="http://127.0.0.1:8000/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="http://127.0.0.1:8000/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="http://127.0.0.1:8000/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <!-- ChartJS -->
    <script src="http://127.0.0.1:8000/bower_components/chart.js/Chart.js"></script>
    <!-- ChartJS -->
    <!-- FastClick -->
    <script src="http://127.0.0.1:8000/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- FastClick -->
    <script src="http://127.0.0.1:8000/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="http://127.0.0.1:8000/dist/js/adminlte.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->

    <!-- AdminLTE for demo purposes -->


    <script src="http://127.0.0.1:8000/dist/js/demo.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.js"></script>
    <!-- Livewire Scripts -->

    <script src="/livewire/livewire.js?id=90730a3b0e7144480175" data-turbo-eval="false" data-turbolinks-eval="false">
    </script>
    <script data-turbo-eval="false" data-turbolinks-eval="false">
        if (window.livewire) {
            console.warn(
                'Livewire: It looks like Livewire\'s @livewireScripts JavaScript assets have already been loaded. Make sure you aren\'t loading them twice.'
                )
        }

        window.livewire = new Livewire();
        window.livewire.devTools(true);
        window.Livewire = window.livewire;
        window.livewire_app_url = '';
        window.livewire_token = 'AubtkQCduHGrxB9ppBqSbLM1yozwUSTSPQhkh3Co';

        /* Make sure Livewire loads first. */
        if (window.Alpine) {
            /* Defer showing the warning so it doesn't get buried under downstream errors. */
            document.addEventListener("DOMContentLoaded", function() {
                setTimeout(function() {
                    console.warn(
                        "Livewire: It looks like AlpineJS has already been loaded. Make sure Livewire\'s scripts are loaded before Alpine.\\n\\n Reference docs for more info: http://laravel-livewire.com/docs/alpine-js"
                        )
                })
            });
        }

        /* Make Alpine wait until Livewire is finished rendering to do its thing. */
        window.deferLoadingAlpine = function(callback) {
            window.addEventListener('livewire:load', function() {
                callback();
            });
        };

        let started = false;

        window.addEventListener('alpine:initializing', function() {
            if (!started) {
                window.livewire.start();

                started = true;
            }
        });

        document.addEventListener("DOMContentLoaded", function() {
            if (!started) {
                window.livewire.start();

                started = true;
            }
        });
    </script>
</body>

</html>
