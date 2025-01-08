<?php

namespace Database\Seeders;

use App\Models\OrderProduct;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // generate 10 users
        $users = User::factory()->count(10)->create();


        // generate 2 orders for each user
        $users->each(function ($user) {
            $orders = $user->orders()->saveMany(\App\Models\Order::factory()->count(2)->make());

            // generate 3 products for each order
            $orders->each(function ($order) use ($user) {
                $products = OrderProduct::factory()->count(3)->create([
                    'order_id' => $order->id,
                    // 'user_id' => $user->id,
                ]);

                // calculate total price for each order
                $totalPrice = $products->sum('price');
                $order->update(['total_price' => $totalPrice]);
            });
        });
    }
}
