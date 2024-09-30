<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookingRequest;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings=Booking::all();
        return view('booking.index',compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $customers=Customer::all();
        return view('booking.create',compact('customers'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BookingRequest $request)
    {
        if($request->ref == 'front'){

            $sessionData = [
                'customer_id' => $request->customer_id,
                'room_id' => $request->room_id,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'total_adults' => $request->total_adults,
                'total_children' => $request->total_children,
                'roomprice' => $request->roomprice,
                'ref' => $request->ref,
            ];
            session($sessionData);
            Stripe::setApiKey('sk_test_51Q3a1CRs2x8k1szMOQFliKC0XqQUPMDRMbfWjRKR3WCFAnyy91UonEq3QvUbFxj8zIESkUxVoTD5wyiNhEGnH4fg00sSPLR6dW');
            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'inr',
                        'product_data' => [
                            'name' => 'T-shirt',
                        ],
                        'unit_amount' => $request->roomprice*100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => 'http://127.0.0.1:8000/booking/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => 'http://127.0.0.1:8000/booking/fail',
            ]);
            return redirect($session->url);
        }else{
            $data=new Booking;
            $data->customer_id=$request->customer_id;
            $data->room_id=$request->room_id;
            $data->checkin_date = $request->checkin_date;
            $data->checkout_date = $request->checkout_date;
            $data->total_adults=$request->total_adults;
            $data->total_children=$request->total_children;
            if($request->ref=='front'){
                $data->ref='front';
            }else{
                $data->ref='admin';
            }
            $data->save();
            return redirect('admin/booking/create')->with('success','Data has been added successfully.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking, $id)
    {
        $booking->findOrFail($id)->delete();

        return redirect('admin/booking')->with('success', 'Data has been deleted successfully');
    }

    //Check Available Rooms
    public function available_rooms(Request $request, string $checkin_date)
    {
        $arooms = DB::SELECT("SELECT * FROM rooms WHERE id NOT IN (SELECT room_id FROM bookings WHERE '$checkin_date' BETWEEN checkin_date AND checkout_date)");

        $data=[];

        foreach ($arooms as $room){

            $roomTypes = RoomType::findOrFail($room->room_type_id);
            $data[] = ['room' => $room, 'roomtype' => $roomTypes];
        }

        return response()->json(['data'=>$data]);
    }
    public function front_booking()
    {
        return view('front-booking');
    }

    public function booking_payment_success(Request $request){
        \Stripe\Stripe::setApiKey('sk_test_51Q3a1CRs2x8k1szMOQFliKC0XqQUPMDRMbfWjRKR3WCFAnyy91UonEq3QvUbFxj8zIESkUxVoTD5wyiNhEGnH4fg00sSPLR6dW');
        $session = \Stripe\Checkout\Session::retrieve($request->get('session_id'));
        $customer = \Stripe\Customer::retrieve($session->customer);
        if($session->payment_status=='paid'){

            $data=new Booking;
            $data->customer_id=session('customer_id');
            $data->room_id=session('room_id');
            $data->checkin_date=session('checkin_date');
            $data->checkout_date=session('checkout_date');
            $data->total_adults=session('total_adults');
            $data->total_children=session('total_children');
            if(session('ref')=='front'){
                $data->ref='front';
            }else{
                $data->ref='admin';
            }
            $data->save();
            return view('booking.success');
        }
    }

    public function booking_payment_fail(){
        return view('booking.failure');
    }
}
