<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = Order::distinct('customer_id')->count('customer_id');
        $avgOrder = Order::avg('total_amount');

        return view('dashboard.index', compact(
            'totalSales', 'totalOrders', 'totalCustomers', 'avgOrder'
        ));
    }

    public function customers()
    {
        $genderSplit = Order::select('gender', DB::raw('COUNT(DISTINCT customer_id) as count'))
            ->groupBy('gender')->get();

        $ageGroups = Order::select(
            DB::raw("CASE
                WHEN age BETWEEN 18 AND 25 THEN '18-25'
                WHEN age BETWEEN 26 AND 35 THEN '26-35'
                WHEN age BETWEEN 36 AND 45 THEN '36-45'
                WHEN age BETWEEN 46 AND 55 THEN '46-55'
                ELSE '56-65' END as age_group"),
            DB::raw('COUNT(DISTINCT customer_id) as count')
        )->groupBy('age_group')->get();

        $topCustomers = Order::select('customer_id', 'customer_name', 'city',
            DB::raw('SUM(total_amount) as total_spent'),
            DB::raw('COUNT(*) as order_count'))
            ->groupBy('customer_id', 'customer_name', 'city')
            ->orderByDesc('total_spent')
            ->limit(10)->get();

        return view('dashboard.customers', compact(
            'genderSplit', 'ageGroups', 'topCustomers'
        ));
    }

    public function sales()
    {
        $categorySales = Order::select('product_category',
            DB::raw('SUM(total_amount) as total'),
            DB::raw('COUNT(*) as orders'))
            ->groupBy('product_category')
            ->orderByDesc('total')->get();

        $citySales = Order::select('city',
            DB::raw('SUM(total_amount) as total'))
            ->groupBy('city')
            ->orderByDesc('total')->get();

        return view('dashboard.sales', compact('categorySales', 'citySales'));
    }

    public function eda()
    {
        return view('dashboard.eda');
    }

    public function explorer(Request $request)
    {
        $query = Order::query();

        if ($request->category) {
            $query->where('product_category', $request->category);
        }
        if ($request->city) {
            $query->where('city', $request->city);
        }
        if ($request->gender) {
            $query->where('gender', $request->gender);
        }

        $orders = $query->orderByDesc('order_date')->paginate(25);
        $categories = Order::distinct()->pluck('product_category');
        $cities = Order::distinct()->pluck('city');

        return view('dashboard.explorer', compact('orders', 'categories', 'cities'));
    }

    public function chartData()
    {
        $monthly = Order::select(
            DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as total'))
            ->groupBy('month')->orderBy('month')->get();

        $categories = Order::select('product_category',
            DB::raw('SUM(total_amount) as total'))
            ->groupBy('product_category')
            ->orderByDesc('total')->get();

        $payments = Order::select('payment_method',
            DB::raw('COUNT(*) as count'))
            ->groupBy('payment_method')->get();

        $devices = Order::select('device_type',
            DB::raw('COUNT(*) as count'))
            ->groupBy('device_type')->get();

        return response()->json([
            'monthly' => $monthly,
            'categories' => $categories,
            'payments' => $payments,
            'devices' => $devices
        ]);
    }

    public function salesData()
    {
        $monthly = Order::select(
            DB::raw("DATE_FORMAT(order_date, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as total'),
            DB::raw('COUNT(*) as orders'))
            ->groupBy('month')->orderBy('month')->get();

        $daily = Order::select(
            DB::raw("DAYNAME(order_date) as day_name"),
            DB::raw('AVG(total_amount) as avg_amount'),
            DB::raw('COUNT(*) as orders'))
            ->groupBy('day_name')->get();

        return response()->json([
            'monthly' => $monthly,
            'daily' => $daily
        ]);
    }

    public function customerData()
    {
        $spending = Order::select(
            DB::raw("CASE
                WHEN total_amount < 3000 THEN 'Low'
                WHEN total_amount < 8000 THEN 'Medium'
                WHEN total_amount < 15000 THEN 'High'
                ELSE 'Very High' END as level"),
            DB::raw('COUNT(*) as count'))
            ->groupBy('level')->get();

        return response()->json([
            'spending' => $spending
        ]);
    }

    public function edaData()
    {
        // 1. Correlation Matrix
        $orders = Order::select('age', 'unit_price', 'quantity', 'total_amount', 'satisfaction_score', 'session_duration_min')->get();
        $cols = ['age', 'unit_price', 'quantity', 'total_amount', 'satisfaction_score', 'session_duration_min'];
        $correlation = [];
        
        foreach ($cols as $c1) {
            $correlation[$c1] = [];
            foreach ($cols as $c2) {
                $correlation[$c1][$c2] = round($this->getCorrelation($c1, $c2, $orders), 3);
            }
        }

        // 2. Scatter Samples
        $scatterSample = Order::select('age', 'total_amount', 'session_duration_min', 'product_category', 'quantity', 'customer_name', 'city')
            ->inRandomOrder(42)->limit(200)->get();

        // 3. Customer Segments (K-Means representation)
        $customers = Order::select('customer_id',
            DB::raw('SUM(total_amount) as total_spending'),
            DB::raw('COUNT(*) as num_orders'),
            DB::raw('AVG(session_duration_min) as avg_session'))
            ->groupBy('customer_id')->get();
            
        $segments = [];
        foreach ($customers as $c) {
            $spending = $c->total_spending;
            $ordersCount = $c->num_orders;
            
            // Replicate cluster thresholds matching python K-Means results:
            if ($spending >= 15000) {
                $cluster = 2; // VIP
            } elseif ($spending <= 5000) {
                $cluster = 1; // Inactive
            } else {
                $cluster = 0; // Regular
            }
            
            $segments[] = [
                'total_spending' => $spending,
                'num_orders' => $ordersCount,
                'cluster' => $cluster
            ];
        }

        // 4. Age and Amount Distribution
        $ages = Order::select('age')->pluck('age')->toArray();
        $amounts = Order::select('total_amount')->pluck('total_amount')->toArray();

        // 5. Stacked Category by Gender
        $genderCategory = Order::select('product_category', 'gender', DB::raw('SUM(total_amount) as total'))
            ->groupBy('product_category', 'gender')->get();

        // 6. Satisfaction by Payment Method
        $paymentSatisfaction = Order::select('payment_method', DB::raw('AVG(satisfaction_score) as avg_score'))
            ->groupBy('payment_method')->get();

        // 7. Price by Category
        $categoryPrice = Order::select('product_category', DB::raw('AVG(unit_price) as avg_price'))
            ->groupBy('product_category')->get();

        return response()->json([
            'correlation' => $correlation,
            'scatter' => $scatterSample,
            'segments' => $segments,
            'ages' => $ages,
            'amounts' => $amounts,
            'gender_category' => $genderCategory,
            'payment_satisfaction' => $paymentSatisfaction,
            'category_price' => $categoryPrice
        ]);
    }

    private function getCorrelation($col1, $col2, $data)
    {
        $n = count($data);
        if ($n === 0) return 0;
        
        $sum1 = 0;
        $sum2 = 0;
        foreach ($data as $row) {
            $sum1 += $row->$col1;
            $sum2 += $row->$col2;
        }
        $mean1 = $sum1 / $n;
        $mean2 = $sum2 / $n;
        
        $num = 0;
        $den1 = 0;
        $den2 = 0;
        foreach ($data as $row) {
            $diff1 = $row->$col1 - $mean1;
            $diff2 = $row->$col2 - $mean2;
            $num += $diff1 * $diff2;
            $den1 += $diff1 * $diff1;
            $den2 += $diff2 * $diff2;
        }
        
        if ($den1 * $den2 == 0) return 0;
        return $num / sqrt($den1 * $den2);
    }

    public function explorerData(Request $request)
    {
        $query = Order::query();

        if ($request->category) {
            $query->where('product_category', $request->category);
        }
        if ($request->city) {
            $query->where('city', $request->city);
        }

        $data = $query->orderByDesc('order_date')->limit(100)->get();

        return response()->json($data);
    }
}
