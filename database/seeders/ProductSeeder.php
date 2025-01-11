<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $blangkon = collect([
            [
                'name' => 'Blangkon Jawa',
                'image_url' => 'jawa.jpg',
                'price' => 35_000,
            ],
            [
                'name' => 'Blangkon Madura',
                'image_url' => 'madura.jpg',
                'price' => 20_000,
            ],
            [
                'name' => 'Blangkon Bali',
                'image_url' => 'bali.jpg',
                'price' => 40_000,
            ],
            [
                'name' => 'Blangkon Sunda',
                'image_url' => 'sunda.png',
                'price' => 30_000,
            ],
            [
                'name' => 'Blangkon Jogja',
                'image_url' => 'jogja.jpg',
                'price' => 55_000,
            ]
        ]);

        $blangkon->each(function ($blangkon) {
            \App\Models\Product::factory()->create([
                'name' => $blangkon['name'],
                'image_url' => asset('storage/' . $blangkon['image_url']),
                'price' => $blangkon['price'],
            ]);
        });
    }
}
