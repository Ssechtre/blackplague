@extends('layouts.app')

@section('title', 'User Show' )

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
                <a href="#">Edit Details</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            <div>
                <label for="name">Name: {{ $user->name }}</label>
            </div>
            <div>
                <label for="name">Email: {{ $user->email }}</label>
            </div>
            <div>
                <label for="name">User Type: {{ $user->user_type }}</label>
            </div>
            <div>
                <label for="name">Date Created: {{ $user->created_at }}</label>
            </div>
        </div>
    </div>    
</div>
@endsection


