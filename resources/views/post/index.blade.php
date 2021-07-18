@extends('layouts.app')

@section('content')
    @if(Auth::user())
        <nav aria-label="breadcrumb" class="custom-bc" >
            <ol class="breadcrumb"  >
                <li class="breadcrumb-item"><a href="{{ route('common') }}">Home</a></li>
                <li class="breadcrumb-item active"><a href="{{ route('showAllPosts') }}">Posts</a></li>   
            </ol>
        </nav>
    @endif 
    <div class="container">
        <div class="row justify-content-center">  
            <h2>Posts</h2>   
            <div class="col-md-121" style="background-color:light;padding-top:10px;padding-bottom:10px"> 
                <form action="{{route('showAllPosts')}}" method="get">
                    <input  style="padding-left:5px" type="text" name="search" id="txt-search" value="{{$searchText}}" />
                    <button type="submit" id="btn-search" class="btn btn-large btn-info"><i class="bi bi-search"></i>&nbsp;&nbsp;Search</button>
                    <a   href="{{route('post.export')}}" name="download" id="btn-download" class="btn btn-large btn-info"><i class="bi bi-download"></i>&nbsp;&nbsp;Download</a> 
                    @if(Auth::user())
                        <a href="{{route('post.importForm')}}" name="upload" id="btn-upload" class="btn btn-large btn-info"><i class="bi bi-upload"></i>&nbsp;&nbsp;Upload</a>            
                        <a  href="{{route('post.create')}}" name="add" id="btn-add" class="btn btn-large btn-info"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;Add</a>  
                    @endif    
           
           
                </form> 
        
        </div>
        
        @if ($message = Session::get('success'))
            <div class="col-md-11 alert alert-success" id="success-msg">
                <span>{{ $message }}</span>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
            </div>
        @endif
                
        @if ($message = Session::get('fail'))
            <div class="col-md-11 alert alert-success" id="fail-msg">
                <span>{{ $message }}</span>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
       
        <div class="container mt-2">
            <table class="table table-striped table-responsive-sm table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">#</th>
                        <th scope="col">Title</th>
                        <th scope="col">Description</th>
                        <th scope="col">Created User</th>
                        <th scope="col">Created Date</th>
                        @if(Auth::user())
                        <th scope="col" ></th>
                        @else                        
                        
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($postData as $key=>$data)
                    <tr>
                        <th scope="row" style="width:1px; white-space:nowrap;">{{ ++$i}} </th>
                        <td><a data-toggle="modal" id="btn-detail" data-target="#detailModal"
                                data-attr="{{route('post.show',$data->id)}}" >{{ $data->title }}</a></td>
                        <td>{{ \Str::limit($data->description,50) }}</td>
                        <td>{{ $data->name }}</td>
                        <td>{{date_format($data->created_at,'Y-m-d')}} </td>
                        @if(Auth::user())
                        <td style="width:1px; white-space:nowrap;">
                            <form >                               
                                <a class="btn btn-sm btn-success" href="{{ route('post.edit',$data->id) }}">Edit</a>   
                                @csrf                                
                                <a class="btn btn-danger btn-sm"data-toggle="modal" id="btn-delete" data-target="#deleteModal"
                                data-attr="{{route('post.delete',$data->id)}}">Delete</a>
                            </form>
                        </td> 
                        @else                        
                        
                        @endif
                      
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
          
            {{-- Pagination --}}
            <div class="d-flex justify-content-center">           
                {{ $postData->appends(Request::except('page'))->links() }}               
            </div>
            <span class="total" > Total : {{ $postData->total() }} </span> 
        </div>        
    </div>
</div>
	
<!-- small modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="detailModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-head-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="detailBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>


<!-- delete modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModal"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header modal-head-color">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="deleteBody">
                    <div>
                        <!-- the result to be displayed apply here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
        // display a modal (small modal)
        $(document).on('click', '#btn-detail', function(event) {
            event.preventDefault();
            $('#detailBody').html('');
            let href = $(this).attr('data-attr');
           
            $.ajax({
                url: href,
                beforeSend: function() {
                  //  $('#loader').show();
                },
                // return the result
                success: function(result) {
                    $('#detailModal').modal("show");
                    $('#detailBody').html(result).show();
                },
                complete: function() {
                   // $('#loader').hide();
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                    //$('#loader').hide();
                },
                timeout: 8000
            })
        });

        //display delete modal         
        $(document).on('click', '#btn-delete', function(event) {
            event.preventDefault();
            $('#deleteBody').html('');
            let href = $(this).attr('data-attr');
           
            $.ajax({
                url: href,
                beforeSend: function() {
                 
                },
                // return the result
                success: function(result) {
                    $('#deleteModal').modal("show");
                    $('#deleteBody').html(result).show();
                },
                complete: function() {
            
                },
                error: function(jqXHR, testStatus, error) {
                    console.log(error);
                    alert("Page " + href + " cannot open. Error:" + error);
                  
                },
                timeout: 8000
            })
        });


</script>

@endsection
