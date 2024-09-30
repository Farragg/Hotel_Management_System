@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Staff
                    <a href="{{ url('admin/staff') }}" class="float-right btn-sm btn-success">View All</a>
                </h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if(Session::has('success'))
                        <p class="text-success"> {{ Session('success') }} </p>
                    @endif
                    <form method="POST" action="{{ url('admin/staff/'. $staff->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <table class="table table-bordered" >
                            <tr>
                                <th> Full Name </th>
                                <td> <input name="full_name" value="{{$staff->full_name}}" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Select Department</th>
                                <td>
                                    <select name="department_id" class="form-control image">
                                        <option value="0">--- Select ---</option>
                                        @foreach($departments as $department)
                                            <option @if($staff->id==$department->id) selected @endif value="{{$department->id}}">{{ $department->title }}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>Photo </th>
                                <td>
                                    <input name="photo" type="file" class="form-control image">
                                    <input type="hidden" value="{{$staff->photo}}" name="prev_photo" />
                                    <img src="{{ asset('images/staff/'.$staff->full_name.'/'.$staff->photo) }}" style="width: 100px"  class="img-thumbnail" alt="">
                                </td>
                            </tr>
                            <tr>
                                <th> Bio </th>
                                <td><textarea class="form-control" name="bio"></textarea></td>
                            </tr>
                            <tr>
                                <th> Salary Type</th>
                                <td>
                                    <input @if($staff->salary_type == 'daily') checked @endif name="salary_type" type="radio" value="daily"> Daily
                                    <input @if($staff->salary_type == 'monthly') checked @endif name="salary_type" type="radio" value="monthly"> Monthly
                                </td>
                            </tr>
                            <tr>
                                <th> Salary Amount </th>
                                <td><input value="{{$staff->salary_amount}}" name="salary_amount" type="number" ></td>
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
