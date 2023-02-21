<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{



    public function index()
    {

        $services = Service::all();
        //dd($services);
        if (count($services) > 0) {
            return response()->json([
                "success" => true,
                "results" => $services
            ]);
        } else {
            return response()->json([
                "success" => false,
                "results" => 'not found'
            ]);
        }
    }
}
