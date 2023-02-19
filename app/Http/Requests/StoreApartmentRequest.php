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
            'title' => 'required|max:100',
            'media' => 'required|image',
            'apartment_category_id' => 'nullable|exists:apartment_categories,id',
            'description' => 'required|max:16777215',
            'mq' => 'required|numeric|min:0|max:32767',
            'address' => 'required|max:255',
            'beds' => 'required|numeric|min:0|max:128',
            'total_rooms' => 'required|numeric|min:0|max:128',
            'baths' => 'required|numeric|min:0|max:128',
            'guests' => 'required|numeric|min:0|max:128',
            'check_in' => 'nullable|max:255',
            'check_out' => 'nullable|max:255',
            'price' => 'nullable|numeric|max:999.99',
            'visible' => 'required|boolean',
            'services' => 'nullable|exists:services,id'



        ];
    }
}
