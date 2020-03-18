<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Commission extends Model
{
	protected $guarded = [];
    //
    public static $rules = [
        'user_id' => 'required',
        'user_cid' => 'required',
        'transaction_number' => 'required',
    ];
}
