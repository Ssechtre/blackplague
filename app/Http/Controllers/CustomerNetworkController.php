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
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(CustomerNetwork $customerNetwork)
    {
        //
    }

    public function edit(CustomerNetwork $customerNetwork)
    {
        //
    }

    public function update(Request $request, CustomerNetwork $customerNetwork)
    {
        //
    }

    public function destroy(CustomerNetwork $customerNetwork)
    {
        //
    }
}
