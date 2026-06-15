<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';
    public $timestamps = false;

    protected $fillable = [
        'customer_id', 'customer_name', 'age', 'gender', 'city',
        'registration_date', 'order_id', 'order_date', 'product_category',
        'product_name', 'unit_price', 'quantity', 'total_amount',
        'payment_method', 'discount_applied', 'discount_percent',
        'satisfaction_score', 'session_duration_min', 'device_type',
        'num_previous_purchases'
    ];

    protected $casts = [
        'order_date' => 'date',
        'registration_date' => 'date',
    ];
}
