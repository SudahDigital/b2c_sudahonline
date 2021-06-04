@extends('layouts.master')
@if(Route::is('users.edit'))
    @section('title') Edit User @endsection
    @section('content')

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('users.update',[$user->id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->name}}" name="name" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>
            
            <!--
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->username}}" name="username" autocomplete="off" required disabled>
                    <label class="form-label">UserName</label>
                </div>
            </div>
            -->
            <h2 class="card-inside-title">Status</h2>
            <div class="form-group">
                <input type="radio" value="ACTIVE" name="status" id="ACTIVE" {{$user->status == 'ACTIVE' ? 'checked' : ''}}>
                <label for="ACTIVE">ACTIVE</label>
                                &nbsp;
                <input type="radio" value="INACTIVE" name="status" id="INACTIVE" {{$user->status == 'INACTIVE' ? 'checked' : ''}}>
                <label for="INACTIVE">INACTIVE</label>
            </div>

            <h2 class="card-inside-title">Roles</h2>
            <div class="form-group">
                <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles" id="ADMIN" value="SUPERADMIN" required {{$user->roles == "SUPERADMIN" ? "checked" : ""}}> <label for="ADMIN">Super Admin</label>
                <input class="form-control {{$errors->first('roles') ? "is-invalid" : "" }}" type="radio" name="roles" id="STAFF" value="ADMIN" {{$user->roles == "ADMIN" ? "checked" : ""}}> <label for="STAFF">Admin</label>
                <div class="invalid-feedback">
                    {{$errors->first('roles')}}
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->phone}}" name="phone" minlength="10" maxlength="12" autocomplete="off" required>
                    <label class="form-label">Phone Number</label>
                </div>
                <div class="help-info">Min.10, Max. 12 Characters</div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <textarea name="address" rows="4" class="form-control no-resize" placeholder="Address" autocomplete="off" required>{{$user->address}}</textarea>
                </div>
            </div>

            <h2 class="card-inside-title">Avatar Image</h2>
            <div class="form-group">
            <div class="form-line">
                @if($user->avatar)
                <img src="{{asset('storage/'.$user->avatar)}}" width="120px"/>
                @else
                No Avatar
                @endif
                <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off">
                <small
                    class="text-muted">Leave it blank if you don't want to change your avatar
                </small>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" value="{{$user->email}}" class="form-control" name="email" autocomplete="off" disabled="disabled" required>
                    <label class="form-label">Email</label>
                </div>
            </div>

            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>&nbsp;
            <a href="{{route('users.index')}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
        </form>

        <!-- #END#  -->		

    @endsection
@endif

