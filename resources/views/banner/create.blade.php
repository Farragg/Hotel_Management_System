@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Banner
                    <a href="{{ url('admin/banner') }}" class="float-right btn-sm btn-success">View All</a>
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
                    <form method="POST" action="{{ url('admin/banner') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <table class="table table-bordered" >
                            <tr>
                                <th> Banner Image <span class="text-danger">*</span></th>
                                <td> <input name="banner_src" type="file" class="form-control image"></td>
                            </tr>
                            <tr>
                                <th> Alt Text <span class="text-danger">*</span></th>
                                <td> <input name="alt_text" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th> Publish Status <span class="text-danger">*</span></th>
                                <td> <input name="publish_status" type="checkbox"></td>
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
