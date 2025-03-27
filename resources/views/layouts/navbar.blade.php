<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link"><strong>{{ config('app.name', 'Laravel') }}</strong></a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- User Account: style can be found in dropdown.less -->
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link d-flex align-items-center" data-toggle="dropdown">
                <span class="d-none d-md-inline mr-2">{{ Auth::user()->name ?? "Developer" }}</span>
                <img src="{{ asset('assets/img/faces/face-0.jpg') }}" class="user-image" alt="User Image" style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover;">
                <i class="fas fa-caret-down ml-2"></i>
            </a>

            <ul class="dropdown-menu dropdown-menu-right">
                <!-- User image -->
                <li class="user-header bg-gradient-orange">
                    <img src="{{ asset('assets/img/faces/face-0.jpg') }}" class="img-circle" alt="User Image">
                    <p>
                        {{ Auth::user()->name ?? "Developer" }}
                        <small>{{ Auth::user()->job_title ?? "Developer" }}</small>
                    </p>
                </li>

                <li class="dropdown-divider"></li>

                <!-- User Menu Items -->
                <li class="dropdown-item">
                    <a href="{{ route('user.profile', ['profile' => \App\Services\Security\ParameterEncryption::encrypt(Auth::user()->id)]) }}" class="nav-link">
                        <i class="fas fa-user-circle nav-icon"></i> My Profile
                    </a>
                </li>
                <li class="dropdown-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cog nav-icon"></i> Settings
                    </a>
                </li>

                <li class="dropdown-divider"></li>

                <li class="dropdown-item">
                    <a href="{{ route('logout') }}" class="nav-link"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt nav-icon"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</nav>
