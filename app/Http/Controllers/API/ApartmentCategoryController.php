<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ApartmentCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ApartmentCategoryController extends Controller
{
    public function index()
    {
        $apartment_categories = ApartmentCategory::all();
        if (count($apartment_categories) > 0) {
            foreach ($apartment_categories as $apartment_category) {
                $apartment_category->name = str_replace('\'', ' ', $apartment_category->name);
                $apartment_category->img =  Str::slug($apartment_category->name . ' ' . $apartment_category->id);
            }
            //dd($apartment_categories);
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
