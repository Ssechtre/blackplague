<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
	public function getProducts(Request $request) {

		$data = Product::all();

		return response()->json($this->_response(true, '', $data));

	}
}
