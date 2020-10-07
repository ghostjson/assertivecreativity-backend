<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductStoreRequest extends FormRequest
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
            'base_price' => 'required',
            'description' => 'required',
            'image' => 'required',
            'price_table' => 'nullable',
            'price_table_mode' => 'required',
            'sales' => 'nullable',
            'serial' => 'required',
            'stock' => 'required',
            'custom_forms' => 'nullable',
            'category' => 'required',

        ];
    }
}
