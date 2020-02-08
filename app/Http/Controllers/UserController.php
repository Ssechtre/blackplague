<?php

namespace App\Http\Controllers;

use App\User;
use App\Customer;
use App\Code;
use App\CustomerNetwork;
use App\Http\Requests\CreateCustomerRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{  

    public function __construct() {

        $this->fields['dropdowns'] = [
            'user_type' => User::$user_types
        ];

        $this->fields['text_replace'] = [
            'govt_id_type' => 'Government ID Type',
            'govt_id_number' => 'Government ID Number',
        ];
    }

    public function index() {

        $this->query_fields  = ['id', 'name', 'email', 'user_type', 'created_at', 'updated_at'];
        return parent::index();
    }

    // public function createAccount() {

    //     $data = [
    //         'name' => 'Admin',
    //         'password' => Hash::make('1234512345'),
    //         'username' => 'admin',
    //         'user_type' => 'Admin',
    //         'contact_no' => '121212',
    //         'address' => 'asdas',
    //         'email' => 'sudo@mail.com',
    //     ];

    //     $save =  User::create($data);

    //     if ($save) {
    //         var_dump($save);die;
    //     }
    //     dd('error');
    // }
}
