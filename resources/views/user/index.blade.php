@extends('layouts.app')


@section('content')
    <nav aria-label="breadcrumb" class="custom-bc" >
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('common') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('showAllUsers') }}">Users</a></li>   
        </ol>
    </nav>
    <div class="container">

        @if ($message = Session::get('success'))
        <div class="col-md-11 alert alert-success" id="success-msg">
            <span>{{ $message }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        @if ($message = Session::get('fail'))
        <div class="col-md-11 alert alert-danger" id="fail-msg">
            <span>{{ $message }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
        

    <div class="row justify-content-center">  
        <h2>Users List</h2>   
        <div class="col-md-12" style="background-color:light;padding-top:10px;padding-bottom:10px"> 
            <div class="form-inline">
                <form method="get" action="{{route('showAllUsers')}}" id="search">
        
                    <input class="form-control mr-2" placeholder="Name" style="padding-left:2px" type="text" name="name" id="name"  value="{{$name}}"/>
                    <input class="form-control mr-2" placeholder="Email" type="text" name="email" id="email"  value="{{$email}}"/>          
                    <input class="form-control mr-2 from_datepicker" placeholder="Created From Date" type="text" name="created_from_date" id="created_from_date" value="{{$created_from_date}}" autocomplete="off" />
                    <input class="form-control mr-2 to_datepicker" placeholder="Created To Date" type="text" name="created_to_date" id="created_to_date" value="{{$created_to_date}}" autocomplete="off"  />
                    <button type="submit" name="search" id="btn-search" class=" btn btn-large btn-info mr-2" onclick="search()"><i class="bi bi-search"></i>&nbsp;&nbsp;Search</button>
                </form>
                <button type="button" name="clear" id="btn-clear" class="btn btn-large btn-info  mr-5" onclick="clearSearchBox()">Clear</button>
                <a  href="{{route('user.create')}}" name="add" id="btn-add" class="btn btn-large btn-info"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;Add</a>        
            </div>
        </div>
        
        <div class="container">
            <table class="table table-striped table-responsive table-bordered mb-5">
                <thead>
                    <tr class="table-success">
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Created User</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Birthday</th>
                        <th scope="col">Address</th>
                        <th scope="col">Created Date</th>
                        <th scope="col">Updated Date</th>
                        <th scope="col"></th>                        
                    </tr>
                </thead>
                <tbody>
                    @foreach($userData as $key=>$data)
                    <tr>
                            <td class="align-center">{{++$k}}</td>
                            <td class="align-center"><a data-toggle="modal" id="btn-detail" data-target="#detailModal"
                                    data-attr="{{route('user.show',$data->id)}}">{{ $data->name }}</a></td>
                            <td class="align-center">{{$data->email}}</td>
                            <td class="align-center">{{$data->created_user_name}}</td>
                            <td class="align-center">{{$data->phone?:'-'}}</td>
                            <td class="align-center">{{$data->date_of_birth}}</td>
                            <td class="align-center">{{ $data->address? \Str::limit($data->address,15) : '-'}}</td>
                            <td class="align-center">{{date('Y-m-d', strtotime($data->created_at))}}</td>
                            <td class="align-center">{{date('Y-m-d', strtotime($data->updated_at))}}</td>
                        
                            <td>
                            <form>
                                <a class="btn btn-success btn-sm" href="{{route('user.edit',$data->id)}}">Edit</a>
                                <a class="btn btn-danger btn-sm"data-toggle="modal" id="btn-delete" data-target="#deleteModal"
                                    data-attr="{{route('user.delete',$data->id)}}">Delete</a>
                            </form>
                        </td>  
                    
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-center"> 
                {{ $userData->appends(Request::except('page'))->links() }}
            </div>
            <span class="total" > Total : {{ $userData->total() }} </span>
        </div>        
    </div>
</div>
	
<!-- small detail modal -->
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
 <!--end detail modal-->

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
  <!--end delete modal-->
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


    function clearSearchBox()
    {
    document.getElementById("name").value="";
    document.getElementById("email").value="";
    document.getElementById("created_from_date").value="";
    document.getElementById("created_to_date").value="";
    $( "#search" ).submit();
    
  
  //  location.reload();
    }
    $('.from_datepicker').datepicker({
        format: 'yyyy/mm/dd',
        startDate: '1990-01-01',
        constrainInput: false ,
        autoClose:true,
        endDate:new Date()
    });
    $('.to_datepicker').datepicker({
        format: 'yyyy/mm/dd',
        startDate: '1990-01-01',
        constrainInput: false ,
        autoClose:true,
        endDate:new Date()
    });
</script>

@endsection