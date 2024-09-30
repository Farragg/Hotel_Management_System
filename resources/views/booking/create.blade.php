@extends('layout')

@section('content')
    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Add Booking
                    <a href="{{ url('admin/booking') }}" class="float-right btn-sm btn-success">View All</a>
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
                    <form method="POST" action="{{ url('admin/booking') }}">
                        @csrf
                        @method('POST')
                        <table class="table table-bordered" >
                            <tr>
                                <th> Select Customer <span class="text-danger">*</span></th>
                                <td>
                                    <select class="form-control" name="customer_id">
                                        <option value="0">--- Select ---</option>
                                        @foreach($customers as $customer)
                                            <option value="{{$customer->id}}">{{$customer->full_name}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <th>CheckIn Date <span class="text-danger">*</span></th>
                                <td> <input name="checkin_date" type="date" class="form-control checkin-date"></td>
                            </tr>
                            <tr>
                                <th>CheckingOut Date <span class="text-danger">*</span></th>
                                <td> <input name="checkout_date" type="date" class="form-control"></td>
                            </tr>
                            <tr>
                                <th> Available Rooms <span class="text-danger">*</span></th>
                                <td>
                                    <select class="form-control room-list" name="room_id">

                                    </select>
                                    <p>Price: <span class="show-room-price"></span></p>
                                </td>
                            </tr>
                            <tr>
                                <th>Total Adults <span class="text-danger">*</span></th>
                                <td> <input name="total_adults" type="number" class="form-control"></td>
                            </tr>
                            <tr>
                                <th>Total Children <span class="text-danger">*</span></th>
                                <td> <input name="total_children" type="number" class="form-control"></td>
                            </tr>
                            <tr>
                                <input type="hidden" name="roomprice" class="room-price" value="" />
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
    <script type="text/javascript">
        $(document).ready(function(){
            $(".checkin-date").on('blur',function(){
                var _checkindate=$(this).val();
                // Ajax
                $.ajax({
                    url:"{{url('admin/booking')}}/available-rooms/"+_checkindate,
                    dataType:'json',
                    beforeSend:function(){
                        $(".room-list").html('<option>--- Loading ---</option>');
                    },
                    success:function(res){
                        var _html='';
                        $.each(res.data,function(index,row){
                            _html+='<option data-price="'+row.roomtype.price+'" value="'+row.room.id+'">'+row.room.title+'-'+row.roomtype.title+'</option>';
                        });
                        $(".room-list").html(_html);

                        var _selectedPrice=$(".room-list").find('option:selected').attr('data-price');
                        $(".room-price").val(_selectedPrice);
                        $(".show-room-price").text(_selectedPrice);
                    }
                });
            });

            $(document).on("change",".room-list",function(){
                var _selectedPrice=$(this).find('option:selected').attr('data-price');
                $(".room-price").val(_selectedPrice);
                $(".show-room-price").text(_selectedPrice);
            });

        });
    </script>
@endsection
