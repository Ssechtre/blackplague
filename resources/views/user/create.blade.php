@extends('layouts.app')

@section('title', 'Product Index' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <form method="POST" action="{{ route('user.store') }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Create User</h4>
                        </div>
                    </div>
                    <div class="card-body table-responsive">
                        <div class="m-2">
                            <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Name') }}</label>
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="m-2">
                            <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="mr-2 ml-2 mb-2 mt-5">
                            <select class="custom-select" id="user_type" name="user_type">
                                <option selected disabled>User Type</option>
                                <option value="Admin">Admin</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>

                        <div class="mr-2 ml-2 mb-2 mt-5">
                            <select class="custom-select" id="branch" name="branch">
                                <option selected disabled>Select Branch</option>
                                <option value="Matina">Matina</option>
                                <option value="Tagum">Tagum</option>
                                <option value="Mati">Mati</option>
                            </select>
                        </div>
                        
                        <div class="m-2">
                            <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="m-2">
                            <label for="password-confirm" class="col-md-12 col-form-label text-md-center">{{ __('Confirm Password') }}</label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password"> 
                        </div>

                        <div class="mr-2 ml-2 mb-2 mt-5 d-flex justify-content-center">
                            <div>
                                <button type="submit" class="btn btn-success">
                                {{ __('Register') }}
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


