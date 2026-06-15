@extends('layouts.app')

@section('title', 'EDA Analytics')

@section('content')
<div class="page-header">
    <h1 class="page-title">EDA & Statistical Analytics</h1>
    <p class="page-subtitle">Exploratory data analysis, customer segmentation, correlations, and distributions</p>
</div>

<!-- SECTION 1: K-MEANS CLUSTERING -->
<div class="chart-card full" style="margin-bottom: 30px;">
    <div class="chart-title">
        <i data-lucide="split"></i>
        Customer Segmentation (K-Means Clustering, K=3)
    </div>
    <div class="eda-clustering-container" style="display: flex; gap: 30px; flex-wrap: wrap;">
        <div style="flex: 1 1 500px; height: 350px;">
            <canvas id="clusterScatterChart"></canvas>
        </div>
        <div style="flex: 1 1 300px; padding: 10px;">
            <div class="cluster-legend-card" style="border: 2px solid #1a1a2e; padding: 15px; background: #fff; box-shadow: 4px 4px 0px #1a1a2e; margin-bottom: 15px;">
                <h3 style="margin-top: 0; font-family: 'Space Grotesk'; font-size: 1.1rem; border-bottom: 2px solid #1a1a2e; padding-bottom: 5px;">Segments Identified</h3>
                <ul style="list-style: none; padding-left: 0; margin: 0; font-size: 0.95rem;">
                    <li style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                        <span style="width: 14px; height: 14px; background: #FFD700; border: 1.5px solid #1a1a2e; display: inline-block;"></span>
                        <strong>Cluster 2 (VIP Spenders):</strong> High spending, frequent orders
                    </li>
                    <li style="margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                        <span style="width: 14px; height: 14px; background: #4ECDC4; border: 1.5px solid #1a1a2e; display: inline-block;"></span>
                        <strong>Cluster 0 (Regular Buyers):</strong> Moderate spending, average orders
                    </li>
                    <li style="margin-bottom: 0; display: flex; align-items: center; gap: 10px;">
                        <span style="width: 14px; height: 14px; background: #FF6B9D; border: 1.5px solid #1a1a2e; display: inline-block;"></span>
                        <strong>Cluster 1 (Low-Value):</strong> New/inactive, low spending
                    </li>
                </ul>
            </div>
            <p style="font-size: 0.9rem; color: #555; line-height: 1.4; margin: 0;">
                <strong>Clustering Insight:</strong> The business should offer premium loyalty programs for Cluster 2, and targeted promotional deals to convert Cluster 1 into active regular customers.
            </p>
        </div>
    </div>
</div>

<!-- SECTION 2: SCATTER PLOTS -->
<div class="chart-grid" style="margin-bottom: 30px;">
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="scatter-chart"></i>
            Customer Age vs Total Spending
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="ageSpendingChart"></canvas>
        </div>
        <p style="font-size: 0.85rem; color: #666; margin-top: 10px; line-height: 1.3;">
            <strong>Insight:</strong> Dots are spread evenly across all ages, indicating age has no strong correlation with total e-commerce spending.
        </p>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="hourglass"></i>
            Session Duration vs Order Amount
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="sessionSpendingChart"></canvas>
        </div>
        <p style="font-size: 0.85rem; color: #666; margin-top: 10px; line-height: 1.3;">
            <strong>Insight:</strong> Session duration is widely distributed and doesn't linearly guarantee higher purchase amounts.
        </p>
    </div>
</div>

<!-- SECTION 3: DISTRIBUTIONS -->
<div class="chart-grid" style="margin-bottom: 30px;">
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="activity"></i>
            Customer Age Distribution
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="ageDistChart"></canvas>
        </div>
        <p style="font-size: 0.85rem; color: #666; margin-top: 10px; line-height: 1.3;">
            <strong>Insight:</strong> Even spread from 18 to 65 years old. This represents a diverse customer demographic in Pakistan.
        </p>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="bar-chart-4"></i>
            Spending Distribution & Normal Fit
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="amountDistChart"></canvas>
        </div>
        <p style="font-size: 0.85rem; color: #666; margin-top: 10px; line-height: 1.3;">
            <strong>Insight:</strong> Strongly right-skewed distribution. Most orders are low-to-medium value, with very few large orders.
        </p>
    </div>
</div>

