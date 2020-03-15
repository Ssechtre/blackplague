@extends('layouts.app')

@section('title', 'Reports' )

@section('content')
	<commission-component 
	user-id="{{ Auth::user()->id }}" 
	current-year="{{ date('Y', time())+1 }}"
	user-type="{{ Auth::user()->user_type }}">
	</commission-component>
@endsection


