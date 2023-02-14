<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApartmentCategory;
use Illuminate\Http\Request;

class ApartmentCategoryController extends Controller
{
    public function index()
    {
        $apartment_categories = ApartmentCategory::all();
        if (count($apartment_categories) > 0) {
            return response()->json([
                "success" => true,
                "results" => $apartment_categories
            ]);
        } else {
            return response()->json([
                "success" => false,
                "results" => 'not found'
            ]);
        }
    }
}
