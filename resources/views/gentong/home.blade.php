@extends('layouts.master')
@section('title') Home @endsection
@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    Hi <strong>{{ auth()->user()->name }}</strong>,
    {{ __('You are logged in as') }}
    @can('isSuperadmin')
        <span class="badge bg-green">Superadmin</span>
    @elsecan('isAdmin')
        <span class="badge bg-green">Admin</span>
    @endcan
    
@endsection
