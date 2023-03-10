<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

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


    public function index()
    {
        $apartments =  Auth::user()->apartments()->orderByDesc('id')->get();
        $apartments = $this->bubbleSortByProduct($apartments);
        return view('dashboard', compact('apartments'));
    }
}
