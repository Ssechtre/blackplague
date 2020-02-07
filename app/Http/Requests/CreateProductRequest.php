<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required|min:2',
            'description' => 'required|min:5',
            'price' => 'required',
            'quantity' => 'required'
        ];
    }
}
