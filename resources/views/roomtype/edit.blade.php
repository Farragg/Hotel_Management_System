@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit {{ $roomtype->title }} RoomType
                    <a href="{{ url('admin/room-type') }}" class="float-right btn-sm btn-success">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if(Session::has('success'))
                        <p class="text-success"> {{ Session('success') }} </p>
                    @endif
                    <form method="POST" action="{{ url('admin/room-type/' . $roomtype->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="table table-bordered" >
                            <tr>
                                <th> Title</th>
                                <td> <input value="{{ $roomtype->title }}" name="title" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td> <input value="{{$roomtype->price}}" name="price" type="number" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Details</th>
                                <td> <textarea value="{{ $roomtype->detail }}" name="detail" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <th>Gallery</th>
                                <td>
                                    <table class="table table-bordered mt-3">
                                        <tr>
                                            <input type="file" multiple name="imgs[]" />
                                            @foreach($roomtype->roomtypeimgs as $img)
                                                <td class="imgcol{{$img->id}}">
                                                    <img width="150" src="{{asset('images/roomtypes/'.$img->img_src)}}" />
                                                    <p class="mt-2">
                                                        <button type="button" onclick="return confirm('Are you sure you want to delete this image??')" class="btn btn-danger btn-sm delete-image" data-image-id="{{$img->id}}"><i class="fa fa-trash"></i></button>
                                                    </p>
                                                </td>
                                            @endforeach
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="2"><input type="submit" class="btn btn-primary"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection


@section('scripts')
    <!-- Custom styles for this page -->
    <link href="{{ asset('vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Page level plugins -->
    <script src="{{ asset('vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('js/demo/datatables-demo.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $(".delete-image").on('click',function(){
                var _img_id=$(this).attr('data-image-id');
                var _vm=$(this);
                $.ajax({
                    url:"{{url('admin/roomtypeimage/delete')}}/"+_img_id,
                    dataType:'json',
                    beforeSend:function(){
                        _vm.addClass('disabled');
                    },
                    success:function(res){
                        if(res.bool==true){
                            $(".imgcol"+_img_id).remove();
                        }
                        _vm.removeClass('disabled');
                    }
                });
            });
        });
    </script>
@endsection
