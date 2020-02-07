@extends('layouts.app')

@section('title', 'Customer Create')

@section('content')
<div class="container-fluid">
    <form action="{{ route('code.store') }}" method="POST">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-info d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Code Generator</h4>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="mt-2">
                            <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('How many codes? Maximum of 100 Minimum of 1') }}</label>
                            <input type="number" name="code" class="form-control" min="1" max="100" onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                            @error('name')
                                <label for="error" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="mt-3 d-flex justify-content-center">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                {{ __('Generate') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>  
    </div>
@endsection


