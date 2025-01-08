<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderProduct>
 */
class OrderProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        $quantity = $this->faker->numberBetween(1, 2);
        return [
            'order_id' => 1,
            // 'product_id' => Product::inRandomOrder()->first()->id,
            'product_id' => $product->id,
            // 'quantity' => $this->faker->numberBetween(1, 10),
            'quantity' => $quantity,
            'price' => $product->price * $quantity,
        ];
    }
}
