@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Customer
                    <a href="{{ url('admin/customer') }}" class="float-right btn-sm btn-success">View All</a>
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
                    <form method="POST" action="{{ url('admin/customer') }}" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        <table class="table table-bordered" >
                            <tr>
                                <th> Full Name <span class="text-danger">*</span></th>
                                <td> <input name="full_name" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Email <span class="text-danger">*</span></th>
                                <td> <input name="email" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th> Password <span class="text-danger">*</span></th>
                                <td>
                                    <div class="input-group">
                                        <input name="password" id="password" type="password" class="form-control">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-eye-slash" id="togglePassword" style="cursor: pointer;"></i>
                                            </span>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <th> Password Confirmation <span class="text-danger">*</span></th>
                                <td>
                                    <input name="password_confirmation" type="password" id="password" class="form-control">
                                </td>
                            </tr>
                            <tr>
                                <th>Mobile<span class="text-danger">*</span></th>
                                <td> <input name="mobile" type="text" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Address</th>
                                <td> <textarea name="address" class="form-control"></textarea></td>
                            </tr>
                            <tr>
                                <th>Photo <span class="text-danger">*</span></th>
                                <td> <input name="photo" type="file" class="form-control image"></td>
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

    <!-- Show Password -->
    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);

            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
@endsection
