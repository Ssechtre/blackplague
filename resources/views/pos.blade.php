@extends('layouts.app')

@section('title', 'About' )

@section('content')
	<pos-component users-route="{{ route('users.index') }}" products-route="{{ route('products.index') }}"></pos-component>
@endsection


