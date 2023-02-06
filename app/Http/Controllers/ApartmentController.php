<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreApartmentRequest;
use App\Http\Requests\UpdateApartmentRequest;
use App\Models\Apartment;
use App\Models\ApartmentCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ApartmentController extends Controller
{
    //TODO: Implement methods
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


        return view('apartments.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreApartmentRequest $request)
    {
        $val_data = $request->validate();

        // image
        if ($request->hasFile('media')) {
            $media = Storage::put('uploads', $val_data['media']);
            $val_data['media'] = $media;
        }

        $apartment_slug = Apartment::slugGenerator($val_data['title']);

        $val_data['slug'] = $apartment_slug;


        $apartment = Apartment::create($val_data);

        // redirect

        return to_route('apartments.index')->with('message', "You add a new Apartment: $apartment->title");
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
        //
        $categories = ApartmentCategory::all();

        return view('apartments.edit', compact('apartment', 'categories'));
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

        return to_route('apartments.index')->with('message', "You edit Apartment: $apartment->title");
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
        return to_route('apartments.index')->with('message', "You delete this Apartment: $apartment->title");
    }
}
