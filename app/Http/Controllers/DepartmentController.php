<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::all();
        return view('department.index', compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('department.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|min:2',
            'detail' => 'required'
        ]);
        $department = new Department();
        $department->title = $request->title;
        $department->detail = $request->detail;
        $department->save();

        return redirect('admin/department/create')->with('success', 'Data has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $department = Department::findOrfail($id);
        return view('department.show', compact('department'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $department = Department::findOrfail($id);
        return view('department.edit', compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'detail' => 'required'
        ]);
        $department = Department::findOrFail($id);
        $department->title = $request->title;
        $department->detail = $request->detail;
        $department->save();

        return redirect('admin/department/'.$id. '/edit')->with('success', 'Data has been added successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Department::where('id',$id)->delete();
        return redirect('admin/department')->with(['sucess', 'Data has been deleted successfully']);
    }
}
