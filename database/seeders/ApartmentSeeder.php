<?php

namespace Database\Seeders;

use App\Models\Apartment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
        $apartments = config('apartments.apartments');
        foreach ($apartments as $apartment) {
            $apartment['price'] = 39.99;
            $apartment['slug'] = Str::slug($apartment['title']);
            $new_apartment = Apartment::make($apartment);
            $new_apartment->save();
        }
    }
}
