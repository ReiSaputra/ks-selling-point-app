<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderDetail extends Model
{
    use HasFactory;

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

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
