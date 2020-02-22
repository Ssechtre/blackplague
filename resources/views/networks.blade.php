@extends('layouts.app')

@section('title', 'Privileges' )

@section('content')

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">My Networks</h4>
                    <p class="card-category"> Here is a subtitle for this table</p>
                </div>
                <div class="card-body">
                    <span class="label label-danger">Danger Label</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row connections-container">  
        <div class="col-sm-12">
            <button class="parent btn btn-primary btn-round">Example <span class="label label-primary">Parent User</span></button>
            <button class="btn btn-primary btn-round child-1 col-sm-3"> <span class="label label-primary">Child One</span></button>
            <button class="btn btn-primary btn-round child-2 col-sm-3"> <span class="label label-primary">Child Two</span></button>
            <button class="btn btn-primary btn-round child-3 col-sm-3"> <span class="label label-primary">Child Three</span></button>
            <button class="btn btn-primary btn-round child-4 col-sm-3"> <span class="label label-primary">Child Four</span></button>
        </div>
    </div>
</div>
@endsection