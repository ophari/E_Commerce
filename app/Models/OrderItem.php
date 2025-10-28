<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Setiap item milik 1 order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Setiap item terhubung ke 1 produk
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
