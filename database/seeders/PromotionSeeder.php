<?php

namespace Database\Seeders;

use App\Models\Promotion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
                'name' => 'bronze',
                'price' => 10.99,
                'duration' => '1', //giorni
            ],
            [
                'name' => 'silver',
                'price' => 25.99,
                'duration' => '3', //giorni
            ],
            [
                'name' => 'gold',
                'price' => 50,
                'duration' => '7', //giorni
            ]
        ];
        foreach ($promotions as $promotion) {
            $new_promo = new Promotion();
            $new_promo::create($promotion);
        }
    }
}
