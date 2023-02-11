<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\ApartmentCategory;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;


class ApartmentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $apartments =  Auth::user()->apartments()->get();
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
    public function store(StoreApartmentRequest $request)
    {
        $tomtom_key = 'Ad83Ah6WsxYFXscdqk3lFXmhKanlaKHs';

        $val_data = $request->validated();
        $response = Http::get('https://api.tomtom.com/search/2/geocode/' . $val_data['address'] . '.json?key=' . $tomtom_key);
        $latitude = $response->json()['results'][0]['position']['lat'];
        $longitude = $response->json()['results'][0]['position']['lon'];


        // image
        if ($request->hasFile('media')) {
            $media = Storage::put('uploads', $val_data['media']);
            $val_data['media'] = $media;
        }

        $apartment_slug = Apartment::slugGenerator($val_data['title']);
        $user_id = Auth::user()->id;
        $val_data['user_id'] = $user_id;
        $val_data['slug'] = $apartment_slug;
        $val_data['longitude'] = $longitude;
        $val_data['latitude'] = $latitude;



        $apartment = Apartment::create($val_data);

        // dd($request);


        if ($request->has('services')) {
            $apartment->services()->attach($val_data['services']);
        }


        // redirect

        return to_route('apartments.index')->with('message', "Hai aggiunto un nuovo appartamento: $apartment->title");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Apartment $apartment)
    {
        //
        return view('apartments.show', compact('apartment'));
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
        $val_data = $request->validated();

        if ($request->hasFile('media')) {
            if ($apartment->media) {
                Storage::delete($apartment->media);
            }
            $media = Storage::put('uploads', $val_data['media']);
            $val_data['media'] = $media;
        }

        $apartment_slug = Apartment::slugGenerator($val_data['title']);
        $val_data['slug'] = $apartment_slug;

        $apartment->update($val_data);

        if ($request->has('services')) {
            $apartment->services()->sync($val_data['services']);
        } else {
            $apartment->services()->sync([]);
        }
        return to_route('apartments.index')->with('message', "Hai modificato questo appartamento: $apartment->title");
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
}
