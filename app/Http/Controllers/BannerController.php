<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $banners = Banner::all();
        return view('banner.index', compact('banners'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('banner.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'banner_src' => 'required',
            'alt_text' => 'required'
        ]);

        if($request->hasFile('banner_src')){
            $imageName = time() . $request->file('banner_src')->getClientOriginalName();
            $request->file('banner_src')->storeAs('images/banners', $imageName, 'images');
        }

        $banner = new Banner();
        $banner->banner_src = $imageName;
        $banner->alt_text = $request->alt_text;
        $banner->publish_status = $request->publish_status;
        $banner->save();

        return redirect('admin/banner/create')->with('success', 'Data has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Banner $banner)
    {
        return view('banner.show', compact('banner'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Banner $banner)
    {
        return view('banner.edit', compact('banner'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'prev_photo' => 'required',
            'alt_text' => 'required'
        ]);

        $banner = Banner::findOrFail($id);

        if($request->hasFile('banner_src')){

            // Delete old photo
            if ($banner->banner_src) {
                $oldImageName = $banner->photo;
                $oldImagePath = public_path('images/banners/' . $oldImageName);
                if(File::exists($oldImagePath)){
                    unlink($oldImagePath);
                }
            }

            $imageName = time() . $request->file('banner_src')->getClientOriginalName();
            $request->file('banner_src')->storeAs('images/banners', $imageName, 'images');
        }else{
            $imageName = $request->prev_img;
        }

        $banner->banner_src = $imageName;
        $banner->alt_text = $request->alt_text;
        $banner->publish_status = $request->publish_status;
        $banner->save();

        return redirect('admin/banner/'.$banner->id.'/edit')->with('success','Data has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $banner = Banner::findOrFail($id);
        // Delete photo locally
        $oldImageName = $banner->banner_src;
        $oldImagePath = public_path('images/banners/' . $oldImageName);
        if(File::exists($oldImagePath)){
            unlink($oldImagePath);
        }
        Banner::where('id',$id)->delete();
        return redirect('admin/banner')->with('success', 'Data has been deleted successfully.');
    }
}
