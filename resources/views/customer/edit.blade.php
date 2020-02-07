@extends('layouts.app')

@section('title', 'Product Index' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-lg-6 col-md-12">
            <div class="card">
                <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Edit Customer</h4>
                    </div>
                </div>
            <form action="{{ route('customer.update', $customer->user_id) }}" method="POST">
                @method('PUT')
                @csrf
                <div class="card-body table-responsive">
                    <div class="m-2">
                        <label for="name" class="col-md-12 col-form-label text-md-center">{{ __('Name') }}</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $customer->user->name }}" required autocomplete="name" autofocus>
                        @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="m-2">
                        <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $customer->user->email }}" required autocomplete="email">
                        <input id="email" type="email" value="{{ $customer->user->email }}" hidden name="hidden_email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="m-2">
                        <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Contact Number') }}</label>
                        <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                        @error('phone')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="m-2">
                        <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Address') }}</label>
                        <input type="text" name="address" class="form-control" value="{{ $customer->address }}">
                        @error('address')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="mr-2 ml-2 mb-2 mt-5">
                        <select class="custom-select" id="user_type" name="user_type">
                            <option selected disabled>User Type</option>
                            <option value="Admin">Admin</option>
                            <option value="Staff">Staff</option>
                            <option value="Customer" Selected>Customer</option>
                        </select>
                    </div>

                    <div class="mr-2 ml-2 mb-2 mt-5">
                        <select class="custom-select" id="branch" name="branch">
                            <option selected disabled>Select Branch</option>
                            <option value="Matina" {{ ($customer->user->branch == 'Matina') ? 'Selected' : '' }}>Matina</option>
                            <option value="Tagum" {{ ($customer->user->branch == 'Tagum') ? 'Selected' : '' }}>Tagum</option>
                            <option value="Mati" {{ ($customer->user->branch == 'Mati') ? 'Selected' : '' }}>Mati</option>
                        </select>
                    </div>
                    
                    <div class="mr-2 ml-2 mb-2 mt-5">
                        <select class="custom-select" id="inputGroupSelect01" name="up_line">
                            <option value="0">Select Down Line. If no Down Line, leave this!</option>
                            {{-- @foreach ($poss_uplines as $poss_upline)
                                <option value="{{ $poss_upline->id }}"
                                    @if ($upline)
                                        {{ ($upline->name == $poss_upline->name) ? 'Selected' : ''  }}
                                    @endif
                                    >{{ $poss_upline->name }}</option>
                            @endforeach --}}
                        </select>
                        {{-- <input type="text" name="prev_upline" value="{{ ($upline) ? $upline->user_pid : '' }}" hidden> --}}
                    </div>

                    <div class="mr-2 ml-2 mb-2 mt-5">
                        <select class="custom-select" id="inputGroupSelect01" name="govt_id_type">
                            <option selected disabled>Government ID Type</option>
                            <option value="SSS" {{ ($customer->govt_id_type == 'SSS') ? 'selected' : ''}}>SSS</option>
                            <option value="Pag-ibig" {{ ($customer->govt_id_type == 'Pag-ibig') ? 'selected' : ''}}>Pag-ibig</option>
                            <option value="Philhealth" {{ ($customer->govt_id_type == 'Philhealth') ? 'selected' : ''}}>Philhealth</option>
                            <option value="Driver's License" {{ ($customer->govt_id_type == 'Driver\'s License') ? 'selected' : ''}}>Driver's License</option>
                        </select>
                    </div>

                    <div class="m-2">
                        <label for="email" class="col-md-12 col-form-label text-md-center">{{ __('Government ID Number') }}</label>
                        <input type="text" name="govt_id_number" class="form-control" value="{{ $customer->govt_id_number }}">
                        @error('govt_id_number')
                            <label for="error" class="text-danger">{{ $message }}</label>
                        @enderror
                    </div>

                    <div class="mr-2 ml-2 mb-2 mt-5 d-flex justify-content-center">
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


