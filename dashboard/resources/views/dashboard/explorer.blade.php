@extends('layouts.app')

@section('title', 'Data Explorer')

@section('content')
<div class="page-header">
    <h1 class="page-title">Data Explorer</h1>
    <p class="page-subtitle">Browse and filter the raw dataset</p>
</div>

<form method="GET" action="{{ route('explorer') }}">
    <div class="filter-bar">
        <label>Category</label>
        <select name="category" class="filter-select" id="filter-category">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
                <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
            @endforeach
        </select>

        <label>City</label>
        <select name="city" class="filter-select" id="filter-city">
            <option value="">All Cities</option>
            @foreach($cities as $city)
                <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
            @endforeach
        </select>

        <label>Gender</label>
        <select name="gender" class="filter-select" id="filter-gender">
            <option value="">All</option>
            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
        </select>

        <button type="submit" class="btn btn-teal">
            <i data-lucide="search" style="width:16px;height:16px"></i>
            Filter
        </button>

        <a href="{{ route('explorer') }}" class="btn btn-yellow">
            <i data-lucide="rotate-ccw" style="width:16px;height:16px"></i>
            Reset
        </a>
    </div>
</form>

<div class="chart-card">
    <div class="chart-title">
        <i data-lucide="table"></i>
        Orders ({{ $orders->total() }} total)
    </div>
    <div style="overflow-x: auto;">
        <table class="data-table" id="data-table">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Date</th>
                    <th>Category</th>
                    <th>Product</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>City</th>
                    <th>Score</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                <tr>
                    <td><strong>{{ $order->order_id }}</strong></td>
                    <td>{{ $order->customer_name }}</td>
                    <td>{{ $order->order_date->format('d M Y') }}</td>
                    <td><span class="badge badge-teal">{{ $order->product_category }}</span></td>
                    <td>{{ $order->product_name }}</td>
                    <td><strong>PKR {{ number_format($order->total_amount) }}</strong></td>
                    <td>{{ $order->payment_method }}</td>
                    <td>{{ $order->city }}</td>
                    <td>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $order->satisfaction_score)
                                <span style="color: #FFD700;">★</span>
                            @else
                                <span style="color: #ddd;">★</span>
                            @endif
                        @endfor
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="pagination-bar">
        @if($orders->onFirstPage())
            <span style="opacity:0.4">&laquo;</span>
        @else
            <a href="{{ $orders->previousPageUrl() }}">&laquo;</a>
        @endif

        @foreach($orders->getUrlRange(max(1, $orders->currentPage()-2), min($orders->lastPage(), $orders->currentPage()+2)) as $page => $url)
            @if($page == $orders->currentPage())
                <span class="active-page">{{ $page }}</span>
            @else
                <a href="{{ $url }}">{{ $page }}</a>
            @endif
        @endforeach

        @if($orders->hasMorePages())
            <a href="{{ $orders->nextPageUrl() }}">&raquo;</a>
        @else
            <span style="opacity:0.4">&raquo;</span>
        @endif
    </div>
</div>
@endsection
