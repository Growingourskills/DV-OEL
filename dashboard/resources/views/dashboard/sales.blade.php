@extends('layouts.app')

@section('title', 'Sales Analytics')

@section('content')
<div class="page-header">
    <h1 class="page-title">Sales Analytics</h1>
    <p class="page-subtitle">Revenue trends and category breakdown</p>
</div>

<div class="info-row">
    @foreach($categorySales->take(3) as $cat)
    <div class="info-card">
        <div class="info-card-title">
            <i data-lucide="package" style="width:16px;height:16px;color:#4ECDC4"></i>
            {{ $cat->product_category }}
        </div>
        <ul>
            <li><span>Total Sales</span><strong>PKR {{ number_format($cat->total) }}</strong></li>
            <li><span>Orders</span><strong>{{ number_format($cat->orders) }}</strong></li>
            <li><span>Avg Order</span><strong>PKR {{ number_format($cat->total / max($cat->orders, 1)) }}</strong></li>
        </ul>
    </div>
    @endforeach
</div>

<div class="chart-grid">
    <div class="chart-card full">
        <div class="chart-title">
            <i data-lucide="trending-up"></i>
            Monthly Revenue & Orders
        </div>
        <div class="chart-container" style="height: 350px;">
            <canvas id="salesTrendChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="map-pin"></i>
            Revenue by City
        </div>
        <div class="chart-container">
            <canvas id="cityChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="calendar-days"></i>
            Average Sales by Day
        </div>
        <div class="chart-container">
            <canvas id="dayChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card" style="margin-bottom: 30px;">
    <div class="chart-title">
        <i data-lucide="list"></i>
        All Categories
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Total Sales</th>
                <th>Orders</th>
                <th>Avg Order</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categorySales as $cat)
            <tr>
                <td><strong>{{ $cat->product_category }}</strong></td>
                <td>PKR {{ number_format($cat->total) }}</td>
                <td>{{ number_format($cat->orders) }}</td>
                <td>PKR {{ number_format($cat->total / max($cat->orders, 1)) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    var citySales = @json($citySales);

    new Chart(document.getElementById('cityChart'), {
        type: 'bar',
        data: {
            labels: citySales.map(c => c.city),
            datasets: [{
                label: 'Revenue',
                data: citySales.map(c => c.total),
                backgroundColor: '#FF6B9D',
                borderColor: '#1a1a2e',
                borderWidth: 2
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                x: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
                y: { grid: { display: false } }
            }
        }
    });

    fetch('/api/sales-data')
        .then(r => r.json())
        .then(data => {
            new Chart(document.getElementById('salesTrendChart'), {
                type: 'line',
                data: {
                    labels: data.monthly.map(m => m.month),
                    datasets: [{
                        label: 'Revenue (PKR)',
                        data: data.monthly.map(m => m.total),
                        borderColor: '#4ECDC4',
                        backgroundColor: 'rgba(78,205,196,0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        yAxisID: 'y'
                    }, {
                        label: 'Orders',
                        data: data.monthly.map(m => m.orders),
                        borderColor: '#A855F7',
                        borderWidth: 2,
                        borderDash: [5, 5],
                        tension: 0.3,
                        yAxisID: 'y1'
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: "'Space Grotesk'" } } }
                    },
                    scales: {
                        y: { beginAtZero: true, position: 'left', grid: { color: 'rgba(0,0,0,0.05)' } },
                        y1: { beginAtZero: true, position: 'right', grid: { drawOnChartArea: false } },
                        x: { grid: { display: false } }
                    }
                }
            });

            var dayOrder = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            var sorted = dayOrder.map(d => {
                var found = data.daily.find(x => x.day_name === d);
                return found ? found.avg_amount : 0;
            });

            new Chart(document.getElementById('dayChart'), {
                type: 'bar',
                data: {
                    labels: dayOrder.map(d => d.slice(0, 3)),
                    datasets: [{
                        label: 'Avg Sales',
                        data: sorted,
                        backgroundColor: '#FFD700',
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
                        x: { grid: { display: false } }
                    }
                }
            });
        });
</script>
@endsection
