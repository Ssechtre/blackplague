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
            'user_type' => User::$user_types,
            'is_member' => [
                0 => 'No',
                1 => 'Yes'
            ]
        ];
    }

    public function edit($id) {
        $user = User::where('id', $id)->first();
        
        if(!$user){
            return back();
        }
        // dd($user);
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->all();

        if (isset($data['change_password']) && (strlen($data['password']) == 0 || strlen($data['password_confirmation']) == 0)) {
            return back()->with($this->_response(false, "Passwords cannot be empty.")); 
        }

        if(isset($data['password'])){
            $this->rules = ['password' => 'required|min:4|confirmed'];
        }else{
            $this->rules = ['name' => 'required', 'email' => 'required|email'];
        }

        if (isset($request['email'])) {

            $user = User::where('id', $id)->first();
            
            if($data['email'] == $user->email){
                unset($this->rules['email']);
                unset($request['email']);
            }
        }

        return parent::update($request, $id);

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

            $data['password'] = Hash::make($data['password']);

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

        $this->query_fields  = ['id', 'name', 'email', 'user_type', 'is_member', 'created_at'];
        $this->relationships = [
            'code' => [
                'name' => 'Code Number',
                'column' => 'code'
            ]
        ];

        $this->filters = [
            'text' => ['name'],
            'dropdown' => [
                'user_type' => [
                    'label' => 'User Type',
                    'data' => User::$user_types
                ],
                'is_member' => [
                    'label' => 'Membership',
                    'data' => [
                        0 => 'Non-member',
                        1 => 'Member',
                    ]
                ]
            ]
        ];

        $this->query = User::orderBy('id', 'DESC')->with('code');

        if (isset($_GET['search']) && $_GET['search'] == true) {
            foreach ($_GET as $key => $value) {
                if ($key != 'search' && $value != "") {
                    $this->query->where($key, 'like', '%' . $value . '%');
                }
            }
        }

        $this->query = $this->query->paginate(20);

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

    public function changePassword(Request $request, User $user)
    {
        $data = $request->all();

        $confirm_old_password = Hash::check($data['old_password'], $user->password);

        if(!$confirm_old_password){
            return back()->with($this->_response(false, "Old password is incorrect")); 
        }

        if ($data['password'] != $data['password_confirmation']) {
            return back()->with($this->_response(false, "New passwords don't match")); 
        }

        $rules = ['password' => 'required|min:4'];

        $validate = Validator::make($data, $rules, $this->error_messages);

        if($validate->fails()){
            return back()->withErrors($validate);
        }
        
        $data['password'] = Hash::make($data['password']);
        
        $update = $user->update($data);

        if(!$update){
            return back()->with($this->_response(false, "An error occured")); 
        }

        return back()->with($this->_response(true, "Change password successfully."));
    }


    public function createAccount() {

        $data = [
            'name' => 'Admin',
            'password' => Hash::make('1234512345'),
            'username' => 'admin',
            'user_type' => 'admin',
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
