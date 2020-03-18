@extends('layouts.app')

@section('title', 'Commissions' )

@section('content')
	<commission-component 
	user-id="{{ Auth::user()->id }}" 
	current-year="{{ date('Y', time()) }}"
	current-month="{{ date('Y-m-d', time()) }}"
	user-type="{{ Auth::user()->user_type }}">
	</commission-component>
@endsection


