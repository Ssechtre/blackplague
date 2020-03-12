@extends('layouts.app')

@section('title', 'Privileges' )

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title ">Welcome back!</h4>
                    <p class="card-category"> View your points, privileges, and sell products with this app.</p>
                </div>
                <div class="card-body">
                    <div class="row mt-3">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Name</label>
                                <input type="text" class="form-control" value="{{ $data->name }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">User Code</label>
                                <input type="text" class="form-control" value="{{ $data->code->code }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Email</label>
                                <input type="text" class="form-control" value="{{ $data->email }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">ID</label>
                                <input type="text" class="form-control" 
                                value="{{ $data->govt_id_type." - ".$data->govt_id_number }}" disabled>
                            </div>
                        </div>
                        <div class="col-md-3 mt-3">
                            <div class="form-group">
                                <label class="bmd-label-floating">Total Referrals</label>
                                <input type="text" class="form-control" value="{{ count($networks) }}" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-12">
                            <h3>Privileges</h3>
                            <ul>
                                <li>Free check-up (Wait for announcements)</li>
                                <li>Receive 7 packs of Blackrice Mangosteen Coffee</li>
                                <li>Buy our products up to 50% discount on all items.</li>
                                <li>Convert your accumulated points into cash</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary">
                    <h4 class="card-title mt-0"><p>My Networks</p></h4>
                    <p class="card-category"> A chart that shows Health Patrol members connected to you</p>
                </div>
                <div class="card-body">
                    <div class="row">                        
                        <div class="col-md-4 offset-md-4 col-sm-12 parent-network">
                            <div class="card card-plain">
                                <div class="card-header card-header-success">
                                    <center><h4 class="card-title mt-0">{{ Auth::user()->name }}</h4></center>
                                    <center> <p class="card-category">{{ date('F d, Y H:i:s', strtotime(Auth::user()->created_at)) }}</p></center>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4"></div>

                        @foreach($networks as $key => $value)
                        <div class="col-md-3 col-sm-12 child-{{ $key+1 }}">
                            <div class="card card-plain">
                                <div class="card-header card-header-info">
                                    <h4 class="card-title mt-0">{{ $value->network_name }}</h4>
                                    <p class="card-category">Date registered : {{ $value->created_at_beautified }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<script>
    $(document).ready(function() {
        $(document).ready(function() {
            $('.parent').connections();
            $('.child-1').connections({ from: '.parent-network' });
            $('.child-2').connections({ from: '.parent-network' });
            $('.child-3').connections({ from: '.parent-network' });
            $('.child-4').connections({ from: '.parent-network' });
            setInterval(function() { connections.connections('update') }, 100);
            // $('.parent-container').connections({ to: '.child-container-4' });
        });
    });
</script>