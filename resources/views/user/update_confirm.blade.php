@extends('layouts.app')



@section('content')

    <div class="col-md-8 offset-md-2 mt-2">
        <div class="row card">
            <h4 class="text-center">Update User Confirmation</h4>
            <div class="card-body confirm-bg-color">
                <div class="row mb-2">
                    <form method="post" action="{{route('user.update',$userData->id)}}">
                    @csrf
                        <input type="hidden" value="{{$image}}" name="profile_photo" />
                        <input type="hidden" value="{{$userData->name}}" name="name" />
                        <input type="hidden" value="{{$userData->email}}" name="email" />
                        <input type="hidden" value="{{$userData->date_of_birth}}" name="date_of_birth" />
                        <input type="hidden" value="{{$userData->type}}" name="type" />
                        <input type="hidden" value="{{$userData->phone}}" name="phone" />
                        <input type="hidden" value="{{$userData->address}}" name="address" />
                        <input type="hidden" value="{{$userData->created_user_id}}" name="created_user_id" />
                        <input type="hidden" value="{{$userData->created_at}}" name="created_at" />
                        <div class="col-md-8">
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
                                    @if($userData->type=='1')
                                    User
                                    @else
                                    Admin
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
                        <div class="col-md-4">
                            <img class="profile_preview" src="{{ asset('storage/images/'.$image)}}" id="preview_image"/>
                        </div>
                    
                    </div>
                </div>

            </div>
            <div class="row mt-2">
                <div class="col-md-4 offset-md-4">
                    <button type="submit" class="btn btn-success btn-md">
                        Confirm
                    </button>
                    <a class="btn  btn-danger btn-md" href="javascript:history.back()">Cancel</a>
                </div>
            </div>
        </form>
    </div>

@endsection