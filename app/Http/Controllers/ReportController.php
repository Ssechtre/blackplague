<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;

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
        $data['total'] = number_format($total, 2);
        $data['subtotal'] = number_format($subtotal, 2);

    	return response()->json($this->_response(true, "Data received", $data));

    }
}
