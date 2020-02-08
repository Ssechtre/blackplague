<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $guarded = [];

    protected $fillable = ['code'];
    
    public function getCodeAttribute($code)
    {
        return strtoupper($code);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function customer()
    {
        return $this->hasOne('App\Customer');
    }

    public function getFillables() {
        return $this->fillable;
    }
}
