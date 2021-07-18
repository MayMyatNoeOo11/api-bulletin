@extends('layouts.app')

@section('content')

<div class="container"> 
        <div class="col-md-2">
            <a class="btn btn-primary" href="{{ route('showAllPosts') }}"><< Back</a>
        </div>
        <div class="container mt-4 col-md-8">
            @if(session('msg'))
            <div class="alert alert-success">
                {{ session('msg') }}
            </div>
            @endif      
            
             <!-- card-->
            <div class="card" >
                <div class="card-header myheader  bg-info text-center font-weight-bold">
                    Edit Post
                </div>
                <div class="card-body">
                    <form name="editPostForm" id="editPostForm" method="post" action="{{route('post.confirm',$post->id)}}">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control" value="{{ $post->title }}" required="Fill title">
                        </div>

                        <div class="form-group">
                            <label for="description">Description<span class="require-notation">*</span></label>
                            <textarea rows="10" name="description" class="form-control" required="">{{ $post->description }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-md btn-primary">Create</button>
                        <button type="reset" class="btn btn-md btn-danger">Clear</button>
                    </form>
                </div>
            </div><!-- end card-->
        </div>
        <div class="col-md-2">
        </div>    
</div>

@endsection