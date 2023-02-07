<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required:songs,title|max:100',
            'media' => 'required|image|size:5000',
            'apartment_category_id' => 'nullable|exists:apartment_categories,id',
            'description' => 'required',
            'mq' => 'required',
            'address' => 'required',
            //TODO: geolocalization
            //'latitude' => 'required',
            //'longitude' => 'required',
            'beds' => 'required',
            'total_rooms' => 'required',
            'baths' => 'required',
            'guests' => 'nullable',
            'check_in' => 'nullable',
            'check_out' => 'nullable',
            'price' => 'nullable|numeric',



        ];
    }
}
