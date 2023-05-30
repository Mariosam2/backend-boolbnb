<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Apartment;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class ViewsController extends Controller
{
    public function addView(Request $request)
    {
        $data = $request->all();
        $data['date'] = date('Y-m-d', strtotime($data['date']));
        $validator = Validator::make($data, [
            'apartment_id' => 'required|exists:apartments,id',
            'ip_address' => 'required|max:255',
            'date' => 'required|date'

        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors(),

            ]);
        } else {
            try {
                $val_data = $validator->validate();
                $views = View::all()->where('ip_address', '=', $val_data['ip_address'])->groupBy('ip_address')->toArray();
                if (isset($views[$val_data['ip_address']])) {
                    $views = $views[$val_data['ip_address']];
                    $viewDates = [];
                    $viewApartmentIds = [];
                    foreach ($views as $view) {
                        array_push($viewDates, $view['date']);
                        if (today()->toDateString() === $view['date']) {
                            array_push($viewApartmentIds, $view['apartment_id']);
                        }
                    }

                    if (in_array($val_data['date'], $viewDates) && in_array($val_data['apartment_id'], $viewApartmentIds)) {

                        return response()->json([
                            'success' => false,



                        ]);
                    } else {
                        $newView = View::make($val_data)->save();
                        return response()->json([
                            'success' => true,

                        ]);
                    }
                } else {
                    $newView = View::make($val_data)->save();
                    return response()->json([
                        'success' => true
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'errors' => $e->getMessage(),


                ]);
            }
        }
    }

    public function currentViews(Apartment $apartment)
    {
        $userApartments = Auth::user()->apartments()->pluck('id')->toArray();

        /* $currentApartament = Apartment::find($id); */
        if (in_array($apartment->id, $userApartments)) {
            return response()->json([
                'success' => true,
                'results' => $apartment->views()->get(),
                'userApartments' => $userApartments,
                'apartment' => $apartment
            ]);
        } else {
            return response()->json([
                'success' => false,
                'results' => 'This is not a your apartment'
            ]);
        }
    }
}
