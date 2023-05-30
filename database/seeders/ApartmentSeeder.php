<?php

namespace Database\Seeders;

use App\Models\Apartment;
use App\Models\Service;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

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
        $tomtom_key = 'FiLLCEGWt31cQ9ECIWAD6zYjczzeC6zn';
        foreach ($apartments as $apartment) {
            $allServices = Service::all()->toArray();
            //dd($allServices);
            $numberOfServices = rand(1, count($allServices) - 1);
            $apartmentServices = [];

            for ($i = 0; $i < $numberOfServices; $i++) {
                $serviceToAdd = rand(0, count($allServices) - 1);
                array_push($apartmentServices, $allServices["$serviceToAdd"]['id']);
            }

            //dd($apartmentServices);
            $apartment['price'] = floatval(number_format($apartment['price'], 2));
            //dd($apartment['price']);
            $apartment['slug'] = Str::slug($apartment['title']);
            try {
                $response = Http::get('https://api.tomtom.com/search/2/geocode/' . $apartment['address'] . '.json?key=' . $tomtom_key);
                $json = $response->json();


                if (isset($json['results']) && count($json['results']) > 0) {
                    if (isset($json['results'][0]['position']['lat']) && isset($json['results'][0]['position']['lon']) && isset($json['results'][0]['address']['freeformAddress'])) {
                        $apartment['latitude'] = $json['results'][0]['position']['lat'];
                        $apartment['longitude'] =  $json['results'][0]['position']['lon'];
                        $apartment['free_form_address'] = $json['results'][0]['address']['freeformAddress'];
                    } else {
                        continue;
                    }
                } else {
                    continue;
                }
            } catch (\Exception $e) {
                var_dump($e->getMessage());
            }
            $new_apartment = Apartment::create($apartment);
            $new_apartment->services()->syncWithoutDetaching($apartmentServices); 

            //dd($new_apartment->services);

        }
    }
}
