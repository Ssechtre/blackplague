<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
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

}
