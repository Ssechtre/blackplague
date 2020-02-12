<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'user_type', 'branch', 'phone', 'address', 'govt_id_type', 'govt_id_number', 'code_id'
    ];

    public static $user_types = [
        'admin'    => 'Admin',
        'staff'    => 'Staff',
        'agent'    => 'Agent',
        'customer' => 'Customer'
    ];

    public static $rules = [
        'name' => 'required',
        'password' => 'required|min:4'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function code()
    {
        return $this->hasOne('App\Code', 'id', 'code_id');
    }

    public function network()
    {
        return $this->hasMany('App\CustomerNetwork', 'user_pid', 'id');
    }

    public function getFillables() {
        return $this->fillable;
    }

}
