<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CustomerNetwork extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo('App\User', 'user_pid', 'id');
    }
}
