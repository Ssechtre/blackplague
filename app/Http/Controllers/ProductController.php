<?php

namespace App\Http\Controllers;

use App\Product;
use App\Http\Requests\CreateProductRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // dd(route('product.index'));
        $products = Product::paginate(10);

        return view('product.index', compact('products'));
    }

    public function create()
    {
        return view('product.create');
    }

    public function store(CreateProductRequest $request)
    {
        Product::create($request->all());

        return redirect('product')->with('message', 'Prodct Added Successfully FLASH MESSAGE NI MASTER');
    }

    public function show(Product $product, $id)
    {
        $product = $product->findorfail($id);

        return view('product.show', compact('product'));
    }

    public function edit(Product $product, $id)
    {
        $product = $product->findorfail($id);

        return view('product.edit', compact('product'));
    }

    public function update(CreateProductRequest $request, Product $product, $id)
    {
        $product = $product->findorfail($id);

        $product->update($request->all());

        return redirect('product/'. $product->id)->with('message', 'Prodct Added Successfully FLASH MESSAGE NI MASTER');;
    }

    public function destroy(Product $product)
    {
        //
    }
}
