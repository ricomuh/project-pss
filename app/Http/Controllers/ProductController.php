<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->paginate(10);

        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|unique:products',
            'description' => '',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        // $product = Product::create($request->all());
        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'image_url' => asset('storage/' . $imagePath),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json(['message' => 'Product created successfully', 'product' => $product], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            // 'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|unique:products,name,' . $product->id,
            'description' => '',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
        ]);

        // $product->update($request->all());
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $image_url = asset('storage/' . $imagePath);
        }

        $product->update([
            'image_url' => $image_url ?? $product->image_url,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        return response()->json(['message' => 'Product updated successfully', 'product' => $product]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json(['message' => 'Product deleted successfully']);
    }
}
