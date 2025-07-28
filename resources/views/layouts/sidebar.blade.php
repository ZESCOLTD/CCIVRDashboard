@if (Auth::user()->hasRole('agent') && Auth::user()->getRoleNames()->count() == 1)
@else
<aside class="main-sidebar sidebar-dark-gray elevation-5">
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

        .text-orange {
    color: #fd7e14 !important;
}

    </style>



    @if (Auth::user()->getRoleNames()->count())
    <div class="sidebar sidebar-background">
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

              {{-- DASHBOARD --}}
<li class="nav-header">Dashboard & Overview</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tachometer-alt text-orange"></i>
        <p>
            Dashboards
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('qa-supervisor') || Auth::user()->hasRole('qa-officer'))
        <li class="nav-item">
            <a href="{{ route('reports.index') }}" class="nav-link">
                <i class="fas fa-chart-line nav-icon text-orange"></i>
                <p>Main Dashboard</p>
            </a>
        </li>
        @endif
        <li class="nav-item">
            <a href="{{ route('live.agent.dashboard', auth()->user()->id) }}" class="nav-link">
                <i class="fas fa-headset nav-icon text-orange"></i>
                <p>Inbound Agent</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('live.agent.outbound', auth()->user()->id) }}" class="nav-link">
                <i class="fas fa-phone-volume nav-icon text-orange"></i>
                <p>Outbound Agent</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('live.supervisor.dashboard') }}" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon text-orange"></i>
                <p>Supervisor Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('omnidashboard') }}" class="nav-link">
                <i class="fas fa-chalkboard-teacher nav-icon text-orange"></i>
                <p>Omin-cahnnel Dashboard</p>
            </a>
        </li>

    </ul>
</li>

{{-- REPORTS --}}
@if (Auth::user()->hasRole('qa-supervisor') || Auth::user()->hasRole('qa-officer') || Auth::user()->hasRole('admin'))
<li class="nav-header">Reports & Analytics</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-chart-pie text-orange"></i>
        <p>
            Reports
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('general-report') }}" class="nav-link">
                <i class="fas fa-file-alt nav-icon text-orange"></i>
                <p>General Master Report</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.call.detail.records') }}" class="nav-link">
                <i class="fas fa-phone-alt nav-icon text-orange"></i>
                <p>Call Details Report</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('reports.call.summary.records') }}" class="nav-link">
                <i class="fas fa-file-invoice nav-icon text-orange"></i>
                <p>Call Summary Report</p>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- CONFIGURATION --}}
@if (Auth::user()->hasRole('admin'))
<li class="nav-header">Call Centre Configuration</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-tools text-orange"></i>
        <p>
            Configuration
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('config.destinations') }}" class="nav-link">
                <i class="fas fa-map-marker-alt nav-icon text-orange"></i>
                <p>Destinations</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('config.contexts') }}" class="nav-link">
                <i class="fas fa-layer-group nav-icon text-orange"></i>
                <p>Contexts</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('live.recordings') }}" class="nav-link">
                <i class="fas fa-video nav-icon text-orange"></i>
                <p>Recordings</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('session.call-sessions') }}" class="nav-link">
                <i class="fas fa-phone nav-icon text-orange"></i>
                <p>Call Sessions</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('configurations.pbx-credentials') }}" class="nav-link">
                <i class="fas fa-key nav-icon text-orange"></i>
                <p>PBX Credentials</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('live.agent.manage') }}" class="nav-link">
                <i class="fas fa-user-cog nav-icon text-orange"></i>
                <p>Manage Agents</p>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- USERS --}}
@if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('super-admin'))
<li class="nav-header">User & Role Management</li>
<li class="nav-item">
    <a href="#" class="nav-link">
        <i class="nav-icon fas fa-user-shield text-orange"></i>
        <p>
            User Management
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        <li class="nav-item">
            <a href="{{ route('user.list') }}" class="nav-link">
                <i class="fas fa-users nav-icon text-orange"></i>
                <p>Manage Users</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ url('roles') }}" class="nav-link">
                <i class="fas fa-lock nav-icon text-orange"></i>
                <p>Roles and Permissions</p>
            </a>
        </li>
    </ul>
</li>
@endif

{{-- SUPERVISOR TOOLS --}}
<li class="nav-header">Supervisor Tools</li>
<li class="nav-item">
    <a href="{{ route('live.transactionCodes') }}" class="nav-link">
        <i class="fas fa-code nav-icon text-orange"></i>
        <p>Transaction Codes</p>
    </a>
</li>

{{-- KNOWLEDGE BASE --}}
<li class="nav-header">Help & Knowledge Base</li>
<li class="nav-item">
    <a href="{{ route('technical.index') }}" class="nav-link">
        <i class="fas fa-book nav-icon text-orange"></i>
        <p>Knowledge Base MGT</p>
    </a>
</li>


            </ul>
        </nav>
    </div>
    @endif
</aside>
@endif
