<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchApartmentRequest;
use App\Models\Apartment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Client\Factory;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Support\Facades\DB;

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
                $tomtomKey = 'FiLLCEGWt31cQ9ECIWAD6zYjczzeC6zn';
                $val_data = $validator->validate();

                //genero dei poi utilizzabili nella richiesta all'API di tomtom
                $apartments = Apartment::all();
                $poiLists = [];
                foreach ($apartments as $apartment) {
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
                    array_push($poiLists, $poiObj);
                }
                $poiLists = array_chunk($poiLists, 20);


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
                        $client = new Client();
                        $promise = $client->postAsync($searchURL . 'geometryFilter' . $ext . "?key=$tomtomKey", [
                            'json' => [
                                'poiList' => $poiList,
                                'geometryList' => $geometryList,
                            ]
                        ]);

                        $response = $promise->wait();

                        array_push($results, json_decode($response->getBody()->getContents(), true)['results']);
                    }

                    //dd($results);
                    $coordinates = [];
                    foreach ($results as $result) {
                        if (count($result) > 0) {
                            foreach ($result as $poi) {
                                if (!in_array($poi['position'], $coordinates)) {
                                    array_push($coordinates, $poi['position']);
                                }
                            };
                        }
                    }
                    //dd($coordinates);

                    $searchedApartments = [];
                    foreach ($coordinates as $coordinate) {
                        $searchedApartment = Apartment::with(['services'])->where([
                            ['latitude', '=', $coordinate['lat']],
                            ['longitude', '=', $coordinate['lon']],
                        ])->get();
                        $searchedApartments = collect($searchedApartments)->merge($searchedApartment);
                    }

                    //dd($searchedApartments);


                    if (isset($val_data['services'])) {
                        //dd($val_data['services']);
                        $services = $val_data['services'];
                        //dd($searchedApartments);

                        $filteredApartaments = [];

                        foreach ($searchedApartments as $searchedApartment) {
                            /* if (count($searchedApartment->services()->get()) > 0) {
                                dd($searchedApartment->services()->pluck('id')->toArray());
                            } */

                            if (array_intersect($searchedApartment->services()->pluck('id')->toArray(), $services)) {
                                array_push($filteredApartaments, $searchedApartment);
                            }
                        }



                        return response()->json([
                            'success' => true,
                            'results' => $filteredApartaments
                        ]);
                    }


                    //dd($searchedApartments);


                    return response()->json([
                        'success' => true,
                        'results' => $searchedApartments
                    ]);
                }
                /*
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
