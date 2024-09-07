<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create', [
            'product' => new Product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Product::create($this->getParams($request));

        return redirect('/home')->with('success', 'Product created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $product->update($this->getParams($request));

        return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect('/home');
    }

    public function getParams($request)
    {
        $params = $request->all();

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('upload', 'public');
            $params['image'] = $path;
        }

        return $params;
    }
}
