<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="E-commerce Customer Behavior Analytics Dashboard">
    <title>@yield('title', 'Dashboard') - DV Analytics</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script src="https://unpkg.com/lucide@0.400.0/dist/umd/lucide.min.js"></script>
</head>
<body>

    <aside class="sidebar">
        <div class="sidebar-logo">DV<span>Lab</span></div>
        <nav class="sidebar-nav">
            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('customers') }}" class="sidebar-link {{ request()->routeIs('customers') ? 'active' : '' }}">
                <i data-lucide="users"></i>
                <span>Customers</span>
            </a>
            <a href="{{ route('sales') }}" class="sidebar-link {{ request()->routeIs('sales') ? 'active' : '' }}">
                <i data-lucide="trending-up"></i>
                <span>Sales</span>
            </a>
            <a href="{{ route('eda') }}" class="sidebar-link {{ request()->routeIs('eda') ? 'active' : '' }}">
                <i data-lucide="line-chart"></i>
                <span>EDA Analytics</span>
            </a>
            <a href="{{ route('explorer') }}" class="sidebar-link {{ request()->routeIs('explorer') ? 'active' : '' }}">
                <i data-lucide="database"></i>
                <span>Data Explorer</span>
            </a>
        </nav>
        <div class="sidebar-footer">DV Lab OEL Project</div>
    </aside>

    <main class="main">
        @yield('content')
    </main>

    <script>
        lucide.createIcons();
    </script>
    @yield('scripts')
</body>
</html>
