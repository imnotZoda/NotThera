<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Manager;
use Illuminate\Support\Facades\Storage;

class ManagerController extends Controller
{
    public function index()
    {
        $managers = Manager::all();
        return view('managers.index', compact('managers'));
    }

    public function create()
    {
        return view('managers.create');
    }

    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phoneNum' => 'required|string|max:12',
            'address' => 'required',
            'username' => 'required|unique:managers',
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
        // Create manager
        Manager::create([
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'phoneNum' => $request->input('phoneNum'),
            'address' => $request->input('address'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'images' => $imageName,
        ]);
    
        return redirect()->route('managers.index')->with('success', 'Manager created successfully.');
    }
    
    public function edit($id)
    {
        $manager = Manager::findOrFail($id);
        return view('managers.edit', compact('manager'));
    }

    public function update(Request $request, $id)
    {
        // Validation
        $request->validate([
            'fname' => 'required',
            'lname' => 'required',
            'phoneNum' => 'required|string|max:12',
            'address' => 'required',
            'username' => 'required|unique:managers,username,' . $id,
            'password' => 'required',
            'images' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
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
        else {
            $manager = Manager::findOrFail($id);
            $imageName = $manager->images; // Keep the existing image if no new image is provided
        }
    
        // Update manager
        $manager = Manager::findOrFail($id);
        $manager->update([
            'fname' => $request->input('fname'),
            'lname' => $request->input('lname'),
            'phoneNum' => $request->input('phoneNum'),
            'address' => $request->input('address'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'images' => $imageName,
        ]);
    
        return redirect()->route('managers.index')->with('success', 'Manager updated successfully.');
    }

    public function destroy($id)
    {
        $manager = Manager::findOrFail($id);
        $manager->delete();
        return redirect()->route('managers.index')->with('success', 'Manager deleted successfully.');
    }
}
