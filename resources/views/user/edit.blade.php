@extends('layouts.app')

@section('title', 'Edit' )

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-12">
			<div class="card">
				<div class="card-header card-header-primary">
                  <h4 class="card-title ">Edit</h4>
                  <p class="card-category">Edit valuable information here</p>
                </div>
                <div class="card-body mt-4">
                	<div class="row">
                		<div class="col-md-5 col-sm-5">
                            <form method="POST" action="{{ url('users/'.$user->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group mt-4">								
                                    <label class="control-label">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{$user->name}}">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="{{$user->email}}">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">User Type</label>
                                    <select name="user_type" class="form-control">
                                        <option value="admin">Admin</option>
                                        <option value="staff">Staff</option>
                                        <option value="customer">Member</option>
                                    </select>
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Branch</label>
                                    <input type="text" class="form-control" name="branch" value="{{$user->branch}}">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{$user->phone}}">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="{{$user->address}}">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Government ID Type</label>
                                    <input type="text" class="form-control" name="govt_id_type" value="{{$user->govt_id_type}}">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Government ID Number</label>
                                    <input type="text" class="form-control" name="govt_id_number" value="{{$user->govt_id_number}}">					
                                </div>
                                <div class="form-group">
                                    <a class="btn btn-info" href="#"><i class="fa fa-arrow-left"></i> Go back</a>
                                    <button class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="col"></div>
                        <div class="col-md-5 col-sm-5">
                            <form method="POST" action="{{ url('users/'.$user->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group mt-4">								
                                    <label class="control-label">Password</label>
                                    <input type="password" class="form-control" name="password">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">Confirm Password</label>
                                    <input type="password" class="form-control" name="password_confirmation">					
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-success pull-right"><i class="fa fa-save"></i> Save</button>
                                </div>
                            </form>
                		</div>
                	</div>
                </div>
			</div>
		</div>
	</div>
</div>

@endsection