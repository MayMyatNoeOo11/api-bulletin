@extends('layouts.app')


@section('menu')


@endsection
@section('content')


<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
           <h2 style="display:initial" class="mr-5">SCM BulletinBoard  </h2>                
            <a href="{{route('user.profile',Auth::id())}}"  class="menu_btn "><i class="bi bi-person-circle"></i>Profile</a>

            <a href="{{ route('showAllPosts') }}"  class="menu_btn"><i class="bi bi-file-earmark-text"></i>Posts</a>
            @if(Auth::user()->type=='0')
                <a href="{{ route('showAllUsers') }}"   class="menu_btn" ><i class="bi bi-people-fill"></i>Users</a> 
            @endif  
        </div>  
    </div>     
</div>
      
@endsection


