@extends('customer.layouts.template-nocart')
@section('title') Profil @endsection
@section('content')
<style>
   .red-tooltip{
       cursor:pointer;
    }

    
</style>
<script>
    $(document).ready(function(){
        $("a").tooltip();
    });
</script>
    <div class="container">
        
        <div class="row align-middle">
            <div class="col-sm-12 col-md-12">
                <nav aria-label="breadcrumb" class="float-right mt-0">
                    <ol class="breadcrumb px-0 button_breadcrumb">
                        <li id="prf-brd" class="breadcrumb-profil-item active mt-1" aria-current="page">Profil</li>&nbsp;
                        <li class="breadcrumb-profil-item" style="color: #000!important;"><a href="{{ url('/') }}"><i class="fa fa-home"></i></a></li>
                    </ol>
                </nav>
            </div>
        </div>
        
            
        <div class="row justify-content-end mt-5 ">
            <a class="red-tooltip" data-toggle="modal" data-target="#modal-avatar" style="z-index: 3">
                @if(\Auth::user()->avatar)
                    <img class="image-profil-user rounded-circle" src="{{asset('storage/'.Auth::user()->avatar)}}" alt="user" />
                @else
                    <img class="image-profil-user " src="{{asset('assets/image/image-noprofile.png')}}" alt="user"/>
                @endif
            </a>
            <div class="col-md-7 profil-row" style="background: transparent;z-index:2;">
                <div id="col-hdn-prf" class="col-6 col-md-12">
                    <p class="heading-profil">Hello!</p>
                    <p class="name-profil">{{Auth::user()->name}}</p>
                    <nav aria-label="breadcrumb" class="mt-n3">
                        <ol class="breadcrumb px-0 button_breadcrumb" style="background:transparent;">
                            <li class="breadcrumb-profil-name active mt-2 " aria-current="page">{{$user->sales_area}}</li>&nbsp;&nbsp;
                            <li class="breadcrumb-profil-name " style="color: #000!important;">Mega Cools</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-12 col-md-10">
                    <p class="detail-profil">
                        {{$user->profile_desc}} 
                        <span data-toggle="modal" data-target="#modal-bio">
                            <a class="red-tooltip" data-toggle="tooltip" data-placement="top" title="Ubah bio anda">
                                <i class="fas fa-pencil-alt"></i>
                            </a>
                        </span> 
                    </p>
                    
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <!-- Modal picture -->
    <div class="modal fade" id="modal-avatar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" style="color:#153651">Edit Foto Profil</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('profil.update',[$user->id])}}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">
                    @if($user->avatar)
                    <img src="{{asset('storage/'.$user->avatar)}}" width="120px"/>
                    @else
                    <img  src="{{asset('assets/image/image-noprofile.png')}}" alt="user" width="120px"/>
                    @endif
                    <input type="file" name="avatar" class="form-control input-avatar" id="avatar" autocomplete="off" style="">
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn button_profil">Simpan</button>
            </div>
                </form>
        </div>
        </div>
    </div>

    <!-- Modal bio-->
    <div class="modal fade" id="modal-bio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel" style="color:#153651">Edit Bio</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form id="form_validation" method="POST" enctype="multipart/form-data" action="{{route('profil.update',[$user->id])}}">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">    
                    <textarea name="profil_desc" rows="4" class="form-control no-resize" placeholder="Bio" autocomplete="off" required></textarea> 
            </div>
            <div class="modal-footer">
            <button type="submit" class="btn button_profil">Simpan</button>
            </div>
            </form>
        </div>
        </div>
    </div>
    <script>
        if ($(window).width() < 601) {
            //$('#prf-brd').removeClass('mt-1');
            $('#col-hdn-prf').removeClass('col-6');
            $('#col-hdn-prf').addClass('pr-n2');
        } 
    </script>
@endsection
