<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $services = Service::all();
        return view('service.index', compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('service.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'small_desc'=>'required',
            'detail_desc'=>'required',
            'photo'=>'required',
        ]);
        if($request->hasFile('photo')){
            $imageName =time(). $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('images/services', $imageName,'images');
        }

        $services = new Service();
        $services->title = $request->title;
        $services->small_desc = $request->small_desc;
        $services->detail_desc = $request->detail_desc;
        $services->photo = $imageName;
        $services->save();

        return redirect('admin/service/create')->with('success','Data has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Service $service)
    {
        return view('service.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Service $service)
    {
        return view('service.edit', compact('service'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'=>'required',
            'small_desc'=>'required',
            'detail_desc'=>'required',
        ]);
        $service = Service::findOrFail($id);

        if($request->hasFile('photo')){

            // Delete old photo
            if ($service->photo) {
                $oldImageName = $service->photo;
                $oldImagePath = public_path('images/services/' . $oldImageName);
                if(File::exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }

            $imageName = time(). $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('images/services', $imageName, 'images');
        }else{
            $imageName = $request->prev_img;
        }

        $service->title = $request->title;
        $service->small_desc = $request->small_desc;
        $service->detail_desc = $request->detail_desc;
        $service->photo = $imageName;
        $service->save();

        return redirect('admin/service/' .$service->id. '/edit')->with('success', 'Data has been updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {

        $service = Service::findOrFail($id);
        // Delete photo locally
        $oldImageName = $service->photo;
        $oldImagePath = public_path('images/services/' . $oldImageName);
        if(File::exists($oldImagePath)){
            unlink($oldImagePath);
        }

        $service->findOrFail($id)->delete();
        return redirect('admin/service')->with('success','Data has been deleted successfully.');
    }
}
