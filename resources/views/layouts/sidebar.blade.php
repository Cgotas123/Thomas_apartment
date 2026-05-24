<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <div class="brand-icon"><i class="bi bi-building"></i></div>
        <h4>Thomas Apartment</h4>
    </div>
    <nav class="sidebar-nav">
        <div class="nav-section">Main</div>
        <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>

        <div class="nav-section">Management</div>
        <a href="{{ route('tenants.index') }}" class="nav-link {{ request()->routeIs('tenants.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Tenants
        </a>
        <a href="{{ route('units.index') }}" class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}">
            <i class="bi bi-door-open"></i> Units
        </a>
        <a href="{{ route('leases.index') }}" class="nav-link {{ request()->routeIs('leases.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-text"></i> Leases
        </a>

        <div class="nav-section">Billing</div>
        <a href="{{ route('meter-readings.index') }}" class="nav-link {{ request()->routeIs('meter-readings.*') ? 'active' : '' }}">
            <i class="bi bi-speedometer"></i> Meter Readings
        </a>
        <a href="{{ route('bills.index') }}" class="nav-link {{ request()->routeIs('bills.*') ? 'active' : '' }}">
            <i class="bi bi-receipt"></i> Bills
        </a>
        <a href="{{ route('payments.index') }}" class="nav-link {{ request()->routeIs('payments.*') ? 'active' : '' }}">
            <i class="bi bi-cash-stack"></i> Payments
        </a>

        <div class="nav-section">Operations</div>
        <a href="{{ route('maintenance.index') }}" class="nav-link {{ request()->routeIs('maintenance.*') ? 'active' : '' }}">
            <i class="bi bi-wrench"></i> Maintenance
        </a>
        <a href="{{ route('reports.index') }}" class="nav-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
            <i class="bi bi-bar-chart"></i> Reports
        </a>

        @role('admin')
        <div class="nav-section">Administration</div>
        <a href="{{ route('users.index') }}" class="nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i> User Management
        </a>
        @endrole
    </nav>
</div>
