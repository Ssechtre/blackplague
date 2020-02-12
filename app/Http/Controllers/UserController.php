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

        $this->column_values = [
            'user_type' => User::$user_types
        ];
    }

    public function edit($id) {

        $this->fields['excludes']  = ['password', 'code_id', 'user_type'];
        return parent::edit($id);
    }

    public function create()
    {   
        $this->fields['excludes'] = ['code_id'];

        return parent::create();
    }

    public function store(Request $request) {

        if ($request['user_type'] && $request['user_type'] == 'customer') {

            $code = Code::where('status', '1')->limit(1)->orderBy('id', 'ASC')->first();

            if(!$code){
                return back()
                ->withInput($request->all())
                ->with($this->_response(false, "No codes available. Please generate codes before creating customers.")); 
            }

            $rules = User::$rules;

            $data = $request->all();

            $validate = Validator::make($data, $rules, $this->error_messages);

            if ($validate->fails()) {
                return back()->withErrors($validate)->withInput($request->all);
            }

            $data['code_id'] = $code->id;

            $user = User::create($data);

            if ($user) {

                $code->status = 0;
                $code->save();

                return redirect('users')->with($this->_response(true, "New user successfuly added with code number: ". $code->code));

            }else{
                return back()
                ->withInput($request->all())
                ->with($this->_response(false, "An error occured.")); 
            }
        }

        return parent::store($request);

    }

    public function index() {

        $this->query_fields  = ['id', 'name', 'email', 'user_type', 'created_at', 'updated_at'];
        $this->relationships = [
            'code' => [
                'name' => 'Code Number',
                'column' => 'code'
            ]
        ];

        $this->query = User::orderBy('id', 'DESC')->with('code')->paginate(20);

        return parent::index();
    }

    public function getUsers(Request $request) {

        $data = User::query();

        $query = [];

        $filter = $request->all();

        if ($filter) {
            foreach ($filter as $key => $value) {
                if ($key != 'name') {
                    $query[] = [$key,'=',$value];  
                }else{
                    $query[] = ['name', 'LIKE', "%".$filter['name']."%" ];
                }            
            }
        }

        $data = $data->where($query)->orderBy('name', 'ASC')->get(['id','name']);

        return response()->json($data);

    }

    public function createAccount() {

        $data = [
            'name' => 'Admin',
            'password' => Hash::make('1234512345'),
            'username' => 'admin',
            'user_type' => 'Admin',
            'contact_no' => '121212',
            'address' => 'asdas',
            'email' => 'sudo@mail.com',
        ];

        $save =  User::create($data);

        if ($save) {
            dd($save);
        }
        dd('error');
    }
}
