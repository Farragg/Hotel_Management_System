<?php

namespace App\Http\Controllers;

use App\Http\Requests\StaffRequest;
use App\Models\Department;
use App\Models\Staff;
use App\Models\StaffPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $staff = Staff::all();
        return view('staff.index', compact('staff'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departments = Department::all();
        return view('staff.create', compact('departments'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StaffRequest $request)
    {
        if($request->hasFile('photo')){

            $imageName = time() . $request->file('photo')->getClientOriginalName();
            $imagePath = $request->file('photo')->storeAs('images/staff/'.$request->full_name, $imageName, 'images');
        }

        $staff = new Staff();
        $staff->full_name = $request->full_name;
        $staff->department_id = $request->department_id;
        $staff->photo = $imageName;
        $staff->bio = $request->bio;
        $staff->salary_type = $request->salary_type;
        $staff->salary_amount = $request->salary_amount;
        $staff->save();

        return redirect('admin/staff/create')->with('success', 'Data has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $staff = Staff::findOrFail($id);
        return view('staff.show', compact('staff'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $staff = Staff::findOrFail($id);
        $departments = Department::all();
        return view('staff.edit', compact('staff', 'departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $staff = Staff::findOrFail($id);

        if($request->hasFile('photo')){

            //Delete old photo
            if($staff->photo) {

                $oldImageName = $staff->photo;
                $oldImagePath = public_path('images/staff/' . $staff->full_name . '/' . $oldImageName);
                if (File::exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            $imageName = time() . $request->file('photo')->getClientOriginalName();
            $request->file('photo')->storeAs('images/staff/'.$request->full_name, $imageName, 'images');

        }else{
            $imageName = $request->prev_photo;
        }

        $staff->full_name = $request->full_name;
        $staff->department_id = $request->department_id;
        $staff->photo = $imageName;
        $staff->salary_type = $request->salary_type;
        $staff->salary_amount = $request->salary_amount;
        $staff->save();

        return redirect('admin/staff/' .$id. '/edit')->with('success', 'Data has been updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Staff $staff, $id)
    {
        //Delete old photo
        if($staff->photo) {

            $oldImageName = $staff->photo;
            $oldImagePath = public_path('images/staff/' . $staff->full_name . '/' . $oldImageName);
            if (File::exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }
        $staff->findOrFail($id)->delete();

        return redirect('admin/staff')->with('success', 'Data has been deleted successfully');
    }

    //All Payments
    public function all_payments(string $staff_id)
    {
        $payments = StaffPayment::where('staff_id', $staff_id)->get();
        $staff = Staff::findOrFail($staff_id);
        return view('staffpayment.index', compact('payments', 'staff', 'staff_id'));
    }

    //Add Payment
    public function add_payment(string $staff_id)
    {
        return view('staffpayment.create', compact('staff_id'));
    }

    public function save_payment(Request $request, string $staff_id)
    {
        $payment = new StaffPayment();
        $payment->staff_id = $staff_id;
        $payment->amount = $request->amount;
        $payment->payment_date = $request->amount_date;
        $payment->save();

        return redirect('admin/staff/payment/'.$staff_id.'/add')->with('success', 'Data has been added successfully');
    }

    public function delete_payment(string $id, string $staff_id)
    {
        StaffPayment::where('id', $id)->delete();
        return redirect('admin/staff/payments/'.$staff_id)->with('success', 'Data has been deleted successfully');
    }
}
