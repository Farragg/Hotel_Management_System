@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">{{$staff->full_name}} Details
                    <a href="{{ url('admin/staff') }}" class="float-right btn-sm btn-success">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <tr>
                            <th>Full Name</th>
                            <td>{{ $staff->full_name }}</td>
                        </tr>
                        <tr>
                            <th>Department</th>
                            <td>{{ $staff->department->title }}</td>
                        </tr>
                        <tr>
                            <th>Photo</th>
                            <td><img src="{{ asset('images/staff/'.$staff->full_name.'/'.$staff->photo) }}" style="width: 100px"  class="img-thumbnail" alt=""></td>
                        </tr>
                        <tr>
                            <th>Bio</th>
                            <td>{{$staff->bio}}</td>
                        </tr>
                        <tr>
                            <th>Salary Type</th>
                            <td>{{$staff->salary_type}}</td>
                        </tr>
                        <tr>
                            <th>Salary Amount</th>
                            <td>{{$staff->salary_amount}}</td>
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
