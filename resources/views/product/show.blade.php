@extends('layouts.app')

@section('title', 'Product Show' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6 d-flex justify-content-between align-items-center">
            <div>
                @if (session()->has('message'))
                <h1>{{ session()->get('message') }}</h1>
            @endif
                <h1>Product</h1>
            </div>
            <div>
                <a href="{{ route('product.edit', $product->id) }}">Edit Details</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <div>
                <label for="name">Product Name: {{ $product->name }}</label>
            </div>
            <div>
                <label for="name">Product Description: {{ $product->description }}</label>
            </div>
            <div>
                <label for="name">Product Price: {{ $product->price }}</label>
            </div>
            <div>
                <label for="name">Product Quantity: {{ $product->quantity }}</label>
            </div>
        </div>
    </div>    
</div>
@endsection


