<?php

namespace Database\Seeders;

use App\Models\ApartmentCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Minicasa', 'Luxury', 'Fronte lago', 'Fronte mare', 'Sulle piste', 'Design', 'Dimore storiche', 'Case Galleggianti', 'Case sull\'albero', 'Nel deserto'];

        foreach ($categories as $category) {
            $new_category = new ApartmentCategory();
            $new_category->name = $category;
            $new_category->save();
        }
    }
}
