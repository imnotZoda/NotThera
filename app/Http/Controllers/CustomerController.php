<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Customer;
use Illuminate\Support\Facades\Storage;
use DB;
use File;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
       
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phoneNum' => 'required|string|max:12',
            'address' => 'required',
            'username' => 'required|unique:customers',
            'password' => 'required',
            'images' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
       
        $imageName = null; 
        if ($request->hasFile('images')) {
            $image = $request->file('images');
            $fileName = time() . '_' . $image->getClientOriginalName();
            // $filePath = $request->file('images')->storeAs('uploads', $fileName, 'public');
            $image->move(public_path('uploads'), $fileName);
            $filepath= public_path('uploads/' . $fileName);
            $imageName = $fileName; 
            
        }
        
        Customer::create([
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'phoneNum' => $request->input('phoneNum'),
            'address' => $request->input('address'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'images' => $imageName,
        ]);
    
        return redirect()->route('customers.index')->with('success', 'Customer created successfully.');
    }
    
    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $query = DB::table('customers')
        ->select('customers.images')
        ->where('customers.id', '=', $id)
        ->first();

        // dd($query);
    

        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phoneNum' => 'required|string|max:12',
            'address' => 'required',
            'username' => 'required|unique:customers,username,' . $id,
            'password' => 'required',
            'images' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $directory = public_path('uploads');
        $filePath = $directory . '/' . $query->images;
        
         $imageName = null; 
    
         if ($request->hasFile('images')) {
             $image = $request->file('images');
             $fileName = time() . '_' . $image->getClientOriginalName();
             // $filePath = $request->file('images')->storeAs('uploads', $fileName, 'public');
             $image->move(public_path('uploads'), $fileName);
             $filepath= public_path('uploads/' . $fileName);
             $imageName = $fileName; 
             File::delete($filePath);
         }
        else {
            
            $imageName = $query->images; 
        }
    

        $customer = Customer::findOrFail($id);
        $customer->update([
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'phoneNum' => $request->input('phoneNum'),
            'address' => $request->input('address'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'images' => $imageName,
        ]);
    
        return redirect()->route('customers.index')->with('success', 'Customer updated successfully.');
    }

    public function destroy($id)
    {
        $query = DB::table('customers')
        ->select('customers.images')
        ->where('customers.id', '=', $id)
        ->first();

        $directory = public_path('uploads');
            $filePath = $directory . '/' . $query->images;
            File::delete($filePath);

        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
