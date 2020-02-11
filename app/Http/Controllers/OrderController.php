<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Validator;

class OrderController extends Controller
{
    public function createOrder(Request $request) {

    	$data = $request->all();

    	$rules = Order::$rules;

		$validate = Validator::make($data, $rules, $this->error_messages);

		$data['line_items'] = json_encode($data['line_items']);
		$data['discount_applications'] = json_encode($data['discount_applications']);
		$data['order_status'] = 'delivered';
		$data['confirmed'] = 1;
		$data['browser_ip'] = request()->ip();
		$data['order_number'] = $data['user_id'].''.$data['user_cid'].''.date('His', time());

		if ($validate->fails()) {

			return response()->json($this->_response(false, "Some information are missing", $this->error_messages));

		}else{
			if (Order::create($data)) {

				// Update quantity of products
				// $items = $data['line_items'];
				// foreach ($items as $key => $value) {
				// 	# code...
				// }

				return response()->json($this->_response(true, "Order Created!!"));
			}
		}

    	return response()->json($this->_response(false, "Failed to save order."));
    }
}
