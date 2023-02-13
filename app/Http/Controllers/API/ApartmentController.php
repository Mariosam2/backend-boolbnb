<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchApartmentRequest;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Client\Factory;

class ApartmentController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'results' => Apartment::with(['user', 'services', 'views', 'promotions', 'apartment_category'])->paginate(6)
        ]);
    }
    public function show($slug)
    {
        $apartment = Apartment::with('user', 'services', 'views', 'promotions', 'apartment_category')->where('slug', $slug)->first();

        if ($apartment) {
            return response()->json([
                'success' => true,
                'results' => $apartment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => 'apartment not found'
            ]);
        }
    }

    public function search(Request $request)
    {
        //dd($request->services);
        $data = [
            'address' => $request->address,
            'category' => $request->category,
            'services' => $request->services
        ];

        //dd($data);

        $validator = Validator::make($data, [
            'address' => 'nullable|max:255',
            'category' => 'nullable|exists:apartment_categories,id',
            'services' => 'nullable|array|exists:services,id'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => 'invalid request'
            ]);
        } else {
            try {
                $tomtomKey = '2oYOFMUxTa7zG8bZAccJS6LcDFhFLr37';
                $maxSize = 3000;
                $val_data = $validator->validate();

                //genero dei poi utilizzabili nella richiesta all'API di tomtom
                $apartments = Apartment::all();
                $poiLists = [];
                $tempArray = [];
                $checkArray = [];
                foreach ($apartments as $key => $apartment) {
                    $poiObj = [
                        "poi" => [
                            "name" => $apartment->title,
                        ],
                        "address" => [
                            "freeformAddress" => $apartment->free_form_address
                        ],
                        "position" => [
                            "lat" => $apartment->latitude,
                            "lon" => $apartment->longitude
                        ]
                    ];
                    //creo dei subArray che rispettino le dimensioni gestibili dal server di tomtom
                    if ($key + 1 <= count($apartments) - 1) {
                        //utilizzo checkArray per controllare la size dell'array da usare per la richiesta a tomtom
                        $checkArray = array_merge($tempArray, [$apartments[$key + 1]]);
                        if (strlen(json_encode($checkArray)) < $maxSize) {
                            //continuo a pushare nella tempArray
                            array_push($tempArray, $poiObj);
                        } else {
                            //pusho la tempArray dentro la mia list di pois
                            array_push($tempArray, $poiObj);
                            array_push($poiLists, $tempArray);
                            $tempArray = [];
                        }
                    } else {
                        //pusho anche gli elementi alle ultime posizioni
                        array_push($tempArray, $poiObj);
                        array_push($poiLists, $tempArray);
                    }
                }

                //dd($poiLists);






                if (isset($val_data['address'])) {
                    $geocodeURL = 'https://api.tomtom.com/search/2/geocode/';
                    $searchURL = 'https://api.tomtom.com/search/2/';
                    $ext = '.json';

                    //ricerca delle coordinate trai i POIs(i nostri appartamenti)
                    $coordinates = Http::get($geocodeURL . $val_data['address'] . '.json?key=' . $tomtomKey);

                    $latitude = $coordinates->json()['results'][0]['position']['lat'];
                    $longitude = $coordinates->json()['results'][0]['position']['lon'];




                    if (isset($val_data['radius'])) {
                        $geometryList = [
                            [
                                "type" => "CIRCLE",
                                "position" => $latitude . "," . $longitude,
                                "radius" => $val_data['radius']
                            ]
                        ];
                    } else {
                        $defaultRadius = 50000;
                        $geometryList =
                            [
                                [
                                    "type" => "CIRCLE",
                                    "position" => $latitude . "," . $longitude,
                                    "radius" => $defaultRadius
                                ],

                            ];
                    }
                    // prendo i risultati delle chiamate e li metto insieme
                    $results = [];
                    foreach ($poiLists as $poiList) {
                        $response = Http::withHeaders([

                            'Content-Type' => 'application/json',

                        ])->post($searchURL . 'geometryFilter' . $ext . "?key=$tomtomKey", [
                            'poiList' => $poiList,
                            'geometryList' => $geometryList,

                        ]);
                        //var_dump($response->json()['results']);
                        if (isset($response->json()['results'])) {
                            $results = array_merge($results, $response->json()['results']);
                        }
                    }
                    //dd($results);

                    $searchedApartments = [];
                    foreach ($results as $result) {
                        $apartmentsCollection = Apartment::where([
                            ['latitude', '=', $result['position']['lat']],
                            ['longitude', '=', $result['position']['lon']],
                        ])->get();
                        //$searchedApartments = $searchedApartment->merge($searchedApartments);

                    }
                    $searchedApartments = collect($searchedApartments)->merge($apartmentsCollection);

                    //dd($searchedApartments);


                    return response()->json([
                        'success' => true,
                        'results' => $searchedApartments
                    ]);
                }
                /* if (isset($val_data['category'])) {
                    //ricerca in base alla categoria
                }
                if (isset($val_data['services'])) {
                    //filtraggio della ricerca in base ai servizi
                } else {
                } */
            } catch (\Exception $e) {
                /* return response()->json([
                    'success' => false,
                    'results' => 'not found'
                ]); */
                dd($e);
            }
        }
    }
}
