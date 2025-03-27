<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <div class="container">
        <a href="{{ route('landing.index') }}" class="navbar-brand">
            <img src="{{ asset('assets/img/zesco_logo.png') }}" alt="AdminLTE Logo"
                class="brand-image img-circle elevation-3" style="opacity: .8">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <button class="navbar-toggler order-1" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse order-3" id="navbarCollapse">
            <!-- Left navbar links -->
            {{--            <ul class="navbar-nav"> --}}
            {{--                <li class="nav-item"> --}}
            {{--                    <a href="index3.html" class="nav-link">Home</a> --}}
            {{--                </li> --}}
            {{--                <li class="nav-item"> --}}
            {{--                    <a href="#" class="nav-link">Contact</a> --}}
            {{--                </li> --}}
            {{--            </ul> --}}

        </div>

        {{-- <div>
            <li class="nav-item">
                <form action="{{ route('reports.search') }}">

                    <span><i class="fa fa-search nav-icon text-green"></i><input type="text" name="src"
                            placeholder="Search here..."></span>

                    <button type="submit"></button>
                </form>
            </li>
        </div> --}}

        <!-- Right navbar links -->
        <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">

            <!-- Notifications Dropdown Menu -->
            {{--            <li class="nav-item dropdown"> --}}
            {{--                <a class="nav-link" data-toggle="dropdown" href="#"> --}}
            {{--                    <i class="far fa-bell"></i> --}}
            {{--                    <span class="badge badge-warning navbar-badge">15</span> --}}
            {{--                </a> --}}
            {{--                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> --}}
            {{--                    <span class="dropdown-header">15 Notifications</span> --}}
            {{--                    <div class="dropdown-divider"></div> --}}
            {{--                    <a href="#" class="dropdown-item"> --}}
            {{--                        <i class="fas fa-envelope mr-2"></i> 4 new messages --}}
            {{--                        <span class="float-right text-muted text-sm">3 mins</span> --}}
            {{--                    </a> --}}
            {{--                    <div class="dropdown-divider"></div> --}}
            {{--                    <a href="#" class="dropdown-item"> --}}
            {{--                        <i class="fas fa-users mr-2"></i> 8 friend requests --}}
            {{--                        <span class="float-right text-muted text-sm">12 hours</span> --}}
            {{--                    </a> --}}
            {{--                    <div class="dropdown-divider"></div> --}}
            {{--                    <a href="#" class="dropdown-item"> --}}
            {{--                        <i class="fas fa-file mr-2"></i> 3 new reports --}}
            {{--                        <span class="float-right text-muted text-sm">2 days</span> --}}
            {{--                    </a> --}}
            {{--                    <div class="dropdown-divider"></div> --}}
            {{--                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a> --}}
            {{--                </div> --}}
            {{--            </li> --}}

            <li class="nav-item dropdown">
                <a id="dropdownSubMenu1" href="#" data-toggle="dropdown" aria-haspopup="true"
                    aria-expanded="false" class="nav-link dropdown-toggle">Admins</a>
                <ul aria-labelledby="dropdownSubMenu1" class="dropdown-menu border-0 shadow">
                    <li><a href="{{ route('login') }}" class="dropdown-item">Log in</a></li>
                    {{--                    @if (Route::has('register')) --}}
                    {{--                        <li><a href="{{ route('register') }}" class="dropdown-item">Register</a></li> --}}
                    {{--                    @endif --}}
                </ul>
            </li>
        </ul>
    </div>
</nav>
<!-- /.navbar -->
