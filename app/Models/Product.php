<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = ['name', 'description', 'price', 'quantity'];


    public function orderProduct()
    {
        return $this->hasMany(OrderProduct::class, 'product_id');
    }
}
