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
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = User::where('user_type', '!=', 'Customer')->orderBy('user_type', 'ASC')->paginate(10);

        // SELECT LATEST ADDED USER
        $latest_added_user = User::where('user_type', '!=', 'Customer')
                                ->whereDate('created_at', Carbon::today())
                                ->count();

        return view('user.index', compact('users', 'latest_added_user'));
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(CreateUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'user_type' => $request->user_type,
            'branch' => $request->branch,
            'password' => Hash::make($request->password),
        ]);

        if($user){
            return redirect('user')->with('message', 'User Created Successfully');
        }

        return redirect()->back()
        ->withInput($request->all())
        ->with('message', 'Failed to Create ' . $request->user_type . ' account');

        // IF TYPE IS CUSTOMER
        // if($request->user_type == 'Customer'){
        //     $customer_validator = Validator::make($request->all(), [
        //         'phone' => 'required',
        //         'govt_id_type' => 'required',
        //         'govt_id_number' => 'required',
        //     ]);
    
        //     if($customer_validator->fails()){
        //         return redirect()->back()
        //         ->withInput($request->all())
        //         ->with('message', 'Missing Fields in Customer Details');
        //     }
        //     $code = Code::where('status', 1)->limit(1)->orderBy('id', 'ASC')->first();
        //     if($code){
        //         $user = User::create([
        //             'name' => $request->name,
        //             'email' => $request->email,
        //             'user_type' => $request->user_type,
        //             'branch' => $request->branch,
        //             //edited
        //             'password' => Hash::make('12345'),
        //             // Original 
        //             //'password' => ($request->user_type != 'Customer') ? Hash::make($request->password) : Hash::make('12345'),
        //         ]);
                
        //         if($user){
        //             // if($request->user_type == 'Customer'){ -- OLD
        //             // NEW REMOVED IF CONDITION KUNG CUSTOMER BA ANG I CREATE. REDUNDANT NA SA TAAS
        //                 $customer = Customer::create([
        //                     'user_id' => $user->id,
        //                     'phone' => $request->phone,
        //                     'address' => $request->address,
        //                     'govt_id_type' => $request->govt_id_type,
        //                     'govt_id_number' => $request->govt_id_number,
        //                     'code_id' => $code->id,
        //                 ]);

        //                 if($customer){
        //                     $code->update([
        //                         'status' => 0,
        //                     ]);
    
        //                     return redirect('user')->with('message', 'User Created Successfully');
        //                 }else{
                            // return redirect()->back()
                            // ->withInput($request->all())
                            // ->with('message', 'Failed to Create Customer account Level'); 
        //                 }
        //         }else{
        //             return redirect()->back()
        //             ->withInput($request->all())
        //             ->with('message', 'Failed to Create User account Level');
        //         }
        //     }
    
        //     return redirect()->back()
        //     ->withInput($request->all())
        //     ->with('message', 'No Code Available'); 
        // }else{
        //     $user = User::create([
        //         'name' => $request->name,
        //         'email' => $request->email,
        //         'user_type' => $request->user_type,
        //         'branch' => $request->branch,
        //         'password' => Hash::make($request->password),
        //     ]);
        //     if($user){
        //         return redirect('user')->with('message', 'User Created Successfully');
        //     }
        //     return redirect()->back()
        //     ->withInput($request->all())
        //     ->with('message', 'Failed to Create ' . $request->user_type . ' account');
        // }
        

              
    }

    public function show(User $user, $id)
    {
        $user = $user->findorfail($id);

        return view('user.show', compact('user'));
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|max:255|email',
            'password' => 'required|min:8|confirmed',
            'user_type' => 'required',
            'branch' => 'required',
        ]);

        if(!$validate->fails()){
            
            $user = User::where('id', $user->id)->first();

            if($user->email == $request->email){
                
                $user->update([
                    'name' => $request->name,
                    'user_type' => $request->user_type,
                    'branch' => $request->branch,
                    'password' => Hash::make($request->password),
                ]);
                
                if($user){
                    
                    return redirect('user')->with('message', 'User Created Successfully');
                }

                return redirect('user')->with('message', 'Failed to create user, Please contact your administrator');

            }else{
                $user->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'user_type' => $request->user_type,
                    'branch' => $request->branch,
                    'password' => Hash::make($request->password),
                ]);

                if($user){
                    return redirect('user')->with('message', 'User Created Successfully');
                }

                return redirect('user')->with('message', 'Failed to create user, Please contact your administrator');
                
            }
        }
    }

    public function destroy($id)
    {
        //
    }
    

}
