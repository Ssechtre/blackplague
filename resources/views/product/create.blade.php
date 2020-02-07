@extends('layouts.app')

@section('title', 'Product' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <form action="{{ route('product.store') }}" method="POST">
        @csrf
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header card-header-warning d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Create Product</h4>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div class="mt-2">
                        <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Product Name') }}</label>
                        <input type="text" name="name" class="form-control">
                        @error('name')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    <div class="mt-2">
                        <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Product Description') }}</label>
                        <textarea class="form-control" name="description"></textarea>
                        @error('description')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>
                    
                    <div class="mt-2">
                        <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Price') }}</label>
                        <input type="number" name="price" class="form-control" min="0" step="0.01">
                        @error('price')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="mt-2">
                        <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Quantity') }}</label>
                        <input type="number" name="quantity" class="form-control" min="0" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                        @error('quantity')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="mt-3 d-flex justify-content-center">
                        <div>
                            <button type="submit" class="btn btn-primary">
                            {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
    
    </div>
@endsection


