<?php

namespace App\Http\Controllers;

use App\CustomerNetwork;
use Illuminate\Http\Request;

class CustomerNetworkController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        return view('customer_network.index');
    }
}
