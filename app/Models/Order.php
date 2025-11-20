<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'marketplace_invoice',
        'channel',
        'subtotal',
        'discount',
        'shipping_cost',
        'order_status',
        'expedition',
        'shipping_receipt',
        'note',
        'coupon',
        'admin_fee',
        'vat',
        'total',
        'payment_type',
    ];

    protected $casts = [
        'coupon' => 'array',
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'vat' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
