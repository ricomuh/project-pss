<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->with('products', 'user')->paginate(10);

        return view('admin.orders.index', compact('orders'));
    }
}
