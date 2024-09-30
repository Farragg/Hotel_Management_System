@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{$service->title}} Details
                    <a href="{{ url('admin/service') }}" class="float-right btn-sm btn-success">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>Title</th>
                            <td>{{ $service->title }}</td>
                        </tr>
                        <tr>
                            <th>Small Detail</th>
                            <td>{{ $service->small_desc }}</td>
                        </tr>
                        <tr>
                            <th>Full Detail</th>
                            <td>{{ $service->detail_desc }}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td><img src="{{ $service->image_path }}" style="width: 100px"  class="img-thumbnail" alt=""></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->

@endsection

