@extends('layouts.app')

@section('title', 'Point of Sale' )

@section('content')
	<pos-component 
	users-route="{{ route('users.index') }}" 
	products-route="{{ route('products.index') }}" 
	user-id="{{ Auth::user()->id }}"
	user-type="{{ Auth::user()->user_type }}"></pos-component>
@endsection


