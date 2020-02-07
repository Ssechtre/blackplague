@extends('layouts.app')

@section('title', 'User Index' )

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
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Employees Stats</h4>
                        <p class="card-category">New employees on 15th September, 2016</p>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <div id="app">
                        <users></users>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    </div>
@endsection


