<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
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
        'user_id'
    ];

    protected $casts = [
        'coupon' => 'array',  // json → otomatis array
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'admin_fee' => 'decimal:2',
        'vat' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    // relasi: order dimiliki oleh user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi: order memiliki banyak detail
    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
