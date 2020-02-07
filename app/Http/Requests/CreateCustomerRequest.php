<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:7',
            'address' => 'required|min:5',
            'govt_id_type' => 'required',
            'govt_id_number' => 'required',
            'up_line' => 'required'
        ];
    }
}
