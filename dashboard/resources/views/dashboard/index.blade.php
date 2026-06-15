@extends('layouts.app')

@section('title', 'Overview')

@section('content')
<div class="page-header">
    <h1 class="page-title">Dashboard Overview</h1>
    <p class="page-subtitle">E-commerce customer behavior at a glance</p>
</div>

<div class="stats-grid">
    <div class="stat-card" id="card-sales">
        <i data-lucide="banknote" class="stat-icon"></i>
        <div class="stat-label">Total Sales</div>
        <div class="stat-value">PKR {{ number_format($totalSales) }}</div>
    </div>
    <div class="stat-card" id="card-orders">
        <i data-lucide="shopping-cart" class="stat-icon"></i>
        <div class="stat-label">Total Orders</div>
        <div class="stat-value">{{ number_format($totalOrders) }}</div>
    </div>
    <div class="stat-card" id="card-customers">
        <i data-lucide="users" class="stat-icon"></i>
        <div class="stat-label">Unique Customers</div>
        <div class="stat-value">{{ number_format($totalCustomers) }}</div>
    </div>
    <div class="stat-card" id="card-avg">
        <i data-lucide="target" class="stat-icon"></i>
        <div class="stat-label">Avg Order Value</div>
        <div class="stat-value">PKR {{ number_format($avgOrder) }}</div>
    </div>
</div>

<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="trending-up"></i>
            Monthly Revenue Trend
        </div>
        <div class="chart-container">
            <canvas id="monthlyChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="bar-chart-3"></i>
            Sales by Category
        </div>
        <div class="chart-container">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="wallet"></i>
            Payment Methods
        </div>
        <div class="chart-container">
            <canvas id="paymentChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="monitor-smartphone"></i>
            Orders by Device
        </div>
        <div class="chart-container">
            <canvas id="deviceChart"></canvas>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    fetch('/api/chart-data')
        .then(r => r.json())
        .then(data => {
            new Chart(document.getElementById('monthlyChart'), {
                type: 'line',
                data: {
                    labels: data.monthly.map(m => m.month),
                    datasets: [{
                        label: 'Revenue',
                        data: data.monthly.map(m => m.total),
                        borderColor: '#4ECDC4',
                        backgroundColor: 'rgba(78,205,196,0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointRadius: 4,
                        pointBackgroundColor: '#4ECDC4'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false } }
                    }
                }
            });

            new Chart(document.getElementById('categoryChart'), {
                type: 'bar',
                data: {
                    labels: data.categories.map(c => c.product_category),
                    datasets: [{
                        label: 'Sales',
                        data: data.categories.map(c => c.total),
                        backgroundColor: [
                            '#FFD700', '#FF6B9D', '#4ECDC4', '#A855F7', '#FF8C42',
                            '#6BCB77', '#4D96FF', '#FFB4B4', '#B983FF', '#94D2BD'
                        ],
                        borderColor: '#1a1a2e',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                        x: { grid: { display: false }, ticks: { maxRotation: 45 } }
                    }
                }
            });

            new Chart(document.getElementById('paymentChart'), {
                type: 'doughnut',
                data: {
                    labels: data.payments.map(p => p.payment_method),
                    datasets: [{
                        data: data.payments.map(p => p.count),
                        backgroundColor: ['#FFD700', '#FF6B9D', '#4ECDC4', '#A855F7', '#FF8C42'],
                        borderColor: '#1a1a2e',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, font: { family: "'Space Grotesk'" } } }
                    }
                }
            });

            new Chart(document.getElementById('deviceChart'), {
                type: 'pie',
                data: {
                    labels: data.devices.map(d => d.device_type),
                    datasets: [{
                        data: data.devices.map(d => d.count),
                        backgroundColor: ['#FFD700', '#4ECDC4', '#A855F7'],
                        borderColor: '#1a1a2e',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom', labels: { padding: 15, font: { family: "'Space Grotesk'" } } }
                    }
                }
            });
        });
</script>
@endsection
