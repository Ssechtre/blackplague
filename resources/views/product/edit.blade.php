@extends('layouts.app')

@section('title', 'Product Edit' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <form action="{{ route('product.update', $product->id) }}" method="POST">
                @method('PATCH')
                @csrf
                <div class="mt-3">
                    <input type="text" name="name" class="form-control" placeholder="Product Name" value="{{ $product->name }}">
                    @error('name')
                        <label for="error" class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="mt-3">
                    <textarea class="form-control" name="description" placeholder="Product Description">{{ $product->description }}</textarea>
                    @error('description')
                        <label for="error" class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="mt-3">
                    <input type="number" name="price" class="form-control" placeholder="Price" min="0" step="0.01" value="{{ $product->price }}">
                    @error('price')
                        <label for="error" class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="mt-3">
                    <input type="number" name="quantity" class="form-control" placeholder="Quantity" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="{{ $product->quantity }}">
                    @error('quantity')
                        <label for="error" class="text-danger">{{ $message }}</label>
                    @enderror
                </div>
                <div class="mt-3">
                    <button class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
    
    </div>
@endsection


