<aside class="main-sidebar sidebar-light-gray elevation-5">
    <!-- Brand Logo -->
    <a href="#" class="brand-link bg-gradient-orange">
        <img src="{{ asset('assets/img/zesco_logo.png') }}" alt="System Logo" class="brand-image" style="opacity: .9">
        <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar sidebar-background">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                <!-- Admin Section -->
                @if (!Auth::user()->hasRole('agent'))
                    <li class="nav-header">Admin</li>

                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Main Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('reports.call.detail.records') }}" class="nav-link">
                            <i class="fas fa-phone-alt nav-icon"></i>
                            <p>Call Details Report</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.call.summary.records') }}" class="nav-link">
                            <i class="fas fa-file-alt nav-icon"></i>
                            <p>Call Summary Report</p>
                        </a>
                    </li>

                    <li class="nav-header">Configuration</li>
                    <li class="nav-item">
                        <a href="{{ route('config.destinations') }}" class="nav-link">
                            <i class="fas fa-map-marker-alt nav-icon"></i>
                            <p>Destinations</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('config.contexts') }}" class="nav-link">
                            <i class="fas fa-cogs nav-icon"></i>
                            <p>Contexts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('live.recordings') }}" class="nav-link">
                            <i class="fas fa-video nav-icon"></i>
                            <p>Recordings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('session.call-sessions') }}" class="nav-link">
                            <i class="fas fa-video nav-icon"></i>
                            <p>Call sessions</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('configurations.pbx-credentials') }}" class="nav-link">
                            <i class="fas fa-lock nav-icon"></i>
                            <p>PBX Credentials</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('live.agent.manage') }}" class="nav-link">
                            <i class="fas fa-lock nav-icon"></i>
                            <p>Manage agents</p>
                        </a>
                    </li>

                    <li class="nav-header">Reports</li>
                    <li class="nav-item">
                        <form action="{{ route('reports.search') }}">
                            <div class="d-flex justify-content-between">
                                <span><i class="fa fa-search nav-icon text-green"></i><input type="text"
                                        name="src" placeholder="Search here..."></span>
                            </div>
                        </form>
                    </li>

                    <li class="nav-header">Users</li>
                    <li class="nav-item">
                        <a href="{{ route('user.list') }}" class="nav-link">
                            <i class="fas fa-users nav-icon"></i>
                            <p>Manage Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('roles') }}" class="nav-link">
                            <i class="fas fa-user-shield nav-icon"></i>
                            <p>Roles and Permissions</p>
                        </a>
                    </li>
                @else
                    <!-- Agent Section -->
                    <li class="nav-header">Agent</li>
                    <li class="nav-item">
                        <a href="{{ route('live.agent.dashboard',  auth()->user()->id ) }}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif



                <!-- Agent Section -->
                <li class="nav-header">Agent</li>
                <li class="nav-item">
                    <a href="{{ route('live.agent.dashboard',  auth()->user()->id ) }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Agent dashboard</p>
                    </a>
                </li>

                <!-- Supervisor Section -->
                <li class="nav-header">Supervisor</li>
                <li class="nav-item">
                    <a href="{{ route('live.supervisor.dashboard') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Supervisor dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('live.transactionCodes') }}" class="nav-link">
                        <i class="fas fa-tachometer-alt nav-icon"></i>
                        <p>Transaction codes</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('live.supervisor.knowledge-base') }}"
                       class="nav-link {{ request()->routeIs('live.supervisor.knowledge-base') ? 'active' : '' }}">
                        <i class="fas fa-book nav-icon"></i>
                        <p>Knowledge Base</p>
                    </a>
                </li>


                <!-- Supervisor Section -->
                @if (Auth::user()->hasRole('supervisor'))
                    <li class="nav-header">Supervisor</li>
                    <li class="nav-item">
                        <a href="{{ route('live.supervisor.dashboard') }}" class="nav-link">
                            <i class="fas fa-tachometer-alt nav-icon"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                @endif

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside
