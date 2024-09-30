<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $customers = Customer::all();
        return view('customer.index', compact('customers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CustomerRequest $request)
    {

        if ($request->hasFile('photo')){

            $imageName = $request->file('photo')->getClientOriginalName();
            $imagePath = $request->file('photo')->storeAs('images/customers', $imageName,'images');
        }

        $customer = new Customer();
        $customer->full_name = $request->full_name;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->mobile = $request->mobile;
        $customer->address = $request->address;
        $customer->photo = $imageName;
        $customer->save();

        $ref=$request->ref;
        if($ref=='front'){
            return redirect('register')->with('success','Data has been added successfully.');
        }

        return redirect('admin/customer/create')->with('success', 'Data has been added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        return view('customer.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        try {
            DB::beginTransaction();

            if ($request->hasFile('photo')) {
                // Delete old photo
                if ($customer->photo) {
                    $oldImageName = $customer->photo;
                    $oldImagePath = public_path('images/customers/' . $oldImageName);
                    if(File::exists($oldImagePath)){
                        unlink($oldImagePath);
                    }
                }

                $imageName = $request->file('photo')->getClientOriginalName();
                $request->file('photo')->storeAs('images/customers', $imageName, 'images');

            }else{
                $imageName = $request->prev_img;

            }

            $customer->full_name = $request->full_name;
            $customer->email = $request->email;
            $customer->password = Hash::make($request->password);
            $customer->mobile = $request->mobile;
            $customer->photo = $imageName;
            $customer->save();
            DB::commit();
            return redirect('admin/customer/' .$customer->id. '/edit')->with('success', 'Data has been updated successfully');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Customer $customer, $id)
    {
        $customer = Customer::findOrFail($id);

        // Delete photo locally
        $oldImageName = $customer->photo;
        $oldImagePath = public_path('images/customers/' . $oldImageName);
        if(File::exists($oldImagePath)){
            unlink($oldImagePath);
        }

        $customer->findOrFail($id)->delete();

        return redirect('admin/customer')->with('success', 'Data has been deleted successfully');
    }

    public function login()
    {
        return view('frontlogin');
    }
    //Check Login
    public function customer_login(Request $request)
    {

        $email = Customer::where('email', $request->email)->first();

        if($email && Hash::check($request->password, $email->password)){
            $detail=Customer::where('email', $request->email)->get();
            session(['customerlogin'=>true,'data'=>$detail]);
            return redirect('/');
        }else{
            return redirect('login')->with('error','Invalid email Or password!!');
        }
    }

    public function register(){
        return view('register');
    }

    public function logout(){
        session()->forget(['customerlogin','data']);
        return redirect('login');
    }
}
