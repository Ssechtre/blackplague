<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
    protected $guarded = [];

    protected $fillable  = ['user_id', 'user_cid', 'order_number', 'discount_applications', 'line_items', 'subtotal_price', 'total_price', 'order_status', 'confirmed', 'browser_ip', 'remarks'];

    public static $rules = [
        'user_id' => 'required',
        'line_items' => 'required',
    ];

    public function getFillables() {
        return $this->fillable;
    }
}
