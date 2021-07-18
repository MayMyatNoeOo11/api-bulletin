@extends('layouts.app')

@section('content')
    <nav aria-label="breadcrumb" class="custom-bc" >
    <ol class="breadcrumb"  >
        <li class="breadcrumb-item"><a href="{{ route('common') }}">Home</a></li>
        @if(Auth::user()->type=='0')
            <li class="breadcrumb-item"><a href="{{ route('showAllUsers') }}">Users</a></li>
        @endif 
    
        <li class="breadcrumb-item active" aria-current="page">Profile</li>
    </ol>
    </nav>

    <div class="row mt-1">
        <div class="col-md-12">   
            <div class="col-md-8 offset-md-2 mt-2">
                <div class="row card">
                    <h4 class="text-center">User Profile</h4>
                    <div class="card-body confirm-bg-color">
                        <div class="row mb-2">                    
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <img class="profile_preview" src="{{ asset('storage/images/'.$userData->profile_photo)}}" id="profile_image_preview"/>
                                </div>
                                <div class="col-md-1 offset-md-7">
                                    <a class="btn btn-primary btn-lg" href="{{route('user.edit',Auth::id())}}">
                                        Edit
                                    </a>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    Name : 
                                </div>
                                <div class="col-md-9">
                                    {{$userData->name}}
                                </div>
                            </div> 

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    Email :
                                </div>
                                <div class="col-md-9">
                                    {{$userData->email}}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    Type :
                                </div>
                                <div class="col-md-9">
                                    @if($userData->type=="0")
                                        Admin
                                    @else
                                        User
                                    @endif
                            
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    Phone :
                                </div>
                                <div class="col-md-9">
                                    {{$userData->phone}}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    Date of Birth :
                                </div>
                                <div class="col-md-9">
                                    {{$userData->date_of_birth}}
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-3">
                                    Address :
                                </div>
                                <div class="col-md-9">
                                    {{$userData->address}}
                                </div>
                            </div> 

                        </div>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-5 offset-md-5">
                        <a type="button" class="btn btn-default btn-lg" href="{{ route('common') }}">
                            OK
                        </a>                    
                    </div>
                </div>
            </div> 
 
        </div>
    </div>
  @endsection