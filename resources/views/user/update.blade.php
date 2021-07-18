@extends('layouts.app')

@section('content')

    <div class="row">
        <div class="col-md-2">        
            <nav aria-label="breadcrumb" class="custom-bc" >
                <ol class="breadcrumb"  >
                    <li class="breadcrumb-item"><a href="{{ route('common') }}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('showAllUsers') }}">Users</a></li>   
                    <li class="breadcrumb-item active"><a href="#" style="color:black">Edit</a></li>  
                </ol>
            </nav>        
        </div>
    
        <div class="col-md-8 offset-md-0" style="padding-top:4px">
            <div class="card">
                <div class="card-header myheader bg-light" >
                    <h4 class="text-center">Edit User</h4>
                </div>

                <div class="card-body">
                    <form method="post"  enctype="multipart/form-data" action="{{route('user.updateConfirm',$userData->id)}}">
                        @csrf
                        <input type="hidden" value="{{$userData->profile_photo}}" name="old_photo" />
                        <div class="row">
                            <div class="col-md-10">                        
                                <div class="form-group row">
                                    <label for="name" class="col-md-3 col-form-label text-md-right">User Name</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $userData->name}}"  autocomplete="name" autofocus>

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
                                    <label for="email" class="col-md-3 col-form-label text-md-right">Email</label>

                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$userData->email }}"  autocomplete="email">

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
                                    <label for="type" class="col-md-3 col-form-label text-md-right">User Type</label>

                                    <div class="col-md-6">  
                                        <select name="type" id="type" class="form-control">
                                            <option value="0" {{ $userData->type == '0' ? 'selected' : '' }}>Admin</option>
                                            <option value="1" {{ $userData->type == '1' ? 'selected' : '' }}>User</option>
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
                                    <label for="phone" class="col-md-3 col-form-label text-md-right">Phone</label>

                                    <div class="col-md-6">
                                        <input id="phone" type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{$userData->phone }}"  autocomplete="phone" autofocus>

                                        @error('phone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                </div> 

                                <div class="form-group row">
                                    <label for="date_of_birth" class="col-md-3 col-form-label text-md-right">Date of Birth</label>
                                    <div class="col-md-6">
                                        <input class="form-control dob_datepicker" id="date_of_birth" name="date_of_birth" value="{{$userData->date_of_birth}}" type="text" autocomplete="off"/>
                            
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
                                    <label for="address" class="col-md-3 col-form-label text-md-right">Address</label>

                                    <div class="col-md-6">
                                        <textarea id="address"  name="address" class="form-control" >{{$userData->address }}</textarea>

                                            @error('address')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="profile" class="col-md-3 col-form-label text-md-right">Profile Photo</label>

                                    <div class="col-md-6">
                                        <input id="profile_photo"
                                             type="file"
                                              accept=".png, .jpg, .jpeg,.jfif" 
                                              
                                              onchange="validateFileType(event)" 
                                              class="form-control @error('profile_photo') is-invalid @enderror" 
                                              name="profile_photo" 
                                              autocomplete="profile_photo" autofocus/>

                                            @error('profile_photo')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                        
                                    <div class="col-md-7 offset-md-3">
                                        <img class="profile_preview" src="{{URL::asset('/images/profile.jpeg')}}" id="profile_preview_image"/>
                                    </div>
                                </div>

                                <div class="form-group row">
                                        
                                    <div class="col-md-3">
                                        <a href="{{route('user.changePasswordForm',$userData->id)}}" >Change Password</a>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-7 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Update
                                        </button>
                                        <a class="btn btn-danger" href="{{ route('showAllUsers') }}">
                                            Cancel
                                        </a>
                                        </button>
                                    </div>
                                </div>                                                
                            </div>

                            <div class="col-md-2">
                                <img class="profile_preview" src="{{ asset('storage/images/'.$userData->profile_photo)}}" id="old_profile"/>
                                <label for="lbl"> Old Profile</label>
                            </div>
                        </div>
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
