<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->with('products', 'user')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Request $request)
    {
        $orders = Order::where('user_id', auth()->id())->with('products')->get();

        return response()->json($orders);
    }

    // public function order(Request $request)
    // {
    //     $request->validate([
    //         'products' => 'required|array',
    //         'products.*.id' => 'required|exists:products,id',
    //         'products.*.quantity' => 'required|integer|min:1',
    //     ]);

    //     $productIds = array_column($request->products, 'id');
    //     $products = Product::find($productIds);

    //     // begin transaction
    //     DB::beginTransaction();

    //     $order = Order::create([
    //         'user_id' => auth()->id(),
    //         'total_price' => 0,
    //     ]);

    //     $total = 0;

    //     foreach ($request->products as $productData) {
    //         $product = $products->find($productData['id']);
    //         $quantity = $productData['quantity'];
    //         $price = $product->price * $quantity;

    //         OrderProduct::create([
    //             'order_id' => $order->id,
    //             'product_id' => $product->id,
    //             'quantity' => $quantity,
    //             'price' => $price,
    //         ]);

    //         $total += $price;
    //     }

    //     // $products->eachWithKeys(function ($product, $key) use ($request, &$total, $order) {
    //     //     $quantity = $request->products[$key]['quantity'];
    //     //     $price = $product->price * $quantity;

    //     //     OrderProduct::create([
    //     //         'order_id' => $order->id,
    //     //         'product_id' => $product->id,
    //     //         'quantity' => $quantity,
    //     //         'price' => $price,
    //     //     ]);

    //     //     $total += $price;
    //     // });

    //     $order->update(['total_price' => $total]);

    //     // commit transaction
    //     DB::commit();

    //     return response()->json(['message' => 'Order created successfully']);
    // }

    public function order(Request $request)
    {
        $request->validate([
            'products' => 'required|array',
            'products.*.id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        ]);

        $productIds = array_column($request->products, 'id');
        $products = Product::whereIn('id', $productIds)->get();

        // begin transaction
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => auth()->id(),
                'total_price' => 0,
            ]);

            $total = 0;

            foreach ($request->products as $productData) {
                $product = $products->find($productData['id']);
                $quantity = $productData['quantity'];
                $price = $product->price * $quantity;

                OrderProduct::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price;
            }

            $order->update(['total_price' => $total]);

            // commit transaction
            DB::commit();

            return response()->json(['message' => 'Order created successfully']);
        } catch (\Exception $e) {
            // rollback transaction
            DB::rollBack();

            return response()->json(['message' => 'Order creation failed', 'error' => $e->getMessage()], 500);
        }
    }
}
