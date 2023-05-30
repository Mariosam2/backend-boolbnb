<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\ApartmentCategory;
use App\Models\Message;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class ApartmentController extends Controller
{
    protected $tomtomKey = "45POhoazK93Ibg5oAGDMtKuyqLhjzUGo";
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

    public function getKey()
    {
        return $this->tomtomKey;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $apartments =  Auth::user()->apartments()->orderByDesc('id')->get();
        $apartments = $this->bubbleSortByProduct($apartments);
        return view('apartments.index', compact('apartments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {


        $categories = ApartmentCategory::all();
        $services = Service::all();

        return view('apartments.create', compact('categories', 'services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function messages()
    {
        $messages = DB::table('apartments')
            ->join('messages', 'apartments.id', '=', 'messages.apartment_id')
            ->where('apartments.user_id', Auth::id())
            ->orderByDesc('messages.id')
            ->paginate(5);
        //dd($messages);
        return view('apartments.messages', compact('messages'));
    }


    public function updateMessage($id, $all)
    {
        try {
            $messages = DB::table('apartments')
                ->join('messages', 'apartments.id', '=', 'messages.apartment_id')
                ->where('apartments.user_id', Auth::id())
                ->orderByDesc('messages.id')->get();
            if (filter_var($all, FILTER_VALIDATE_BOOLEAN)) {
                foreach ($messages as $message) {
                    $message->is_read = true;
                    $read_message = Message::find($message->id);
                    $read_message->is_read = true;
                    $read_message->save();
                }
            } else {
                foreach ($messages as $message) {
                    if ($message->id == $id) {
                        $message->is_read = true;
                        $read_message = Message::find($id);
                        $read_message->is_read = true;
                        $read_message->save();
                    }
                }
            }

            return response()->json([
                'results' => $messages,
                'all' => filter_var($all, FILTER_VALIDATE_BOOLEAN)
            ]);
        } catch (\Exception $e) {
            return to_route('not-found');
        }
    }

    public function store(StoreApartmentRequest $request)
    {
        //dd($request);
        try {

            $val_data = $request->validated();
            $client = new Client();
            $promise = $client->getAsync('https://api.tomtom.com/search/2/geocode/' . $val_data['address'] . '.json?key=' . $this->getKey());

            $response = $promise->wait();
            $result = json_decode($response->getBody()->getContents(), true);
            $latitude = $result['results'][0]['position']['lat'];
            $longitude = $result['results'][0]['position']['lon'];
            $freeFormAddress = $result['results'][0]['address']['freeformAddress'];




            // image
            if ($request->hasFile('media')) {
                $media = Storage::put('uploads', $val_data['media']);
                $val_data['media'] = $media;
            }

            $apartment_slug = Apartment::slugGenerator($val_data['title']);
            $user_id = Auth::user()->id;
            $val_data['user_id'] = $user_id;
            $val_data['slug'] = $apartment_slug;
            if (isset($result['results']) && count($result['results'])) {
                if (isset($longitude)) {
                    $val_data['longitude'] = $longitude;
                }
                if (isset($latitude)) {
                    $val_data['latitude'] = $latitude;
                }
                if (isset($freeFormAddress)) {
                    $val_data['free_form_address'] = $freeFormAddress;
                }
            }





            //dd($val_data);
            $apartment = Apartment::create($val_data);

            // dd($request);


            if ($request->has('services')) {
                $apartment->services()->attach($val_data['services']);
            }


            // redirect

            return to_route('apartments.index')->with('message', "Hai aggiunto un nuovo appartamento: $apartment->title");
        } catch (\Exception $e) {
            return view('not-found');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        $apartmentSlug = $apartment->slug;
        //dd($apartmentSlug);
        return view("http://localhost:5174/blog/$apartmentSlug", compact('apartment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Apartment $apartment)
    {



        $user = Auth::user();
        if ($user->id === $apartment->user_id) {
            $categories = ApartmentCategory::all();
            $services = Service::all();
            return view('apartments.edit', compact('apartment', 'categories', 'services'));
        } else {
            return view('not-found');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateApartmentRequest $request, Apartment $apartment)
    {
        //dd($request);
        try {

            $val_data = $request->validated();
            $client = new Client();
            $promise = $client->getAsync('https://api.tomtom.com/search/2/geocode/' . $val_data['address'] . '.json?key=' . $this->getKey());

            $response = $promise->wait();
            $result = json_decode($response->getBody()->getContents(), true);
            $latitude = $result['results'][0]['position']['lat'];
            $longitude = $result['results'][0]['position']['lon'];
            $freeFormAddress = $result['results'][0]['address']['freeformAddress'];


            if ($request->hasFile('media')) {
                if ($apartment->media) {
                    Storage::delete($apartment->media);
                }
                $media = Storage::put('uploads', $val_data['media']);
                $val_data['media'] = $media;
            }

            $apartment_slug = Apartment::slugGenerator($val_data['title']);
            $val_data['slug'] = $apartment_slug;
            if (isset($result['results']) && count($result['results'])) {
                if (isset($longitude)) {
                    $val_data['longitude'] = $longitude;
                }
                if (isset($latitude)) {
                    $val_data['latitude'] = $latitude;
                }
                if (isset($freeFormAddress)) {
                    $val_data['free_form_address'] = $freeFormAddress;
                }
            }

            $apartment->update($val_data);

            if ($request->has('services')) {
                $apartment->services()->sync($val_data['services']);
            } else {
                $apartment->services()->sync([]);
            }
            return to_route('apartments.index')->with('message', "Hai modificato questo appartamento: $apartment->title");
        } catch (\Exception $e) {
            return view('not-found');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Apartment $apartment)
    {
        if ($apartment->media) {
            Storage::delete($apartment->media);
        }
        $apartment->delete();
        return to_route('apartments.index')->with('message', "Hai cancellato questo appartamento: $apartment->title");
    }


    public function splashPage()
    {
        return view('apartments.splash-page');
    }
}
