<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $guarded = [];

    protected $fillable  = ['name', 'description', 'price', 'quantity'];

    public static $rules = [
        'name' => 'required',
        'price' => 'required|regex:/^\d+(\.\d{1,2})?$/',
        'quantity' => 'required|numeric',
    ];

    public function getFillables() {
        return $this->fillable;
    }

}
