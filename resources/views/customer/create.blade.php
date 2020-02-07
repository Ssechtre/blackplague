@extends('layouts.app')

@section('title', 'Product Index' )

@section('content')
<div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="card-title">Create Customer</h4>
                        </div>
                    </div>
                <form action="{{ route('customer.store') }}" method="POST">
                    @csrf
                    <div class="card-body table-responsive">
                        
                            <div class="form-group">
                                <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Name') }}</label>
                                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}"
                                 required autocomplete="name" autofocus>
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        
                        
                            <div class="form-group">
                                <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Email') }}</label>
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" 
                                required autocomplete="email" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        

                        
                            <div class="form-group">
                                <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Contact Number') }}</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required autocomplete="phone" autofocus>
                                @error('phone')
                                    <label for="error" class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                      

                        
                            <div class="form-group">
                                <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Address') }}</label>
                                <input type="text" name="address" class="form-control" value="{{ old('address') }}" required autocomplete="address" autofocus>
                                @error('address')
                                    <label for="error" class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                       

                        <div class="form-group">
                            <label for="up_line" class="col-md-12 col-form-label text-md-center">{{ __('Select Upline') }}</label>
                            <select class="custom-select" id="inputGroupSelect01" name="up_line">
                                <option value="0">Select Down Line. If no Down Line, leave this!</option>
                                @foreach ($customers as $customer)
                                    <option value="{{ $customer->user->id }}">{{ $customer->user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="govt_id_type" class="col-md-12 col-form-label text-md-center">{{ __('Select Government ID Type') }}</label>
                            <select class="custom-select" id="inputGroupSelect01" name="govt_id_type">
                                <option selected disabled>Government ID Type</option>
                                <option value="SSS">SSS</option>
                                <option value="Pag-ibig">Pag-ibig</option>
                                <option value="Philhealth">Philhealth</option>
                                <option value="Driver's License">Driver's License</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Government ID Number') }}</label>
                            <input type="text" name="govt_id_number" class="form-control" value="{{ old('govt_id_number') }}" required autocomplete="govt_id_number" autofocus>
                            @error('govt_id_number')
                                <label for="error" class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-center">
                            <div>
                                <button type="submit" class="btn btn-success">
                                {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
</div>
@endsection


