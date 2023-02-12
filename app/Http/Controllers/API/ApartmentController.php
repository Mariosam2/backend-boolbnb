<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchApartmentRequest;
use App\Models\Apartment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

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
                $tomtomKey = 'Ad83Ah6WsxYFXscdqk3lFXmhKanlaKHs';
                $val_data = $validator->validate();
                //dd($val_data);
                //genero dei poi utilizzabili nella richiesta all'API di tomtom
                $apartments = Apartment::where('id', '>', 53)->get();
                //dd($apartments);
                $poiList = [];
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
                    //dd($poiObj);
                    array_push($poiList, $poiObj);
                }

                $poiList = json_encode($poiList);
                //dd($poi_list);
                if (isset($val_data['address'])) {
                    $geocodeURL = 'https://api.tomtom.com/search/2/geocode/';
                    $searchURL = 'https://api.tomtom.com/search/2/';
                    $ext = '.json';
                    //ricerca delle coordinate trai i POIs(i nostri appartamenti)
                    $coordinates = Http::get($geocodeURL . $val_data['address'] . '.json?key=' . $tomtomKey);

                    //dd($coordinates->json());
                    $latitude = $coordinates->json()['results'][0]['position']['lat'];
                    $longitude = $coordinates->json()['results'][0]['position']['lon'];
                    //dd($latitude, $longitude);
                    $apartments = Apartment::where('id', '>', 53)->get();


                    if (isset($val_data['radius'])) {
                        $geometryList = [
                            [
                                "type" => "CIRCLE",
                                "position" => $latitude . "," . $longitude,
                                "radius" => $val_data['radius']
                            ]
                        ];
                    } else {
                        $defaultRadius = 5000000000000000000;
                        $geometryList = json_encode(
                            [
                                [
                                    "type" => "CIRCLE",
                                    "position" => $latitude . "," . $longitude,
                                    "radius" => $defaultRadius
                                ],

                            ]

                        );
                    }
                    //dd($searchURL . $val_data['address'] . $ext . "?key=$tomtomKey" . "&geometryList=$geometryList" . "&poiList=$poiList");
                    $response = Http::withHeaders([
                        'Content-Type' => 'application/json',
                    ])->get($searchURL . $val_data['address'] . $ext . "?key=$tomtomKey" . "&geometryList=$geometryList" . "&poiList=$poiList");
                    dd($response);
                    'https://api.tomtom.com/search/2/geometryFilter.json?key=YGPPPcjrCpANYtSn288ooufuEQbCob9Y&geometryList=[
                        {
                          "type": "CIRCLE",
                          "position": "40.80558, -73.96548",
                          "radius": 100
                        },
                        {
                          "type": "POLYGON",
                          "vertices": [
                            "37.7524152343544, -122.43576049804686",
                            "37.70660472542312, -122.43301391601562",
                            "37.712059855877314, -122.36434936523438",
                            "37.75350561243041, -122.37396240234374"
                          ]
                        }
                      ]
                      &poiList=[
                        {
                          "poi": {
                            "name": "S Restaurant Toms"
                          },
                          "address": {
                            "freeformAddress": "2880 Broadway, New York, NY 10025"
                          },
                          "position": {
                            "lat": 40.80558,
                            "lon": -73.96548
                          }
                        },
                        {
                          "poi": {
                            "name": "Yasha Raman Corporation"
                          },
                          "address": {
                            "freeformAddress": "940 Amsterdam Ave, New York, NY 10025"
                          },
                          "position": {
                            "lat": 40.80076,
                            "lon": -73.96556
                          }
                        }
                      ]'
                }
                if (isset($val_data['category'])) {
                    //ricerca in base alla categoria
                }
                if (isset($val_data['services'])) {
                    //filtraggio della ricerca in base ai servizi
                } else {
                }
            } catch (\Exception $e) {
                /* return response()->json([
                    'success' => false,
                    'results' => 'invalid request'
                ]); */

                dd($e);
            }
        }
    }
}
