<?php

namespace App\Http\Controllers;

use App\Code;
use App\Customer;
use App\CustomerNetwork;
use App\User;
use Auth;
use App\Http\Requests\CreateCustomerRequest;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $customers = DB::table('customers')
                        ->join('users', 'customers.user_id', '=', 'users.id')
                        ->where('users.user_type', 'Customer')
                        ->paginate(10);
        
        $latest_added_customer = User::where('user_type', 'Customer')
                                    ->whereDate('created_at', Carbon::today())
                                    ->count();

        return view('customer.index', compact('customers', 'latest_added_customer'));
    }

    public function create()
    {
        $customers = Customer::all();

        return view('customer.create', compact('customers'));
    }

    public function store(CreateCustomerRequest $request)
    {
        // dd($request->all());
        // dd($request->down_line);
        $code = Code::where('status', '1')->limit(1)->orderBy('id', 'ASC')->first();

        if(!$code){
            return redirect()->back()
            ->withInput($request->all())
            ->with('message', 'No Code Available'); 
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make('12345'),
            'user_type' => 'Customer',
            'branch' => Auth::user()->branch,
        ]);

        if($user){
            $customer = Customer::create([
                'user_id' => $user->id,
                'phone' => $request->phone,
                'address' => $request->address,
                'govt_id_type' => $request->govt_id_type,
                'govt_id_number' => $request->govt_id_number,
                'code_id' => $code->id,
            ]);

            if($customer){

                if($request->up_line != 0){
                    $downline = CustomerNetwork::create([
                        'user_pid' => $request->up_line,
                        'user_cid' => $user->id,
                    ]);

                    if($downline){
                        $point = Customer::where('user_id', $request->up_line)
                        ->increment('points', 1);

                        // dd($point);

                        if($point){

                            $code->update([
                                'status' => 0
                            ]);
                            
                            return redirect('customer')->with('message', 'Customer Created Successfully');
                        }
                        
                    }
                }else{
                    $code->update([
                        'status' => 0
                    ]);

                    return redirect('customer')->with('message', 'Customer Created Successfully');
                }
            }
        }

        // return redirect()->back()
        //     ->withInput($request->all())
        //     ->with('message', 'No Code Available'); 

        // return redirect('/user')->with('message', 'Customer Added Successfully FLASH MESSAGE NI MASTER');

         // Customer::create([
        //     'name' => $request->name,
        //     'email' => $request->email,
        //     'phone' => $request->phone,
        //     'address' => $request->address,
        //     'govt_id_type' => $request->govt_id_type,
        //     'govt_id_number' => $request->govt_id_number,
        //     'username' => $request->username,
        //     'password' => Hash::make($request->password),
        // ]);
    }

    public function show(Customer $customer, $id)
    {
        $customer = $customer->where('user_id', $id)->first();
        $downline = DB::table('customer_networks')
                    ->join('users', 'customer_networks.user_pid', '=', 'users.id')
                    ->where('customer_networks.user_pid', $id)
                    ->get();

        $upline = DB::table('customer_networks')
                    ->join('users', 'customer_networks.user_pid', '=', 'users.id')
                    ->where('customer_networks.user_cid', $id)
                    ->first();
        
        return view('customer.show', compact('customer', 'downline', 'upline'));
    }

    public function edit(Customer $customer, $id)
    {
        // $customer = $customer->where('user_id', $id)->first();

        // $upline = CustomerNetwork::where('user_cid', $id)->first();
        
        // if(empty($upline)){
        //     $downline = CustomerNetwork::where('user_pid', $id)->get();
            
        //     $downline_ids = array();

        //     foreach ($downline as $key => $value) {
        //         array_push($downline_ids, $value->id);
        //     }

        //     // dd($downline_ids);

        //     if($downline){
        //         // $possible_upline = User::where('user_type', 'Customer')
        //         //                         ->where('id', '!=', $id)
        //         //                     foreach ($downline as $key => $value) {
        //         //                         ->where('')
        //         //                     }
        //         $possible_upline = User::where('user_type', 'Customer')
        //                                 ->whereNotIn('id', [5,7,8])
        //                                 ->get();
        //         dd($possible_upline);
        //     }
        // }
        $customer = $customer->where('user_id', $id)->first();

        $customers = Customer::where('user_id', '!=', $id)->get();

        $upline = DB::table('customer_networks')
                    ->join('users', 'customer_networks.user_pid', '=', 'users.id')
                    ->where('customer_networks.user_cid', $id)
                    ->orWhere('customer_networks.user_pid', $id)
                    ->first();
        
        $customer_network = CustomerNetwork::where('user_pid', $id)->count();
        // dd($upline);
        if($customer_network == 0){
            $poss_uplines = User::where('user_type', 'Customer')
                                    ->where('id', '!=', $id)
                                    ->get();
        }
        elseif(!empty($upline)){
            $poss_uplines = User::where('id', '!=', $upline->user_pid)
                                ->where('id', '!=', $upline->user_cid)
                                ->where('user_type', 'Customer')
                                ->get();
        }else{
            $poss_uplines = User::where('id', '!=', $id)
                                ->where('user_type', 'Customer')
                                ->get();
        }
        
        return view('customer.edit', compact('customer'));
    }

    public function update(Request $request, Customer $customer, $id)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|min:7',
            'address' => 'required|min:5',
            'govt_id_type' => 'required',
            'govt_id_number' => 'required',
            'up_line' => 'required',
            'user_type' => 'required',
            'branch' => 'required'
        ]);
        
        // VALIDATE REQUEST
        if($validate->fails()){
            return redirect()->back()
                    ->withInput($request->all())
                    ->with('message', 'Failed to Update Customer'); 
        }

        // UPDATE USER IF EMAIL IS EQUAL TO PREVIOUS EMAIL
        if($request->email == $request->hidden_email){
            $user = User::where('id', $id)->update([
                'name' => $request->name,
                'user_type' => $request->user_type,
                'branch' => $request->branch,
            ]);
        }
        else //UPDATE USER WITH EMAIL
        {
            $user = User::where('id', $id)->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'user_type' => $request->user_type,
                    'branch' => $request->branch,
                ]);
        }

        //UPDATE CUSTOMER
        if($user){
            $customer = Customer::where('user_id', $id)->update([
                'phone' => $request->phone,
                'address' => $request->address,
                'govt_id_type' => $request->govt_id_type,
                'govt_id_number' => $request->govt_id_number,
            ]);
            
            // dd($request->all());
            if($customer){
                // RETURN IF NO UPLINE
                if($request->up_line == 0){
                    $remove_network_data = CustomerNetwork::where('user_cid', $id)
                                            ->where('user_pid', $request->prev_upline)
                                            ->delete();

                        if($remove_network_data){
                            $update_customer_points = Customer::where('user_id', $request->prev_upline)
                                                        ->decrement('points', 1);

                            return redirect('customer/' . $id)->with('message', 'Customer Updated Successfully');
                        }
                }

                
                // UPDATE CUSTOMER'S NETWORK WITH UPLINE
                $network = CustomerNetwork::create([
                    'user_pid' => $request->up_line,
                    'user_cid' => $id,
                ]);
                
                // UPDATE CUSTOMER INCREMENT POINTS
                if($network){
                    $point = Customer::where('user_id', $request->up_line)
                        ->increment('points', 1);
                    
                    //RETURN SUCCESSFUL
                    if($point){
                        return redirect('customer/' . $id)->with('message', 'Customer Updated Successfully');
                    }
                }
            }
        }

    }

    public function destroy(Customer $customer)
    {
        //
    }
}
