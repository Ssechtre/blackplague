@extends('layouts.app')

@section('title', 'Payouts' )

@section('content')
	<payouts-component 
	user-id="{{ Auth::user()->id }}" 
	current-year="{{ date('Y', time()) }}"
	current-month="{{ date('Y-m-d', time()) }}"
	user-type="{{ Auth::user()->user_type }}">
	</payouts-component>
@endsection


