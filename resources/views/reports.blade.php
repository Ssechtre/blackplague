@extends('layouts.app')

@section('title', 'Reports' )

@section('content')
	<report-component user-id="{{ Auth::user()->id }}" current-year="{{ date('Y', time())+1 }}"></report-component>
@endsection


