@extends('layouts.app')

@section('title', 'Reports' )

@section('content')
	<commission-component user-id="{{ Auth::user()->id }}" current-year="{{ date('Y', time())+1 }}"></commission-component>
@endsection


