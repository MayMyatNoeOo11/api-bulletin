@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-md-2">
            <nav aria-label="breadcrumb" class="custom-bc" >
                <ol class="breadcrumb"  >
                    <li class="breadcrumb-item"><a href="{{ route('common') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('showAllUsers') }}">Users</a></li>   
                    <li class="breadcrumb-item active"><a href="{{ route('createUserForm') }}" style="color:black">Add</a></li>  
                </ol>
            </nav>
        </div>
        <div class="col-md-8 offset-md-0" style="padding-top:4px">
            <div class="card">
                <div class="card-header myheader bg-light" >
                    <h4 class="text-center">Create User</h4>
                </div>   
                <div class="card-body">
                    <form method="POST" enctype="multipart/form-data" action="{{route('user.createConfirm') }}" >
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">User Name</label> 
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" >                               

                                @error('name')
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
                            <label for="email" class="col-md-4 col-form-label text-md-right">Email</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"   autocomplete="email">

                                @error('email')
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
                            <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}"  >

                                @error('password')
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
                                <input id="password_confirmation" type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation"  value="{{ old('password_confirmation') }}"  >
                                @error('password_confirmation')
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
                            <label for="date_of_birth" class="col-md-4 col-form-label text-md-right">Date of Birth</label>
                            <div class="col-md-6">
                                 <input class="form-control dob_datepicker @error('date_of_birth') is-invalid @enderror" id="date_of_birth" name="date_of_birth"  type="text" value="{{ old('date_of_birth') }}"  autocomplete="off" autofocus/>

                                @error('date_of_birth')
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
                            <label for="type" class="col-md-4 col-form-label text-md-right">User Type</label>

                            <div class="col-md-6">  
                                <select name="type" id="type" class="form-control">
                                    <option value="0" >Admin</option>
                                    <option value="1" selected>User</option>
                                </select>
                                     
                                @error('type')
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
                            <label for="phone" class="col-md-4 col-form-label text-md-right">Phone</label>

                            <div class="col-md-6">
                                <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone') }}"  autocomplete="phone" autofocus>

                                @error('phone')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>           


                        <div class="form-group row">
                            <label for="address" class="col-md-4 col-form-label text-md-right">Address</label>

                            <div class="col-md-6">
                                <textarea id="address"  name="address" class="form-control @error('address') is-invalid @enderror" >{{ old('address') }}</textarea>

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="profile" class="col-md-4 col-form-label text-md-right">Profile Photo</label>

                            <div class="col-md-6">
                                <input id="profile_photo" name="profile_photo"  type="file" 
                                 accept=".png, .jpg, .jpeg,.jfif" onchange="validateFileType(event)"
                                  class="form-control @error('profile_photo') is-invalid @enderror" 
                                  value="{{ old('profile_photo') }}"   >

                                @error('profile_photo')
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
                            <div class="col-md-4"></div>
                            <div class="col-md-6">
                                <img class="profile_preview" name="profile_preview" src="{{URL::asset('/images/profile.jpeg')}}" id="profile_preview_image"/>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Create
                                </button>
                                <button type="reset" class="btn btn-danger">
                                    Clear
                                </button>
                            </div>
                        </div>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>
                                    {{$error}}
                                    </li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                    </form>                    
                </div>
            </div>
        </div>
</div> 
           
<script type="text/javascript">

$('.dob_datepicker').datepicker({
    format: 'yyyy/mm/dd',
    startDate: '1990-01-01',
    constrainInput: false ,
    autoClose:true,
    endDate:new Date()
});

</script>  
@endsection
