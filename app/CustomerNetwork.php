<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CustomerNetwork extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->hasMany('App\User', 'user_pid', 'id');
    }

    public function getUserNetworks($user_id) {

    	$data = DB::table('customer_networks')
    	->join('users as u', 'u.id', '=', 'customer_networks.user_pid')
    	->join('users as uc', 'uc.id', '=', 'customer_networks.user_cid')
    	->where('customer_networks.user_pid', $user_id)->get(['uc.name', 'uc.phone', 'uc.email','u.created_at']);

    	return $data;

    }

}
