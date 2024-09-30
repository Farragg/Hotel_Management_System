<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $services = Service::all();
        $roomTypes = RoomType::all();
        $testimonials = Testimonial::all();
        $banners = Banner::where('publish_status', 'on')->get();
        return view('home', compact('services', 'roomTypes', 'testimonials', 'banners'));
    }

    public function service_detail(Request $request, string $id)
    {
        $service = Service::findOrFail($id);

        return view('servicedetail',compact('service'));
    }

    public function add_testimonial()
    {
        return view('add-testimonial');
    }

    public function save_testimonial(Request $request)
    {
//        dd(session('data')[0]->id);
        $customerId=session('data')[0]->id;
        $data = new Testimonial();
        $data->customer_id = $customerId;
        $data->testi_cont = $request->testi_cont;
        $data->save();

        return redirect('/customer/add-testimonial')->with('success', 'Data has been added successfully.');
    }

}
