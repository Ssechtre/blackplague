@extends('layouts.app')

@section('title', 'Product Index' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            @if (session()->has('message'))
                <h1>{{ session()->get('message') }}</h1>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-warning d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Product Stats</h4>
                        <p class="card-category">New employees on 15th September, 2016</p>
                    </div>
                    @if(Auth::check() && Auth::user()->user_type != 'Customer')
                    <div>
                        <a href="{{ route('product.create') }}" class="btn btn-primary btn-sm">New Product</a>
                    </div>
                    @endif
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-warning">
                          <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Function</th>
                          </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <th scope="row">{{ $product->id }}</th>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td><a href="{{ route('product.show', $product->id) }}">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                      </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      <li class="page-item {{ ($products->currentpage() == 1) ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ $products->previousPageUrl() }}" tabindex="-1" aria-disabled="true" >Previous</a>
                      </li>
                        <li class="page-item disabled"><a href="#" class="page-link">{{ $products->currentpage() }}</a></li>
                      <li class="page-item {{ ($products->lastpage() == $products->currentpage()) ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ $products->nextPageUrl() }}">Next</a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
    </div>
    
    </div>
@endsection


