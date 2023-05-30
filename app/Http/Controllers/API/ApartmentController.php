<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchApartmentRequest;
use App\Models\Apartment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use GuzzleHttp\Client;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class ApartmentController extends Controller
{

    public function paginate($items, $perPage = 4, $page = null)
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $total = count($items);
        $currentpage = $page;
        $offset = ($currentpage * $perPage) - $perPage;
        $itemstoshow = array_slice($items, $offset, $perPage);
        return new LengthAwarePaginator($itemstoshow, $total, $perPage);
    }


    public function showCase()
    {
        //sorto gli appartamenti sponsorizzati in base alla promozione che hanno (Gold, Silver o Bronze)
        $apartments = Apartment::where('subscription_id', '!=', null)->with(['user', 'services', 'views', 'subscription', 'apartment_category'])->orderByDesc('id')->get();
        //dd($apartments);

        $sortedApartments = $this->bubbleSortByProduct($apartments);
        $paginatedApartments = $this->paginate($sortedApartments->toArray(), 6);
        $paginatedApartments->setPath('http://127.0.0.1:8000/api/showcase');
        //dd($paginatedApartments);

        return response()->json([
            'success' => true,
            'results' => $paginatedApartments
        ]);
    }

    public function index(Request $request)
    {
        $data = [
            'category' => $request->category,
        ];

        $validator = Validator::make($data, [
            'category' => 'nullable|exists:apartment_categories,id',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => null,
            ]);
        } else {
            $val_data = $validator->validate();
            if (isset($val_data['category'])) {
                //sorto gli appartamenti sponsorizzati in base alla promozione che hanno (Gold, Silver o Bronze)
                $apartments = Apartment::with(['user', 'services', 'views', 'subscription', 'apartment_category'])->where('apartment_category_id', '=', $val_data['category'])->orderByDesc('id')->get();
                //dd($apartments);

            } else {
                //sorto gli appartamenti sponsorizzati in base alla promozione che hanno (Gold, Silver o Bronze)
                $apartments = Apartment::with(['user', 'services', 'views', 'subscription', 'apartment_category'])->orderByDesc('id')->get();
                //dd($apartments);

            }
            $sortedApartments = $this->bubbleSortByProduct($apartments);
            $paginatedApartments = $this->paginate($sortedApartments->toArray(), 6);
            if (isset($val_data['category'])) {
                $paginatedApartments->setPath('http://127.0.0.1:8000/api/apartments?category=' . $val_data['category']);
            } else {
                $paginatedApartments->setPath('http://127.0.0.1:8000/api/apartments');
            }

            //dd($paginatedApartments);

            return response()->json([
                'success' => true,
                'results' => $paginatedApartments
            ]);
        }
    }
    /**
     * Takes a collection of apartments and sort it by type of promotion Gold,Silver,Bronze
     * @param mixed $apartments
     * @return mixed $apartments sorted
     */
    public function bubbleSortByProduct(mixed $apartments)
    {
        $swapped = null;
        do {
            $swapped = false;
            for ($i = 0; $i < count($apartments) - 1; $i++) {
                if ($apartments[$i]->subscription != null && $apartments[$i + 1]->subscription != null) {
                    //faccio le chiamate per ottenere i prodotti collegati all'apartamento
                    $firstProductId = $apartments[$i]->subscription->product->id;
                    $secondProductId = $apartments[$i + 1]->subscription->product->id;
                    //dd($firstProductId, $secondProductId);
                    //ordino gli appartamenti in base all'id dei prodotti
                    if ($secondProductId < $firstProductId) {
                        //swap
                        $temp = $apartments[$i];
                        $apartments[$i] = $apartments[$i + 1];
                        $apartments[$i + 1] = $temp;
                        $swapped = true;
                        //dd($apartments);
                    }
                } else if ($apartments[$i]->subscription == null & $apartments[$i + 1]->subscription != null) {
                    $temp = $apartments[$i];
                    $apartments[$i] = $apartments[$i + 1];
                    $apartments[$i + 1] = $temp;
                    $swapped = true;
                }
            }
        } while ($swapped);
        return $apartments;
    }


    public function show(Apartment $apartment)
    {
        $apartment = $apartment->load('services');
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

    /**
     * Takes an array or a collection of apartments, and creates a poi list
     * @param mixed $apartments 
     * @return array $poiLists
     */
    public function generatePois($apartments)
    {
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
        return $poiLists = array_chunk($poiLists, 20);
    }

    /**
     * Takes the results from tomtom and get the coordinates of the poi without duplication
     * @param array $results
     * @return array $coordinates
     */
    public function getCoordinates(array $results)
    {
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
        return $coordinates;
    }
    /**
     * Takes an array of apartments and services(ids) and returns only the apartments that contain the services
     * @param mixed $searchedApartments
     * @param array $services
     * @return array $filteredApartments the apartments filtered by the given services
     */
    public function filterApartments(mixed $searchedApartments, array $services)
    {
        $filteredApartaments = [];
        foreach ($searchedApartments as $searchedApartment) {

            $isInArray = true;
            foreach ($services as $service) {
                if (in_array($service, $searchedApartment->services()->pluck('id')->toArray())) {
                    continue;
                } else {
                    $isInArray = false;
                }
            }
            if ($isInArray) {
                array_push($filteredApartaments, $searchedApartment);
            }
        }

        return $filteredApartaments;
    }
    /**
     * Takes an array of apartments and a category and filters the apartments by the given category
     * @param mixed $searchedApartments
     * @param string $category
     * @return array $filteredApartments
     */
    public function filterApartmentsByCategory(mixed $searchedApartments, string $category)
    {
        $filteredApartaments = [];
        foreach ($searchedApartments as $searchedApartment) {
            //dd($searchedApartment->apartment_category->id);
            if ($searchedApartment->apartment_category->id == $category) {
                array_push($filteredApartaments, $searchedApartment);
            }
        }

        return $filteredApartaments;
    }

    public function filterApartmentsByBeds(mixed $searchedApartments, int $beds)
    {
        $filteredApartaments = [];
        foreach ($searchedApartments as $searchedApartment) {
            if ($searchedApartment->beds >= $beds) {
                array_push($filteredApartaments, $searchedApartment);
            };
        }

        return $filteredApartaments;
    }



    /**
     * Searches for the apartments
     * @param Illuminate\Http\Request $request
     * @return Response
     */
    public function search(Request $request)
    {
        //dd($request->services);
        $data = [
            'address' => $request->address,
            'category' => $request->category,
            'services' => $request->services,
            'radius' => $request->radius,
            'beds' => $request->beds
        ];

        //dd($data);

        $validator = Validator::make($data, [
            'address' => 'nullable|max:255',
            'category' => 'nullable|exists:apartment_categories,id',
            'services' => 'nullable|exists:services,id',
            'radius' => 'nullable|numeric|max:100000',
            'beds' => 'nullable|numeric|min:0|max:128'


        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => 'invalid request'
            ]);
        } else {
            try {


                $val_data = $validator->validate();
                $searchedApartments = [];
                $poi = [];

                if (isset($val_data['address'])) {
                    $tomtomKey = 'Ua6yW0eCamWaOd9tndxBllkYGUgQL905';
                    //genero dei poi utilizzabili nella richiesta all'API di tomtom
                    $apartments = Apartment::all();

                    $poiLists = $this->generatePois($apartments);

                    //dd($poiLists);

                    $geocodeURL = 'https://api.tomtom.com/search/2/geocode/';
                    $searchURL = 'https://api.tomtom.com/search/2/';
                    $ext = '.json';

                    //ricerca delle coordinate trai i POIs(i nostri appartamenti)
                    $client = new Client();
                    $promise = $client->getAsync($geocodeURL . $val_data['address'] . $ext . '?key=' . $tomtomKey);

                    $response = $promise->wait();
                    $coordinates = json_decode($response->getBody()->getContents(), true)['results'][0]['position'];
                    $latitude = $coordinates['lat'];
                    $longitude =  $coordinates['lon'];




                    if (isset($val_data['radius']) && $val_data['radius'] != 0) {
                        $geometryList = [
                            [
                                "type" => "CIRCLE",
                                "position" => $latitude . "," . $longitude,
                                "radius" => $val_data['radius']
                            ]
                        ];
                    } else {
                        $defaultRadius = 20000;
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
                    //dd($poiLists);
                    $results = [];
                    $currentRequests = 0;
                    foreach ($poiLists as $poiList) {
                        if ($currentRequests == 5) {
                            sleep(1);
                            $currentRequests = 0;
                        }
                        //sleep(0.5);
                        $client = new Client();
                        $promise = $client->postAsync($searchURL . 'geometryFilter' . $ext . "?key=$tomtomKey", [
                            'json' => [
                                'poiList' => $poiList,
                                'geometryList' => $geometryList,
                            ]
                        ]);

                        $response = $promise->wait();

                        array_push($results, json_decode($response->getBody()->getContents(), true)['results']);
                        $currentRequests++;
                    }

                    //dd($results);
                    $coordinates = $this->getCoordinates($results);
                    //dd($coordinates);


                    foreach ($coordinates as $coordinate) {
                        $searchedApartment = Apartment::with(['user', 'services', 'views', 'subscription', 'apartment_category'])->where([
                            ['latitude', '=', $coordinate['lat']],
                            ['longitude', '=', $coordinate['lon']],
                        ])->get();
                        $searchedApartments = collect($searchedApartments)->merge($searchedApartment);
                    }

                    //dd($searchedApartments);
                    $poi = [
                        "lat" => $latitude,
                        "lon" => $longitude
                    ];
                } else if (!isset($val_data['address'])) {
                    $searchedApartments = Apartment::with(['user', 'services', 'views', 'subscription', 'apartment_category'])->get();
                    //dd($searchedApartments);
                }
                if (isset($val_data['services'])) {
                    $services = explode(',', $val_data['services']);
                    //dd($searchedApartments);

                    $filteredApartaments = $this->filterApartments($searchedApartments, $services);

                    $searchedApartments = $filteredApartaments;
                }

                if (isset($val_data['category'])) {
                    $category = $val_data['category'];
                    $filteredApartaments = $this->filterApartmentsByCategory($searchedApartments, $category);
                    //dd($searchedApartments);
                    $searchedApartments = $filteredApartaments;
                }

                if (isset($val_data['beds'])) {
                    $beds = $val_data['beds'];
                    $filteredApartaments = $this->filterApartmentsByBeds($searchedApartments, $beds);
                    $searchedApartments = $filteredApartaments;
                }


                //dd($searchedApartments);
                $searchedApartmentsCollection = collect($searchedApartments);
                //dd($searchedApartmentsCollection);
                $searchedApartmentsCollection = $searchedApartmentsCollection->where('visible', '=', true)->sortByDesc('id')->values();

                $searchedApartments = $this->bubbleSortByProduct($searchedApartmentsCollection);
                //dd($searchedApartmentsCollection);

                //dd($searchedApartments);
                /* $searchedApartments = $this->paginate($searchedApartments->toArray(), 6);
                $searchedApartments->setPath('http://127.0.0.1:8000/api/search'); */

                return response()->json([
                    'success' => true,
                    'poi' => $poi,
                    'results' => $searchedApartments
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'results' => $e->getMessage()
                ]);
            }
        }
    }
}
