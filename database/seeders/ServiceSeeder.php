<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = ['Wi-Fi', 'Cucina', 'Lavatrice', 'Asciugatrice', 'Aria condizionata', 'Riscaldamento', 'Spazio di lavoro dedicato', 'Tv', 'Asciugacapelli', 'Ferro da stiro'];

        foreach ($services as $service) {
            $new_service = new Service();
            $new_service->name = $service;
            $new_service->save();
        }
    }
}
