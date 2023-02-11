<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\SearchApartmentRequest;
use App\Models\Apartment;
use Illuminate\Http\Request;
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
            'services' => $request->services
        ];

        //dd($data);

        $validator = Validator::make($data, [
            'address' => 'required|max:255',
            'services' => 'nullable|array|exists:services,id'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'results' => 'invalid request'
            ]);
        } else {
            //filter data
            $val_data = $validator->validate();
            dd($val_data);
            if (isset($val_data['services'])) {
            } else {
            }
        }
    }
}
