<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    public function about_us(){
        return view('about_us');
    }

    public function contact_us(){
        return view('contact_us');
    }

    public function save_contactus(Request $request){

        $request->validate([
            'full_name' => 'required',
            'email' => 'required',
            'subject' => 'required',
            'msg' => 'required',
        ]);

        $data = array(
            'name' => $request->full_name,
            'email' => $request->email,
            'subject' => $request->subject,
            'msg' => $request->msg,
        );

        Mail::send('mail', $data, function($message){
            $message->to('figo11152@gmail.com', 'Farrag')->subject('Contact Us');
            $message->from('figo11152@gmail.com','Hotel Message');
        });

        return redirect('page/contact-us')->with('success','Mail has been sent.');
    }
}
