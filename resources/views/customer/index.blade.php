@extends('layouts.app')

@section('title', 'User Index' )

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Customer Stats</h4>
                        <p class="card-category">
                            {{ ($latest_added_customer == 0) ? 
                            'No New Customers Added Today.' : 
                            $latest_added_customer . ' Customers Added Today.' }} 
                            {{ \Carbon\Carbon::now()->format('F j, Y') }}</p>
                    </div>
                    <div>
                        <a href="{{ route('customer.create') }}" class="btn btn-primary btn-sm">New Customer</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-success">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Points</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Function</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($customers as $index => $customer)
                                <tr>
                                    <th scope="row">{{ $index+1 }}</th>
                                    <td>{{ $customer->name }}</td>
                                    <td>{{ $customer->email }}</td>
                                    <td>{{ $customer->points }}</td>
                                    <td>{{ $customer->branch }}</td>
                                    <td>{{ $customer->created_at }}</td>
                                    <td><a href="{{ route('customer.show', $customer->user_id) }}" class="btn btn-primary btn-sm">View</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      <li class="page-item {{ ($customers->currentpage() == 1) ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ $customers->previousPageUrl() }}" tabindex="-1" aria-disabled="true" >Previous</a>
                      </li>
                      <li class="page-item disabled"><a href="#" class="page-link">{{ $customers->currentpage() }}</a></li>
                      <li class="page-item {{ ($customers->lastpage() == $customers->currentpage()) ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ $customers->nextPageUrl() }}">Next</a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
    </div>
    
    </div>
@endsection


