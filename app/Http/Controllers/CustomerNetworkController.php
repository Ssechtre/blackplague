<?php

namespace App\Http\Controllers;

use App\CustomerNetwork;
use App\User;
use App\Code;
use Illuminate\Http\Request;
use DB;

class CustomerNetworkController extends Controller
{

    public function index()
    {
        return view('customer_network.index');
    }


    public function getCustomersNetworks() {

    	$data = DB::table('users')
        ->join('customer_networks', 'customer_networks.user_pid', '=', 'users.id')        
        ->select(DB::raw('COUNT(customer_networks.id) as connected_customers, users.*'))
        ->groupBy('users.id')
        ->get();

        return response()->json($this->_response(true, "Data retrieved", $data));
    
    }

    public function connectUsers(Request $request) {

        $data = $request->all();

        if (!$data['user_id']) {
        	return response()->json($this->_response(false, "You need to select a customer this person is connected to."));
        }

        $code = Code::where([ ['code','=',$data['code_number']], ['status','=',0] ])->first();

        if (!$code) {
        	return response()->json($this->_response(false, "Code is invalid."));
        }

        $user = User::where(['code_id' => $code->id])->first();

        if (!$user) {
        	return response()->json($this->_response(false, "The code is not owned by anyone."));
        }

        $parent_user = User::find($data['user_id']);

        if (!$parent_user) {
        	return response()->json($this->_response(false, "Customer not found."));
        }

        $networks = CustomerNetwork::where(['user_pid' => $parent_user->id])->get();

        if (count($networks) >= 4) {
        	return response()->json($this->_response(false, "The selected customer reach its max(4) networks."));
        }

        $connected = CustomerNetwork::where('user_cid', $user->id)->get();

        if (count($connected) > 0) {
        	return response()->json($this->_response(false, "The code is already in use"));
        }

        $connect = CustomerNetwork::create([
        	'user_pid' => $parent_user->id,
        	'user_cid' => $user->id,
        ]);

        if (!$connect) {
        	return response()->json($this->_response(false, "Failed to connect customers."));
        }

        return response()->json( $this->_response(true, "Customers successfully connected.") );
    }


}
