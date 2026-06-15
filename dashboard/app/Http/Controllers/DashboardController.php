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
        $segments = Order::select('customer_id',
            DB::raw('SUM(total_amount) as total_spent'),
            DB::raw('COUNT(*) as order_count'),
            DB::raw('AVG(session_duration_min) as avg_session'))
            ->groupBy('customer_id')->get();

        $spending = Order::select(
            DB::raw("CASE
                WHEN total_amount < 3000 THEN 'Low'
                WHEN total_amount < 8000 THEN 'Medium'
                WHEN total_amount < 15000 THEN 'High'
                ELSE 'Very High' END as level"),
            DB::raw('COUNT(*) as count'))
            ->groupBy('level')->get();

        return response()->json([
            'segments' => $segments,
            'spending' => $spending
        ]);
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
