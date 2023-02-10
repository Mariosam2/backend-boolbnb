<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use Illuminate\Http\Request;

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
                'results' => 'apartment Not Found'
            ]);
        }
    }
}
