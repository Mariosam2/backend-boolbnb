<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
                'errors' => $validator->errors()
            ]);
        } else {
            try {
                $val_data = $validator->validate();
                $newView = View::make($val_data)->save();
                return response()->json([
                    'success' => true,
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'errors' => $e
                ]);
            }
        }
    }
}
