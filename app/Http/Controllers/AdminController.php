<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Booking;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login(){
        return view('login');
    }

    //check Login
    public function check_login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required|min:6'
        ]);

        $admin = Admin::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {

            $adminData = Admin::where(['username' => $request->username, 'password' => Hash::make($request->password)])->get();
            session(['adminData'=>$adminData]);

            if($request->has('rememberme')){
                Cookie::queue('adminuser',$request->username,1440);
                Cookie::queue('adminpwd',$request->password,1440);
            }

            return redirect('admin');
        } else {
            // Username or password is incorrect
            return redirect('admin/login')->with('msg','Invalid Username/Password!!');
        }
    }

    // Logout
    public function logout(){
        session()->forget(['adminData']);
        return redirect('admin/login');
    }

    public function dashboard(){

        $bookings = Booking::selectRaw('count(id) as total_bookings, checkin_date')->groupBy('checkin_date')->get();

        $labels=[];
        $data=[];
        foreach ($bookings as $booking){
            $labels = $booking['checkin_date'];
            $data = $booking['total_bookings'];
        }

        // For Pie Chart
        $rtbookings=DB::table('room_types as rt')
            ->join('rooms as r','r.room_type_id','=','rt.id')
            ->join('bookings as b','b.room_id','=','r.id')
            ->select('rt.*','r.*','b.*',DB::raw('count(b.id) as total_bookings'))
            ->groupBy('r.room_type_id')
            ->get();
        $plabels=[];
        $pdata=[];
        foreach($rtbookings as $rbooking){
            $plabels[]=$rbooking->detail;
            $pdata[]=$rbooking->total_bookings;
        }

        return view('dashboard', compact('bookings', 'labels', 'plabels', 'data', 'pdata'));
    }

    public function testimonials()
    {
        $data = Testimonial::all();
        return view('admin_testimonials', compact('data'));
    }

    public function destroy_testimonial(string $id)
    {
        Testimonial::where('id', $id)->delete();
        return redirect('admin/testimonials')->with('success', 'Data has been deleted successfully.');
    }

}
