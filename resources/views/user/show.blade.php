{{-- @extends('layouts.app')


@section('content') --}}
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2 class="font-weight-bold">User Detail</h2>
        </div>
    </div>

    <div class="row mx-auto">
        <div class="row">
            <div class="col-md-9">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Name:</strong>
                            {{ $user->name }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group ">
                        <strong>Profile Photo:</strong>
                            {{$user->profile_photo}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Email:</strong>
                        {{ $user->email }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Phone:</strong>
                        {{ $user->phone }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Address:</strong>
                        {{ $user->address }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Date of birth:</strong>
                        {{ $user->date_of_birth }}
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Type:</strong>
                        @if($user->type=='1')
                        User
                        @elseif($user->type=='0')
                        Admin
                        @endif   
                        
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Created User:</strong>
                        {{$user->created_user_name}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Created Date:</strong>
                        {{date('Y-m-d', strtotime($user->created_at))}}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Updated Date:</strong>
                        {{date('Y-m-d', strtotime($user->updated_at))}}
                    </div>
                </div>
            </div>
            <div class="col-md-3 mx-auto">
                <img class="profile_preview" src="{{ asset('storage/images/'.$user->profile_photo)}}" id="profile_image_preview"/>

            </div>
        </div>
    </div>
    {{-- @endsection --}}
