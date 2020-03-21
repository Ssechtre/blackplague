@extends('layouts.app')

@section('title', 'Edit' )

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-4">
			<div class="card">
				<div class="card-header card-header-primary">
                  <h4 class="card-title ">Change Password</h4>
                  <p class="card-category">Change your password here</p>
                </div>
                <div class="card-body mt-4">
                	<div class="row">
                        <div class="col-md-12 col-sm-12">
                            <form method="POST" action="{{ route('user.change_password', Auth::user()->id) }}">
                                @method('PUT')
                                @csrf
                                <div class="form-group mt-4">								
                                    <label class="control-label">Old Password</label>
                                    <input type="password" class="form-control" name="old_password">					
                                </div>
                                <div class="form-group mt-4">								
                                    <label class="control-label">New Password</label>
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