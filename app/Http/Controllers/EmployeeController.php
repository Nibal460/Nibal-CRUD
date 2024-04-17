<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $employees = Employee::where('fname', 'like', '%'.$search.'%')->latest()->paginate(5);
    
        // Calculate the index count based on the current page number and pagination limit
        $currentPage = $request->input('page', 1);
        $perPage = 5;
        $startIndex = ($currentPage - 1) * $perPage + 1;
    
        return view('employees.index', compact('employees', 'startIndex'));
    }
    
   
   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create()
   {
       return view('employees.create');
   }
   
   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
       $request->validate([
           'fname' => 'required',
           'lname' => 'required',
           'email' => 'required|email',
           'telephone' => 'required',
           'position' => 'required',
           'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
       ]);
 
       $input = $request->all();
 
       if ($image = $request->file('image')) {
           $destinationPath = 'image/';
           $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
           $image->move($destinationPath, $profileImage);
           $input['image'] = "$profileImage";
       }
   
       Employee::create($input);
    
       return redirect()->route('employees.index')
                       ->with('success','Employee created successfully.');
   }
    
   /**
    * Display the specified resource.
    *
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
   public function show(Employee $employee)
   {
       return view('employees.show',compact('employee'));
   }
    
   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
   public function edit(Employee $employee)
   {
       return view('employees.edit',compact('employee'));
   }
   
   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Employee $employee)
   {
       $request->validate([
           'fname' => 'required',
           'lname' => 'required',
           'email' => 'required',
           'telephone' => 'required',
           'position' => 'required'
       ]);
 
       $input = $request->all();
 
       if ($image = $request->file('image')) {


           $destinationPath = 'image/';
           $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
           $image->move($destinationPath, $profileImage);
           $input['image'] = "$profileImage";
       }else{
           unset($input['image']);
       }
         
       $employee->update($input);
   
       return redirect()->route('employees.index')
                       ->with('success','Employee updated successfully');
   }
 
   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Employee  $employee
    * @return \Illuminate\Http\Response
    */
   public function destroy(Employee $employee)
   {
       $employee->delete();
    
       return redirect()->route('employees.index')
                       ->with('success','Employee deleted successfully');
   }
}