<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use App\CustomerNetwork;
use App\User;
use App\Commission;
use DB;
use DateTime;

class ReportController extends Controller
{
    //
    public function getDailySales(Request $request) {

    	$req = $request->all();
    	$data = [];
        $total = 0;
        $subtotal = 0;

    	$orders = Order::leftJoin('users', 'users.id', '=', 'orders.user_cid')
    	->whereDate('orders.created_at', '=',$req['date'])
    	->where('confirmed', 1)
    	->get(['users.name', 'orders.order_number', 'orders.discount_applications', 'orders.subtotal_price', 'orders.total_price', 'orders.remarks']);

    	foreach ($orders as $key => $value) {
    		
	    	$discount = json_decode($value['discount_applications'], true);

            $discount_value = '';

            if ($discount['discount_applied']) {                
                switch ($discount['discount_type']) {
                    case 'percentage':
                        $discount_value = "-". $discount['discount_amount']. "%";
                        break;
                    case 'fixed':
                        $discount_value = "-P". number_format($discount['discount_amount'], 2);
                        break;                
                    default:
                        break;
                }
            }

            $orders[$key]['discount'] = $discount_value;

            unset($orders[$key]['discount_applications']);

            $total += $value['total_price'];
            $subtotal += $value['subtotal_price'];


    	}

        $data['orders'] = $orders;
        $data['total_revenue'] = number_format($total, 2);
        $data['subtotal'] = number_format($subtotal, 2);

    	return response()->json($this->_response(true, "Data received", $data));

    }


    public function getMonthlySales(Request $request) {

        $req = $request->all();

        $month = date('m', strtotime($req['date']['month']));
        $year = date('Y', strtotime($req['date']['year']))+1;

        $data = [];

        $orders = DB::table('orders')
            ->select([DB::raw("SUM(total_price) AS total_daily_sales"), DB::raw('COUNT(id) AS daily_orders'), DB::raw('DATE(created_at) AS daily_date')])
            ->whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->groupBy('daily_date')
            ->orderBy('daily_date', 'ASC')
            ->get();

        $data['total_revenue'] = 0;
        $data['total_orders'] = 0;

        foreach ($orders as $key => $value) {
            $data['total_revenue'] += $value->total_daily_sales;
            $data['total_orders'] += $value->daily_orders;
            $orders[$key]->date_beautified = date('F d, Y', strtotime($value->daily_date));
        }

        $data['orders'] = $orders;

        return response()->json($this->_response(true, "Data received", $data));
    }

    public function getAnnualSales(Request $request) {

        $req = $request->all();

        $year = date('Y', strtotime($req['date']))+1;

        $data = [];

        $orders = DB::table('orders')
            ->select([DB::raw("SUM(total_price) AS total_monthly_sales"), DB::raw('COUNT(id) AS monthly_orders'), DB::raw('MONTH(created_at) AS monthly_date')])
            ->whereYear('created_at', $year)
            ->groupBy('monthly_date')
            ->orderBy('monthly_date', 'ASC')
            ->get();

        $data['total_revenue'] = 0;
        $data['total_orders'] = 0;

        foreach ($orders as $key => $value) {
            $data['total_revenue'] += $value->total_monthly_sales;
            $data['total_orders'] += $value->monthly_orders;

            $dateObj   = DateTime::createFromFormat('!m', $value->monthly_date);
            $monthName = $dateObj->format('F');
            $orders[$key]->month_name = $monthName;
        }

        $data['orders'] = $orders;

        return response()->json($this->_response(true, "Data received", $data));
    }

    public function getCustomerCommissions(Request $request) {

        $req = $request->all();

        $month = date('m', strtotime($req['date']['month']));
        $year = $req['date']['year'];

        $user_id = $req['user_id'];

        if (!$user_id) {
            return response()->json($this->_response(false, "User not found"));
        }

        $user = User::find($user_id);

        if (!$user) {
            return response()->json($this->_response(false, "User not found"));
        }

        $referrals = DB::table('users')
        ->join('customer_networks', 'customer_networks.user_cid', '=', 'users.id')        
        ->select(DB::raw('users.id, users.name, users.created_at'))
        ->where('customer_networks.user_pid', $user_id)
        ->whereMonth('customer_networks.created_at', $month)
        ->whereYear('customer_networks.created_at', $year)
        ->get();

        $referral_ids = [];

        foreach ($referrals as $key => $value) {
            $referral_ids[] = $value->id;
        }

        $orders = [];
        $total_commission = 0;

        $orders = DB::table('orders')
        ->join('users', 'orders.user_cid', '=', 'users.id')
        ->select([DB::raw("users.name AS customer_name"), DB::raw('orders.*')])
        ->whereMonth('orders.created_at', $month)
        ->whereYear('orders.created_at', $year)
        ->whereIn('orders.user_cid', $referral_ids)
        ->orderBy('orders.created_at', 'ASC')
        ->get();

        foreach ($orders as $key => $value) {
            $commission = ($value->total_price*0.10);
            $orders[$key]->commission = $commission;
            $total_commission += $commission;
        }


        $commission_status = DB::table('commissions')
        ->join('users', 'users.id', '=', 'commissions.user_id')
        ->where('commissions.user_cid', $user_id)
        ->where('commissions.month', $month)
        ->where('commissions.year', $year)
        ->first(
            ['commissions.user_id', 'commissions.transaction_number', 'commissions.remarks', '.commissions.status', 'users.name AS approved_by']
        );

        if (!$commission_status) {
            $commission_status = [
                'user_id' => null,
                'transaction_number' => null,
                'remarks' => null,
                'status' => null,
                'approved_by' => null,
            ];
        }

        $data = [
            'referrals' => [
                'users' => $referrals,
                'amount' => count($referrals) * 500,
            ],
            'commissions' => [
                'data' => $orders,
                'total' => $total_commission
            ],
            'user' => $user,
            'date' => $month."-".$year,
            'commission_status' => $commission_status
        ]; 

        return response()->json($this->_response(true, "Data received", $data));

    }

    public function getPayouts(Request $request) {

        $req = $request->all();

        $month = date('m', strtotime($req['date']['month']));
        $year = $req['date']['year'];

        $month_beautified = date('F', strtotime($req['date']['month']));

        $payouts = DB::table('users')
        ->join('customer_networks', 'customer_networks.user_pid', '=', 'users.id')
        ->leftJoin('commissions', 'commissions.user_cid', '=', 'users.id')        
        ->select(DB::raw('COUNT(customer_networks.id) as connected_customers, 
            users.name as member_name, 
            users.phone, 
            users.email, 
            users.id AS member_id,
            commissions.status'))
        ->groupBy('users.id')
        ->whereMonth('customer_networks.created_at', $month)
        ->whereYear('customer_networks.created_at', $year)
        ->get();

        $data = [
            'payouts' => $payouts,
            'payout_date' => $month_beautified."-".$year
        ];

        return response()->json($this->_response(true, "Data retrieved", $data));

    }

}
