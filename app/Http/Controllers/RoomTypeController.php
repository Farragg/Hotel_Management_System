<?php

namespace App\Http\Controllers;

use App\Models\RoomType;
use App\Models\RoomTypeImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class RoomTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roomtype = RoomType::all();
        return view('roomtype.index', compact('roomtype'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('roomtype.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=>'required',
            'price'=>'required',
            'detail'=>'required',
        ]);

        $roomType = new RoomType();
        $roomType->title = $request->title;
        $roomType->price = $request->price;
        $roomType->detail = $request->detail;
        $roomType->save();

        foreach ($request->file('imgs') as $img){

            $imageName = time() . $img->getClientOriginalName();
            $imgPath = $img->storeAs('images/roomtypes', $imageName, 'images');
            $imgStore = new RoomTypeImage();
            $imgStore->room_type_id = $roomType->id;
            $imgStore->img_src = $imageName;
            $imgStore->img_alt = $request->title;
            $imgStore->save();
        }

        return redirect('admin/room-type/create')->with('success', 'Data has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roomtype = RoomType::findOrFail($id);
        return view('roomtype.show', compact('roomtype'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,string $id)
    {
        $roomtype = RoomType::findOrFail($id);
        return view('roomtype.edit', compact('roomtype'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $roomtype = RoomType::findOrFail($id);

        $roomtype->title = $request->title;
        $roomtype->price = $request->price;
        $roomtype->detail = $request->detail;
        $roomtype->save();

        if($request->hasFile('imgs')) {

            foreach ($request->file('imgs') as $img){

                $imageName = time() . $img->getClientOriginalName();
                $img->storeAs('images/roomtypes', $imageName, 'images');
                $imgStore = new RoomTypeImage();
                $imgStore->room_type_id = $roomtype->id;
                $imgStore->img_src = $imageName;
                $imgStore->img_alt = $request->title;
                $imgStore->save();
            }
        }

        return redirect('admin/room-type/' .$roomtype->id. '/edit')->with('success', 'Data has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $roomtype = RoomType::findOrFail($id);

        $roomtype->delete();

        return redirect('admin/room-type')->with('success', 'Data has been deleted successfully');

    }

    public function destroy_image($img_id)
    {
        $data=Roomtypeimage::where('id',$img_id)->first();
        // Delete photo locally
        $oldImageName = $data->img_src;
        $oldImagePath = public_path('images/roomtypes/' . $oldImageName);
        if(File::exists($oldImagePath)){
            unlink($oldImagePath);
        }
        Roomtypeimage::where('id',$img_id)->delete();
        return response()->json(['bool'=>true]);

    }
}
