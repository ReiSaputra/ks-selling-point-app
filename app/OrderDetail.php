<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'order_details';

    protected $fillable = [
        'order_id',
        'product_sku',
        'price',
        'actual_price',
        'product_cost',
        'quantity',
        'subtotal'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'actual_price' => 'decimal:2',
        'product_cost' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    // relasi ke order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
