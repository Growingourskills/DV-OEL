@extends('layouts.app')

@section('title', 'Customers')

@section('content')
<div class="page-header">
    <h1 class="page-title">Customer Analysis</h1>
    <p class="page-subtitle">Demographics, segments, and top customers</p>
</div>

<div class="stats-grid">
    @foreach($genderSplit as $g)
    <div class="stat-card">
        <i data-lucide="{{ $g->gender == 'Male' ? 'user' : 'user-round' }}" class="stat-icon"></i>
        <div class="stat-label">{{ $g->gender }} Customers</div>
        <div class="stat-value">{{ $g->count }}</div>
    </div>
    @endforeach
</div>

<div class="chart-grid">
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="users"></i>
            Customers by Age Group
        </div>
        <div class="chart-container">
            <canvas id="ageChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="pie-chart"></i>
            Spending Level Distribution
        </div>
        <div class="chart-container">
            <canvas id="spendingChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card full" style="margin-bottom: 30px;">
    <div class="chart-title">
        <i data-lucide="trophy"></i>
        Top 10 Customers by Spending
    </div>
    <table class="data-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Customer</th>
                <th>City</th>
                <th>Orders</th>
                <th>Total Spent</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topCustomers as $index => $c)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td><strong>{{ $c->customer_name }}</strong><br><small style="color:#888">{{ $c->customer_id }}</small></td>
                <td><span class="badge badge-teal">{{ $c->city }}</span></td>
                <td>{{ $c->order_count }}</td>
                <td><strong>PKR {{ number_format($c->total_spent) }}</strong></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

@section('scripts')
<script>
    var ageData = @json($ageGroups);
    var labels = ageData.map(a => a.age_group);
    var values = ageData.map(a => a.count);

    new Chart(document.getElementById('ageChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Customers',
                data: values,
                backgroundColor: ['#FFD700', '#FF6B9D', '#4ECDC4', '#A855F7', '#FF8C42'],
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

    fetch('/api/customer-data')
        .then(r => r.json())
        .then(data => {
            new Chart(document.getElementById('spendingChart'), {
                type: 'doughnut',
                data: {
                    labels: data.spending.map(s => s.level),
                    datasets: [{
                        data: data.spending.map(s => s.count),
                        backgroundColor: ['#4ECDC4', '#FFD700', '#FF6B9D', '#A855F7'],
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
