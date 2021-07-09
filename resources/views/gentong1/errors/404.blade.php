@extends('layouts.master-error')

@section('content')
<div class="row justify-content-center">
  <div class="col-md-8 text-center">
    <div class="alert alert-danger">
      <h1>404</h1>
      <h4>{{$exception->getMessage()}}</h4>
    </div>
  </div>
</div>
@endsection