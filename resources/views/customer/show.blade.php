@extends('layouts.app')

@section('title', 'Customer Show' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Customer Stats</h4>
                        <p class="card-category">New employees on 15th September, 2016</p>
                    </div>
                    <div>
                        <a href="{{ route('customer.edit', $customer->user_id) }}" class="btn btn-primary btn-sm">Edit Details</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div class="row">
                        <div class="col-lg-12 col-md-6 col-sm-6">
                            @if (session()->has('message'))
                                <h3>{{ session()->get('message') }}</h3>
                            @endif
                        </div>
                        <div class="col-lg-12">
                            <h4>Name: <strong>{{ $customer->user->name }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Email: <strong>{{ $customer->user->email }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Branch: <strong>{{ $customer->user->branch }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Contact Number: <strong>{{ $customer->phone }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Address: <strong>{{ $customer->address }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Government ID Type: <strong>{{ $customer->govt_id_type }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Government ID Number: <strong>{{ $customer->govt_id_number }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Upline: <strong>{{ ($upline) ? $upline->name : 'N/A' }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Points: <strong>{{ $customer->points }}</strong></h4>
                        </div>
                        <div class="col-lg-12">
                            <h4>Code: <strong>{{ $customer->code->code }}</strong></h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </div>
@endsection