<!-- SECTION 4: CORRELATION HEATMAP & DEMOGRAPHICS -->
<div class="chart-grid" style="margin-bottom: 30px;">
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="percent"></i>
            Category Sales by Gender (Stacked)
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="genderCategoryChart"></canvas>
        </div>
        <p style="font-size: 0.85rem; color: #666; margin-top: 10px; line-height: 1.3;">
            <strong>Insight:</strong> High gender balance across categories, with a slight female inclination in Beauty & Fashion products.
        </p>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="grid"></i>
            Correlation Heatmap Matrix
        </div>
        <div class="heatmap-wrapper" style="overflow-x: auto; padding: 10px 0;">
            <table class="heatmap-table" style="width: 100%; border-collapse: collapse; text-align: center; font-size: 0.85rem; font-family: 'Space Grotesk'; border: 2px solid #1a1a2e;">
                <thead>
                    <tr style="background: #f4f4f6; border-bottom: 2px solid #1a1a2e;">
                        <th style="padding: 8px; border-right: 2px solid #1a1a2e;">Feature</th>
                        <th style="padding: 8px;">Age</th>
                        <th style="padding: 8px;">Price</th>
                        <th style="padding: 8px;">Qty</th>
                        <th style="padding: 8px;">Total</th>
                        <th style="padding: 8px;">Satis</th>
                        <th style="padding: 8px;">Sess</th>
                    </tr>
                </thead>
                <tbody id="heatmap-body">
                    <!-- Loaded dynamically via JS -->
                </tbody>
            </table>
        </div>
        <p style="font-size: 0.85rem; color: #666; margin-top: 10px; line-height: 1.3;">
            <strong>Insight:</strong> Price and Quantity show positive correlation with Total Amount. Other variables are statistically independent.
        </p>
    </div>
</div>

