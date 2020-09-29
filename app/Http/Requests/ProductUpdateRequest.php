<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductUpdateRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'basePrice' => 'required',
            'description' => 'required',
            'image' => 'required',
            'priceTable' => 'nullable',
            'priceTableMode' => 'required',
            'sales' => 'nullable',
            'serial' => 'required',
            'stock' => 'required',
            'customForms' => 'nullable',
            'category' => 'required',

        ];
    }
}
