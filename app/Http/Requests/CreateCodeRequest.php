<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCodeRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required',
        ];
    }
}
