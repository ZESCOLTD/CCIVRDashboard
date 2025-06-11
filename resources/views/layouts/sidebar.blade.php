@if (Auth::user()->hasRole('agent') && Auth::user()->getRoleNames()->count()==1)

@else
    <aside class="main-sidebar sidebar-light-gray elevation-5">
        <!-- Brand Logo -->
        <a href="#" class="brand-link bg-gradient-orange">
            <img src="{{ asset('assets/img/zesco_logo.png') }}" alt="System Logo" class="brand-image" style="opacity: .9">
            <span class="brand-text font-weight-light">{{ config('app.name', 'Laravel') }}</span>
        </a>
        <style>
            .nav-header {
                font-weight: bold;
                text-transform: uppercase;
            }
        </style>

        <!-- Sidebar -->

        <div class="sidebar sidebar-background">
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar nav-child-indent flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">

                    {{-- DASHBOARD --}}
                    <li class="nav-header" style="font-weight: bold; text-transform: uppercase;">Dashboard & Overview
                    </li>
                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('qa-supervisor') || Auth::user()->hasRole('qa-officer'))
                        <li class="nav-item">
                            <a href="{{ route('reports.index') }}" class="nav-link">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Main Dashboard</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('live.agent.dashboard', auth()->user()->id) }}" class="nav-link">
                            <i class="fas fa-user nav-icon"></i>
                            <p>Agent Dashboard</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('live.supervisor.dashboard') }}" class="nav-link">
                            <i class="fas fa-chalkboard-teacher nav-icon"></i>
                            <p>Supervisor Dashboard</p>
                        </a>
                    </li>

                    {{-- REPORTS --}}
                    @if (Auth::user()->hasRole('qa-supervisor') || Auth::user()->hasRole('qa-officer'))
                        <li class="nav-header">Reports & Analytics</li>
                        <li class="nav-item">
                            <a href="{{ route('general-report') }}" class="nav-link">
                                <i class="fas fa-chart-pie nav-icon"></i>
                                <p>General Master Report</p>
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
                    @endif
                    {{--                    <li class="nav-item"> --}}
                    {{--                        <form action="{{ route('reports.search') }}"> --}}
                    {{--                            <div class="d-flex justify-content-between"> --}}
                    {{--                                <span><i class="fa fa-search nav-icon text-green"></i><input type="text" name="src" placeholder="Search here..."></span> --}}
                    {{--                            </div> --}}
                    {{--                        </form> --}}
                    {{--                    </li> --}}


                    {{-- CONFIGURATION --}}
                    @if (Auth::user()->hasRole('admin') )
                        <li class="nav-header">Call Centre Configuration</li>
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
                                <i class="fas fa-phone nav-icon"></i>
                                <p>Call Sessions</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('configurations.pbx-credentials') }}" class="nav-link">
                                <i class="fas fa-key nav-icon"></i>
                                <p>PBX Credentials</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('live.agent.manage') }}" class="nav-link">
                                <i class="fas fa-user-cog nav-icon"></i>
                                <p>Manage Agents</p>
                            </a>
                        </li>
                    @endif

                    {{-- USERS --}}
                    @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
                        <li class="nav-header">User & Role Management</li>
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
                    @endif

                    {{-- SUPERVISOR TOOLS --}}
                    <li class="nav-header">Supervisor Tools</li>
                    <li class="nav-item">
                        <a href="{{ route('live.transactionCodes') }}" class="nav-link">
                            <i class="fas fa-code nav-icon"></i>
                            <p>Transaction Codes</p>
                        </a>
                    </li>

                    {{-- KNOWLEDGE BASE --}}
                    <li class="nav-header">Help & Knowledge Base</li>
                    <li class="nav-item">
                        <a href="{{ route('technical.index') }}" class="nav-link">
                            <i class="fas fa-book nav-icon"></i>
                            <p>Knowledge Base MGT</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>


    </aside>
@endif