<!-- SECTION 5: SATISFACTION & PRICING -->
<div class="chart-grid" style="margin-bottom: 30px;">
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="badge-dollar-sign"></i>
            Average Unit Price by Category
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="categoryPriceChart"></canvas>
        </div>
    </div>
    <div class="chart-card">
        <div class="chart-title">
            <i data-lucide="star"></i>
            Satisfaction Score by Payment Method
        </div>
        <div class="chart-container" style="height: 300px;">
            <canvas id="paymentSatisfactionChart"></canvas>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    fetch('/api/eda-data')
        .then(r => r.json())
        .then(data => {
            // 1. Correlation Heatmap render
            var cols = ['age', 'unit_price', 'quantity', 'total_amount', 'satisfaction_score', 'session_duration_min'];
            var labelsMap = {
                'age': 'Age',
                'unit_price': 'Unit Price',
                'quantity': 'Quantity',
                'total_amount': 'Total Amount',
                'satisfaction_score': 'Satisfaction',
                'session_duration_min': 'Session (min)'
            };
            var tbody = document.getElementById('heatmap-body');
            cols.forEach(rowKey => {
                var tr = document.createElement('tr');
                tr.style.borderBottom = '1px solid #1a1a2e';
                
                var th = document.createElement('th');
                th.innerText = labelsMap[rowKey];
                th.style.padding = '8px';
                th.style.background = '#f4f4f6';
                th.style.borderRight = '2px solid #1a1a2e';
                th.style.textAlign = 'left';
                tr.appendChild(th);

                cols.forEach(colKey => {
                    var val = data.correlation[rowKey][colKey];
                    var td = document.createElement('td');
                    td.innerText = val.toFixed(3);
                    td.style.padding = '8px';
                    td.style.borderRight = '1px solid #e2e8f0';
                    
                    // Heatmap colors based on correlation strength
                    var opacity = Math.abs(val);
                    if (val === 1) {
                        td.style.background = 'rgba(78,205,196,1)';
                        td.style.color = '#fff';
                    } else if (val > 0) {
                        td.style.background = `rgba(78,205,196,${opacity})`;
                    } else if (val < 0) {
                        td.style.background = `rgba(255,107,157,${opacity})`;
                    } else {
                        td.style.background = '#fff';
                    }
                    tr.appendChild(td);
                });
                tbody.appendChild(tr);
            });

            // 2. K-Means Clusters
            var clusterDatasets = [
                { label: 'Cluster 0 (Regular)', data: [], backgroundColor: '#4ECDC4', borderColor: '#1a1a2e', borderWidth: 1.5, pointRadius: 5 },
                { label: 'Cluster 1 (Low-Value)', data: [], backgroundColor: '#FF6B9D', borderColor: '#1a1a2e', borderWidth: 1.5, pointRadius: 5 },
                { label: 'Cluster 2 (VIP)', data: [], backgroundColor: '#FFD700', borderColor: '#1a1a2e', borderWidth: 1.5, pointRadius: 5 }
            ];
            data.segments.forEach(item => {
                clusterDatasets[item.cluster].data.push({ x: item.total_spending, y: item.num_orders });
            });

            new Chart(document.getElementById('clusterScatterChart'), {
                type: 'scatter',
                data: { datasets: clusterDatasets },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { title: { display: true, text: 'Total Spending (PKR)', font: { family: "'Space Grotesk'" } } },
                        y: { title: { display: true, text: 'Number of Orders', font: { family: "'Space Grotesk'" } } }
                    },
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: "'Space Grotesk'" } } }
                    }
                }
            });

            // 3. Customer Age vs Total Spending Scatter
            var scatterAgeSpending = data.scatter.map(s => ({ x: s.age, y: s.total_amount }));
            new Chart(document.getElementById('ageSpendingChart'), {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Spending',
                        data: scatterAgeSpending,
                        backgroundColor: '#A855F7',
                        borderColor: '#1a1a2e',
                        borderWidth: 1,
                        pointRadius: 4.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { title: { display: true, text: 'Age', font: { family: "'Space Grotesk'" } } },
                        y: { title: { display: true, text: 'Spending per Order (PKR)', font: { family: "'Space Grotesk'" } } }
                    }
                }
            });

            // 4. Session Duration vs Order Amount Scatter
            var scatterSessionSpending = data.scatter.map(s => ({ x: s.session_duration_min, y: s.total_amount }));
            new Chart(document.getElementById('sessionSpendingChart'), {
                type: 'scatter',
                data: {
                    datasets: [{
                        label: 'Spending',
                        data: scatterSessionSpending,
                        backgroundColor: '#FF6B9D',
                        borderColor: '#1a1a2e',
                        borderWidth: 1,
                        pointRadius: 4.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { title: { display: true, text: 'Session Duration (min)', font: { family: "'Space Grotesk'" } } },
                        y: { title: { display: true, text: 'Spending per Order (PKR)', font: { family: "'Space Grotesk'" } } }
                    }
                }
            });

            // 5. Age Distribution
            var ageBins = {};
            for (var i = 18; i <= 65; i += 3) {
                ageBins[`${i}-${i+2}`] = 0;
            }
            data.ages.forEach(age => {
                var binStart = Math.floor((age - 18) / 3) * 3 + 18;
                var key = `${binStart}-${binStart+2}`;
                if (ageBins[key] !== undefined) ageBins[key]++;
            });

            new Chart(document.getElementById('ageDistChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(ageBins),
                    datasets: [{
                        label: 'Count',
                        data: Object.values(ageBins),
                        backgroundColor: '#A855F7',
                        borderColor: '#1a1a2e',
                        borderWidth: 1.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { beginAtZero: true }
                    }
                }
            });

            // 6. Spending Distribution & Normal Bell Curve
            var amountBins = {};
            var binSize = 1500;
            for (var i = 500; i < 20000; i += binSize) {
                amountBins[`${i}-${i+binSize-1}`] = 0;
            }
            data.amounts.forEach(amt => {
                var binStart = Math.floor((amt - 500) / binSize) * binSize + 500;
                var key = `${binStart}-${binStart+binSize-1}`;
                if (amountBins[key] !== undefined) amountBins[key]++;
            });

            new Chart(document.getElementById('amountDistChart'), {
                type: 'bar',
                data: {
                    labels: Object.keys(amountBins),
                    datasets: [{
                        label: 'Frequency',
                        data: Object.values(amountBins),
                        backgroundColor: '#4ECDC4',
                        borderColor: '#1a1a2e',
                        borderWidth: 1.5
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false }, ticks: { maxRotation: 45 } },
                        y: { beginAtZero: true }
                    }
                }
            });

            // 7. Stacked Category by Gender
            var categories = [...new Set(data.gender_category.map(gc => gc.product_category))];
            var maleTotals = categories.map(cat => {
                var found = data.gender_category.find(gc => gc.product_category === cat && gc.gender === 'Male');
                return found ? found.total : 0;
            });
            var femaleTotals = categories.map(cat => {
                var found = data.gender_category.find(gc => gc.product_category === cat && gc.gender === 'Female');
                return found ? found.total : 0;
            });

            new Chart(document.getElementById('genderCategoryChart'), {
                type: 'bar',
                data: {
                    labels: categories,
                    datasets: [
                        { label: 'Male', data: maleTotals, backgroundColor: '#4ECDC4', borderColor: '#1a1a2e', borderWidth: 2 },
                        { label: 'Female', data: femaleTotals, backgroundColor: '#FF6B9D', borderColor: '#1a1a2e', borderWidth: 2 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        x: { stacked: true, grid: { display: false }, ticks: { maxRotation: 45 } },
                        y: { stacked: true, beginAtZero: true }
                    },
                    plugins: {
                        legend: { position: 'top', labels: { font: { family: "'Space Grotesk'" } } }
                    }
                }
            });

            // 8. Category average unit price
            new Chart(document.getElementById('categoryPriceChart'), {
                type: 'bar',
                data: {
                    labels: data.category_price.map(cp => cp.product_category),
                    datasets: [{
                        label: 'Avg Unit Price (PKR)',
                        data: data.category_price.map(cp => cp.avg_price),
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
                        x: { grid: { display: false }, ticks: { maxRotation: 45 } },
                        y: { beginAtZero: true }
                    }
                }
            });

            // 9. Payment satisfaction score
            new Chart(document.getElementById('paymentSatisfactionChart'), {
                type: 'bar',
                data: {
                    labels: data.payment_satisfaction.map(ps => ps.payment_method),
                    datasets: [{
                        label: 'Avg Score (1-5)',
                        data: data.payment_satisfaction.map(ps => ps.avg_score),
                        backgroundColor: '#4ECDC4',
                        borderColor: '#1a1a2e',
                        borderWidth: 2
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        x: { grid: { display: false } },
                        y: { min: 1, max: 5 }
                    }
                }
            });
        });
</script>
@endsection
