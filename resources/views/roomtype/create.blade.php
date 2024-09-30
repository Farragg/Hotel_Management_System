@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Create RoomType
                    <a href="{{ url('admin/room-type') }}" class="float-right btn-sm btn-success">View All</a>
                </h6>
            </div>
            <div class="card-body">

                @if($errors->any())
                    @foreach($errors->all() as $error)
                        <p class="text-danger">{{$error}}</p>
                    @endforeach
                @endif

                @if(Session::has('success'))
                    <p class="text-success">{{session('success')}}</p>
                @endif
                <div class="table-responsive">
                    <form method="POST" action="{{ url('admin/room-type') }}" enctype="multipart/form-data">
                        @csrf
                        <table class="table table-bordered" >
                            <tr>
                                <th> Title</th>
                                <td> <input name="title" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Price</th>
                                <td> <input name="price" type="number" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Details</th>
                                <td> <textarea name="detail" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <th>Gallery</th>
                                <td><input type="file" multiple name="imgs[]" /></td>
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
@endsection
