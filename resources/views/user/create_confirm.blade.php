@extends('layouts.app')


@section('content')

<form action="{{route('user.store',$userData)}}" method="post">
      @csrf
    <div class="col-md-8 offset-md-2 mt-2">
        <div class="row card">
            <h4 class="text-center">Create User Confirmation</h4>
            <div class="card-body confirm-bg-color">
                <div class="row mb-2">
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
                                Password :
                            </div>
                            <div class="col-md-9">
                                {{$userData->password}} 
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
                                Address :
                            </div>
                            <div class="col-md-9">
                                {{$userData->address}} 
                            </div>
                        </div>  
                    
                    </div>
                    <div class="col-md-4">                    
                        <img  class="profile_preview"  src="{{ asset('storage/images/'.$image)}}" id="preview_image">                       
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
    </div>

    <input type="hidden"  name="profile_photo" value="{{$image}}" />
    <input type="hidden"  name="name" value="{{$userData->name}}" />
    <input type="hidden"  name="email" value="{{$userData->email}}" />
    <input type="hidden"  name="address" value="{{$userData->address}}" />
    <input type="hidden"  name="date_of_birth" value="{{$userData->date_of_birth}}" />
    <input type="hidden" value="{{$userData->type}}" name="type" />
    <input type="hidden"  name="phone" value="{{$userData->phone}}" />
    <input type="hidden"  name="password" value="{{$userData->password}}" />

</form>
@endsection