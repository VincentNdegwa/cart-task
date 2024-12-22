<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    protected $table = 'order_product';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];


    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }


    public function order()
    {
        return $this->belongTo(Order::class, 'order_id');
    }
}
