<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') - Thomas Apartment</title>
    <meta name="description" content="Thomas Apartment Management System">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body>
    <!-- Sidebar Overlay (Mobile) -->
    <div class="sidebar-overlay" id="sidebarOverlay" onclick="toggleSidebar()"></div>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="main-content">
        <!-- Topbar -->
        <div class="topbar">
            <div>
                <button class="sidebar-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-list"></i>
                </button>
                <h1 class="page-title d-inline">@yield('page-title', 'Dashboard')</h1>
            </div>
            <div class="user-info">
                <div class="text-end d-none d-sm-block">
                    <div class="user-name">{{ auth()->user()->name }}</div>
                    <div class="user-role">{{ ucfirst(auth()->user()->getRoleNames()->first() ?? 'User') }}</div>
                </div>
                <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm" title="Logout">
                        <i class="bi bi-box-arrow-right"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div class="page-content">
            @yield('content')
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer">
        @if(session('success'))
            <div class="toast-custom" id="successToast">
                <i class="bi bi-check-circle-fill text-success" style="font-size:1.3rem"></i>
                <div>
                    <strong>Success!</strong><br>
                    <small>{{ session('success') }}</small>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="toast-custom toast-error" id="errorToast">
                <i class="bi bi-x-circle-fill text-danger" style="font-size:1.3rem"></i>
                <div>
                    <strong>Error!</strong><br>
                    <small>{{ session('error') }}</small>
                </div>
            </div>
        @endif
    </div>

    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="spinner"></div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        // Sidebar Toggle
        function toggleSidebar() {
            document.querySelector('.sidebar').classList.toggle('show');
            document.getElementById('sidebarOverlay').classList.toggle('show');
        }

        // Auto-hide toasts
        document.querySelectorAll('.toast-custom').forEach(toast => {
            setTimeout(() => {
                toast.classList.add('hiding');
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        });

        // Delete confirmation
        function confirmDelete(formId) {
            if (confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
                document.getElementById(formId).submit();
            }
        }
    </script>
    @stack('scripts')
</body>
</html>
