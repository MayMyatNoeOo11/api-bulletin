{{-- @extends('layouts.app')


@section('content') --}}
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2 class="font-weight-bold"> Post Delete Confirmation</h2>
        </div>
    </div>

    <div class="row mx-auto">

        <form action="{{route('post.destroy')}}" method="post">
        @csrf
            <input type="hidden" name="id" value="{{$post->id}}" />
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                <h4><strong>Are you sure to delete permanently this user?</strong><h4>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Title:</strong>
                    {{ $post->title }}
                </div>
            </div>        
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Status:</strong>
                    @if($post->status=='1')
                    Active
                    @elseif($post->status=='0')
                    Not Active
                    @endif   
                    
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Date Created:</strong>
                    {{date('Y-m-d', strtotime($post->created_at))}}
                    
                </div>
            </div>
            <div class="row">
                <div class="col-md-2 offset-md-5">
                    <button type="submit" class="btn btn-danger btn-lg" >Delete</button>
                </div>
                
            </div>   
        </form>
        
    </div>
    {{-- @endsection --}}
