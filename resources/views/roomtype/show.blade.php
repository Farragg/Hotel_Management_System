@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Show Details
                    <a href="{{ url('admin/room-type') }}" class="float-right btn-sm btn-success">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>Title</th>
                            <td>{{ $roomtype->title }}</td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>{{ $roomtype->price }}</td>
                        </tr>
                        <tr>
                            <th>Details</th>
                            <td>{{ $roomtype->detail }}</td>
                        </tr>
                        <tr>
                            <th>Gallery Images</th>
                            <td>
                                <table class="table table-bordered mt-3">
                                    <tr>
                                        @foreach($data->roomtypeimgs as $img)
                                            <td class="imgcol{{$img->id}}">
                                                <img width="150" src="{{asset('images/roomtypes/'.$img->img_src)}}" />
                                            </td>
                                        @endforeach
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
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
