{{-- @extends('layouts.app')


@section('content') --}}
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="text-center">
            <h2 class="font-weight-bold">User Delete Confirmation</h2>
        </div>
    </div>

    <div class="row mx-auto">
        <div class="row">
            <form method="post" action="{{route('user.destroy')}}">
             @csrf
                <input type="hidden" value="{{$data->id}}" name="id" />
                <input type="hidden" value="{{$data->name}}" name="name" />
   
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <h4><strong>Are you sure to delete permanently this user?</strong><h4>
               
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>User name:</strong>
                            {{$data->name}}
                    </div>
                </div>
 
                <div class="col-xs-2 col-sm-2 col-md-2 offset-md-5">
                    <div class="form-group">
                        <button type="submit" class="btn btn-md btn-danger" name="btn-delete" > <strong>Delete </strong></button>                
                     </div>
                </div>

            </form>
 
        </div>
    </div>
    {{-- @endsection --}}
