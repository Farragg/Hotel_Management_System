@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Banners
                    <a href="{{ url('admin/banner/create') }}" class="float-right btn-sm btn-success">Add New</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Banner</th>
                            <th>Alt Text</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        @if($banners)
                            <?php $i=0; ?>
                            @foreach($banners as $banner)
                                <?php $i++;?>
                                <tbody>
                                <tr>
                                    <td>{{$i}}</td>
                                    <td>
                                        <img src="{{ $banner->image_path }}" style="width: 100px"  class="img-thumbnail" alt="">
                                    </td>
                                    <td> {{ $banner->alt_text }} </td>
                                    <td> {{ $banner->publish_status }} </td>
                                    <td>
                                        <a href="{{ url('admin/banner/' . $banner->id) . '/edit'}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
                                        <a onclick="return confirm('Are You Sure to Delete This Data?')" href="{{ url('admin/banner/' . $banner->id . '/delete') }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
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
