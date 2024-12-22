<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class RenderController extends Controller
{
    public function newProduct()
    {
        return Inertia::render('Products/NewProduct');
    }

    public function cart()
    {
        return Inertia::render('Cart/CartVIew');
    }
    public function orders()
    {
        return Inertia::render('Order/Orders');
    }
}
