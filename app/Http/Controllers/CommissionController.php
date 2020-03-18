<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Commission;
use Validator;

class CommissionController extends Controller
{
    //
    public function saveCommission(Request $request) {

    	$req = $request->all();

    	$rules = Commission::$rules;

    	$month = date('m', strtotime($req['date']['month']));
        $year = $req['date']['year'];

        if (!$req['transaction_number']) {
        	return response()->json($this->_response(false, "Transaction Number is required"));
        }

    	$data = [
    		'user_id' 				=> $req['user_id'],
    		'user_cid' 				=> $req['member']['id'],
    		'transaction_number' 	=> $req['transaction_number'],
    		'month' 				=> $month,
    		'year' 					=> $year,
    		'referral_amount' 		=> $req['referrals']['amount'],
    		'commission_amount' 	=> $req['commissions']['total'],
    		'remarks' 				=> $req['remarks'],
    		'status' 				=> 'Paid',

    	];

    	$validate = Validator::make($data, $rules, $this->error_messages);

        if ($validate->fails()) {
        	return response()->json($this->_response(false, "Some fields are missing"));
        }

        $save = Commission::create($data);

        if ($save) {
        	return response()->json($this->_response(true, "Payment saved!", $req));
        }

    	return response()->json($this->_response(false, "An error occured!"));
    }
}
