<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{

    public function index()
    {
        return view('shopping.index');
    }

    public function store(Product $product, Request $request)
    {
        cart()->add($product->id, $product->name, 1, $product->price);

        return view('layouts._cart')->render();
    }
}