@if(Route::is('sales.edit'))
    @section('title') Edit Sales @endsection
    @section('content')

        @if(session('status'))
            <div class="alert alert-success">
                {{session('status')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('sales.update',[$user->id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->name}}" name="name" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->phone}}" name="phone" minlength="10" maxlength="13" autocomplete="off" required>
                    <label class="form-label">Phone Number</label>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <address><small><b>Address</b></small></address>
                    <textarea name="address" rows="2" class="form-control no-resize" placeholder="Address" id="address" autocomplete="off" required>{{$user->address}}</textarea>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" value="{{$user->email}}" class="form-control" name="email" autocomplete="off" disabled="disabled" required>
                    <label class="form-label">Email</label>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" name="sales_area" value="{{$user->sales_area}}"autocomplete="off" required>
                    <label class="form-label">Sales Area</label>
                </div>
            </div>
            <!--
            <small><b>Sales Area</b></small>
            <select name="city_id"  id="city_id" class="form-control"></select>
            <br>
            <br>
            -->
            <!--
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->username}}" name="username" autocomplete="off" required disabled>
                    <label class="form-label">UserName</label>
                </div>
            </div>
            -->
            <h2 class="card-inside-title">Status</h2>
            <div class="form-group">
                <input type="radio" value="ACTIVE" name="status" id="ACTIVE" {{$user->status == 'ACTIVE' ? 'checked' : ''}}>
                <label for="ACTIVE">ACTIVE</label>
                                &nbsp;
                <input type="radio" value="INACTIVE" name="status" id="INACTIVE" {{$user->status == 'INACTIVE' ? 'checked' : ''}}>
                <label for="INACTIVE">INACTIVE</label>
            </div>

            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>&nbsp;
            <a href="{{route('sales.index')}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
        </form>

        <!-- #END#  -->		

    @endsection
    
    @section('footer-scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script>
            $('#city_id').select2({
            placeholder: 'Select an item',
            ajax: {
                url: '{{URL::to('/ajax/cities/search')}}',
                processResults: function (data) {
                return {
                    results:  $.map(data, function (item) {
                        return {
                                id: item.id,
                                text: item.city_name
                            
                        }
                    })
                };
                }
                
            }
            });

            var cities = JSON.stringify([{!! $user->cities !!}]);
            cities = JSON.parse(cities);
            cities.forEach(function(city){
            var option = new Option(city.city_name, city.id, true, true);
            $('#city_id').append(option).trigger('change');
            });
        </script>
    @endsection

@endif

@if(Route::is('spv.edit'))
    @section('title') Detail Supervisor @endsection
    @section('content')
        <!-- Modal add item -->
        <div class="modal fade" id="addItemModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Item Group</h4>
                    </div>
                    <div class="modal-body">
                        <form action="{{route('spv.update',[$user->id])}}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" value="PUT">
                            <select id="list_user" class="users" multiple="multiple" name="sls_id[]" style="width: 100%;" required>
                                @foreach ($sales_list as $sls_list)
                                    <option value="{{ $sls_list->id }}">
                                        {{ $sls_list->name }}
                                    </option>
                                @endforeach
                            </select>
                    </div>
                    <div class="modal-footer">
                            <button type="submit" name="save_action" value="ADD" class="btn bg-teal waves-effect">Add</button>
                            <button type="button" class="btn bg-grey waves-effect" data-dismiss="modal">Close</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @if(session('status_user'))
            <div class="alert alert-success">
                {{session('status_user')}}
            </div>
        @endif
        <!-- Form Create -->
        <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('spv.update',[$user->id])}}">
            @csrf
            <input type="hidden" name="_method" value="PUT">
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->name}}" name="name" autocomplete="off" required>
                    <label class="form-label">Name</label>
                </div>
            </div>
            
            <div class="form-group form-float">
                <div class="form-line">
                    <input type="text" class="form-control" value="{{$user->phone}}" name="phone" minlength="10" maxlength="13" autocomplete="off" required>
                    <label class="form-label">Phone Number</label>
                </div>
                <div class="help-info">Min.10, Max. 13 Characters</div>
            </div>

            <div class="form-group">
                <div class="form-line">
                    <address><small><b>Address</b></small></address>
                    <textarea name="address" rows="2" class="form-control no-resize" placeholder="Address" id="address" autocomplete="off" required>{{$user->address}}</textarea>
                </div>
            </div>

            <h2 class="card-inside-title">Avatar Image</h2>
            <div class="form-group">
            <div class="form-line">
                @if($user->avatar)
                <img src="{{asset('storage/'.$user->avatar)}}" width="120px"/>
                @else
                No Avatar
                @endif
                <input type="file" name="avatar" class="form-control" id="avatar" autocomplete="off">
                <small
                    class="text-muted">Leave it blank if you don't want to change your avatar
                </small>
                </div>
                <label id="name-error" class="error" for="avatar">{{ $errors->first('avatar') }}</label>
            </div>

            @if(session('status'))
                <div class="alert alert-success">
                    {{session('status')}}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="padding-left:20px;">Name</th>
                                <th>#</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($user->spv->count() > 0)
                                @foreach($user->spv as $spv)
                                    <tr>
                                        <td style="padding-left:20px;">
                                            @php
                                                $name = \App\User::where('id',$spv->sls_id)->first();
                                            @endphp
                                            {{$name->name}}
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-danger btn-xs waves-effect" data-toggle="modal" data-target="#deleteModal{{$spv->id}}"><i class="material-icons">delete</i></button>
                                            <!-- Modal Delete -->
                                            <div class="modal fade" id="deleteModal{{$spv->id}}" tabindex="-1" role="dialog">
                                                <div class="modal-dialog modal-sm" role="document">
                                                    <div class="modal-content modal-col-red">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title">Delete Sales</h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            Delete this sales ?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <form action="{{route('spv.update',[$user->id])}}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="_method" value="PUT">
                                                                <input type="hidden" name="del_id" value="{{$spv->id}}">
                                                                <button type="submit" name="save_action" value="DELETE_ITEM" class="btn-link waves-effect">Delete</button>
                                                                <button type="button" class="btn btn-link waves-effect" data-dismiss="modal">Close</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                    <button type="button" class="btn bg-deep-purple waves-effect" data-toggle="modal" data-target="#addItemModal" style="margin-left:20px;margin-bottom:20px;">
                        <i class="material-icons" style="font-size:1.2em;">add</i>Add Sales Team Member 
                    </button>
                </div>
            </div>

            <div class="form-group form-float">
                <div class="form-line">
                    <input type="email" value="{{$user->email}}" class="form-control" name="email" autocomplete="off" disabled="disabled" required>
                    <label class="form-label">Email</label>
                </div>
            </div>

            <h2 class="card-inside-title">Status</h2>
            <div class="form-group">
                <input type="radio" value="ACTIVE" name="status" id="ACTIVE" {{$user->status == 'ACTIVE' ? 'checked' : ''}}>
                <label for="ACTIVE">ACTIVE</label>
                                &nbsp;
                <input type="radio" value="INACTIVE" name="status" id="INACTIVE" {{$user->status == 'INACTIVE' ? 'checked' : ''}}>
                <label for="INACTIVE">INACTIVE</label>
            </div>

            <button class="btn btn-primary waves-effect" type="submit">SUBMIT</button>&nbsp;
            <a href="{{route('spv.index')}}" class="btn bg-deep-orange waves-effect" >&nbsp;CLOSE&nbsp;</a>
        </form>

        <!-- #END#  -->		

    @endsection
    
    @section('footer-scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script>
            $(".users").select2({
                width: 'resolve' // need to override the changed default
            });
        </script>
    @endsection

@endif