<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use \App;

class EmployeeController extends Controller
{
    public function show(){
        return view('index', 
            ['companies' => App\Models\Company::get(), 
             'employees' => App\Models\Employee::join('companies', 'employees.c_id', '=', 'companies.id')->select('employees.*', 'companies.c_name')->get()]);
    }

    public function create(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required|numeric',
            'company' => 'required',
        ]);

        App\Models\Employee::insert(['e_name' => $request->input('name'), 'e_address' => $request->input('address'),'e_contact' => $request->input('contact'),'c_id' => $request->input('company')]);
        return response()->json(['url'=>url('/')]);
    }

    public function edit($id){
        return App\Models\Employee::where('id', '=', $id)->get();
    }

    public function update(Request $request){
        $validatedData = $request->validate([
            'name' => 'required',
            'address' => 'required',
            'contact' => 'required|numeric',
            'company' => 'required',
        ]);

        App\Models\Employee::findOrFail($request->input('id'))->update(['e_name' => $request->input('name'), 'e_address' => $request->input('address'),'e_contact' => $request->input('contact'),'c_id' => $request->input('company')]);
        return response()->json(['url'=>url('/')]);
    }

    public function delete(Request $request){
        App\Models\Employee::where('id', $request->input('id'))->delete();
        return response()->json(['url'=>url('/')]);
    }
}
