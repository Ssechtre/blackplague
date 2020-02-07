@extends('layouts.app')

@section('title', 'User Index' )

{{-- @section('sidebar')
@parent

<p>This is appended to the master sidebar.</p>
@endsection --}}

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12 col-md-6 col-sm-6">
            @if (session()->has('message'))
                <h1>{{ session()->get('message') }}</h1>
            @endif
        </div>
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header card-header-success d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="card-title">Employees Stats</h4>
                        <p class="card-category">
                            {{ ($latest_added_user == 0) ? 
                            'No New Employees Added Today.' : 
                            $latest_added_user . ' Employees Added Today.' }} 
                            {{ \Carbon\Carbon::now()->format('F j, Y') }}
                        </p>
                    </div>
                    <div>
                        <a href="{{ route('user.create') }}" class="btn btn-primary btn-sm">New User</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover">
                        <thead class="text-success">
                            <tr>
                                <th scope="col">Id</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">User Type</th>
                                <th scope="col">Branch</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Function</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $index=>$user)
                                <tr>
                                    <th scope="row">{{ $index+1 }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->user_type }}</td>
                                    <td>{{ $user->branch }}</td>
                                    <td>{{ $user->created_at }}</td>
                                    <td><a href="{{ route('user.edit', $user->id) }}" class="btn btn-primary btn-sm">Edit</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <nav aria-label="Page navigation example">
                    <ul class="pagination justify-content-center">
                      <li class="page-item {{ ($users->currentpage() == 1) ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ $users->previousPageUrl() }}" tabindex="-1" aria-disabled="true" >Previous</a>
                      </li>
                      <li class="page-item disabled"><a href="#" class="page-link">{{ $users->currentpage() }}</a></li>
                      <li class="page-item {{ ($users->lastpage() == $users->currentpage()) ? 'disabled' : ''}}">
                        <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                      </li>
                    </ul>
                  </nav>
            </div>
        </div>
    </div>
    
    </div>
@endsection


