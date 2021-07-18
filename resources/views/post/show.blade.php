{{-- @extends('layouts.app')


@section('content') --}}
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2 class="font-weight-bold"> {{ $post->title }}</h2>
        </div>
    </div>

    <div class="row mx-auto">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Title:</strong>
                {{ $post->title }}
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Description:</strong>
                <pre style="font-family:var(--mdb-font-roboto)">{{ $post->description }}</pre>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Created User:</strong>
                {{ $post->name }}
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
        
    </div>
    {{-- @endsection --}}
