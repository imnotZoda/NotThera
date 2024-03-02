<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Storage;
use DB;
use File;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::all();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
       // Validation
       $request->validate([
        'fname' => 'required',
        'lname' => 'required',
        'phoneNum' => 'required|string|max:12',
        'address' => 'required',
        'username' => 'required|unique:employees',
        'password' => 'required',
        'images' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);

     // Handle image upload
     $imageName = null; // Default value
    
     if ($request->hasFile('images')) {
         $image = $request->file('images');
         $fileName = time() . '_' . $image->getClientOriginalName();
         // $filePath = $request->file('images')->storeAs('uploads', $fileName, 'public');
         $image->move(public_path('uploads'), $fileName);
         $filepath= public_path('uploads/' . $fileName);
         $imageName = $fileName; // Adjust the path accordingly
     }
     // Create employee
     Employee::create([
        'fname' => $request->input('fname'),
        'lname' => $request->input('lname'),
        'phoneNum' => $request->input('phoneNum'),
        'address' => $request->input('address'),
        'username' => $request->input('username'),
        'password' => $request->input('password'),
        'images' => $imageName,
    ]);
    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');

    }

    public function edit($id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request, $id)
    {
        $query = DB::table('employees')
        ->select('employees.images')
        ->where('employees.id', '=', $id)
        ->first();

        // dd($query);
       
       $request->validate([
        'fname' => 'required',
        'lname' => 'required',
        'phoneNum' => 'required|string|max:12',
        'address' => 'required',
        'username' => 'required|unique:employees,username,' . $id,
        'password' => 'required',
        'images' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
    ]);
    $directory = public_path('uploads');
    $filePath = $directory . '/' . $query->images;
    
    
     // Handle image upload
     $imageName = null; // Default value
    
     if ($request->hasFile('images')) {
         $image = $request->file('images');
         $fileName = time() . '_' . $image->getClientOriginalName();
         $image->move(public_path('uploads'), $fileName);
         $filepath= public_path('uploads/' . $fileName);
         $imageName = $fileName; // Adjust the path accordingly
         File::delete($filePath);
     }
     else {
        
        $imageName = $query->images; // Keep the existing image if no new image is provided
    }
     // Update Employee
     $employee = Employee::findOrFail($id);
     $employee->update([
         'fname' => $request->input('fname'),
         'lname' => $request->input('lname'),
         'phoneNum' => $request->input('phoneNum'),
         'address' => $request->input('address'),
         'username' => $request->input('username'),
         'password' => $request->input('password'),
         'images' => $imageName,
     ]);
 
     return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy($id)
    {
        $query = DB::table('employees')
        ->select('employees.images')
        ->where('employees.id', '=', $id)
        ->first();

        $directory = public_path('uploads');
    $filePath = $directory . '/' . $query->images;
 //    dd($filePath);
    File::delete($filePath);

        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully!');
    }
}
