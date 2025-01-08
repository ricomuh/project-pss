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
            ],
            [
                'name' => 'Blangkon Madura',
                'image_url' => 'madura.jpg',
            ],
            [
                'name' => 'Blangkon Bali',
                'image_url' => 'bali.jpg',
            ],
            [
                'name' => 'Blangkon Sunda',
                'image_url' => 'sunda.png',
            ],
            [
                'name' => 'Blangkon Jogja',
                'image_url' => 'jogja.jpg',
            ]
        ]);

        $blangkon->each(function ($blangkon) {
            \App\Models\Product::factory()->create([
                'name' => $blangkon['name'],
                'image_url' => asset('storage/' . $blangkon['image_url']),
            ]);
        });
    }
}
