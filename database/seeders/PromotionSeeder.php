<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PromotionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotions = [
            [
                'name' => 'Bronze',
                'price' => 10.99,
                'duration' => '1', //giorni
            ],
            [
                'name' => 'Silver',
                'price' => 25.99,
                'duration' => '3', //giorni
            ],
            [
                'name' => 'Gold',
                'price' => 50,
                'duration' => '7', //giorni
            ]
        ];
        foreach ($promotions as $promotion) {
            $new_promo = new Promotion();
            $promotion['slug'] = Str::slug($promotion['name']);
            $new_promo::create($promotion);
        }
    }
}
