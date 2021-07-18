@extends('layouts.app')

@section('content')
<nav aria-label="breadcrumb" class="custom-bc" >
    <ol class="breadcrumb"  >
        <li class="breadcrumb-item"><a href="{{ route('common') }}">Home</a></li>
        @if(Auth::user()->type=='0')
            <li class="breadcrumb-item"><a href="{{ route('showAllUsers') }}">Users</a></li>
        @endif 
    

    </ol>
    </nav>
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card ">
                <div class="card-header myheader">
                    Change Password
                </div>

                <div class="card-body">
                    <form method="POST" action="{{route('user.changePassword')}}">
                        @csrf                       
                        <input type="hidden" name="id" value="{{$userData->id}}" />
                        <input type="hidden" name="password" value="{{$userData->password}}"/>

       
                        @if(Auth::user()->id==$userData->id)
                        @else
                       
                        <h3>Change Password for User-<span><strong>{{$userData->name}}</strong></span></h3>
                        @endif
                        <div class="form-group row">
                            <label for="old_password" class="col-md-4 col-form-label text-md-right">Old Password</label>

                            <div class="col-md-6">
                                <input  id="old_password" type="password"  class="form-control @error('old_password') is-invalid @enderror " value="{{ old('old_password') }}" name="old_password" />

                                @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <span class="require-notation">*</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">New Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('new_password') is-invalid @enderror" value="" name="new_password"  >

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <span class="require-notation">*</span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Confirm Password</label>

                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control @error('new_confirm_password') is-invalid @enderror" value="" name="new_confirm_password" >
                                
                                @error('new_confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="col-md-1">
                                <span class="require-notation">*</span>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Change
                                </button>
                                <input type="reset" value="Cancel" class="btn btn-light"/>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

