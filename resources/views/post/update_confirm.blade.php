@extends('layouts.app')

@section('content')

  <nav aria-label="breadcrumb" class="custom-bc" >
    <ol class="breadcrumb"  >
      <li class="breadcrumb-item"><a href="{{ route('showAllPosts') }}">Home</a></li>
      <li class="breadcrumb-item"><a href="{{ route('showAllPosts') }}">Posts</a></li>
      <li class="breadcrumb-item active" aria-current="page">Edit</li>
    </ol>
  </nav>


<!-- <h3>Create Post Confirmation </h3> -->
  <div class="row mt-1">
    <div class="col-md-12">      
      <form action="{{route('post.update',$post->id)}}" method="post">
        @csrf    

          <input type="hidden" id="title" name="title" value="{{$post->title}}" />
          <input type="hidden" id="description" name="description" value=" {{$post->description}}" />  
          <input type="hidden" name="created_user_id" value="{{$post->created_user_id}}" id="created_user_id"/>
          <input type="hidden" name="status"  value="{{$postStatus}}" id="status" />
          
          <div class="col-md-8 offset-md-2 mt-2">
            <div class="row card">
              <h4 class="text-center">Update Post Confirmation</h4>
              <div class="card-body confirm-bg-color">
                <div class="row mb-2">                    
                    <div class="row mb-3">
                        <div class="col-md-3">
                                Title :
                        </div>
                        <div class="col-md-9">
                            {{$post->title}}   
                        </div>
                      </div>
                      @if(Auth::user()->type=='0')
                        <div class="col-md-3">
                            Status :
                        </div>
                        <div class="col-md-9">
                            @if($postStatus=='1')
                              Active
                            @else
                              Not Active
                            @endif
                        </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-3">
                                Description :
                            </div>
                            <div class="col-md-9">
                              <pre style="font-family:var(--mdb-font-roboto)">{{$post->description}}</pre>
                            </div>
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
   
      </form>
    </div>
  </div>
  @endsection