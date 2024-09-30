@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Roomtypes
                    <a href="{{ url('admin/room-type/create') }}" class="float-right btn-sm btn-success">Add New</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Gallery Images</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        @if($roomtype)
                            <?php $i=0; ?>
                            @foreach($roomtype as $room)
                                <?php $i++;?>
                                <tbody>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>{{ $room->title }}</td>
                                    <td>{{ $room->price }}</td>
                                    <td>{{ count($room->roomtypeimgs) }}</td>
                                    <td>
                                        <a href="{{ url('admin/room-type/' . $room->id) }}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>
                                        <a href="{{ url('admin/room-type/' . $room->id) . '/edit'}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Are You Sure to Delete This Data?')" href="{{ url('admin/room-type/' . $room->id . '/delete') }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </td>
                                </tr>
                                </tbody>
                            @endforeach
                        @endif
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
