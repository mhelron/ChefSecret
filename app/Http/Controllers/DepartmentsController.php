<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Contract\Database;
use Illuminate\Http\Request;

class DepartmentsController extends Controller
{
    protected $database, $departments, $archived_departments;

    public function __construct(Database $database){
        $this->database = $database;
        $this->departments = 'department';
        $this->archived_departments = 'archived_department';
    }

    public function index(){
        $departments = $this->database->getReference('departments')->getValue();
        $departments = is_array($departments) ? $departments : [];

        return view('departments.index', compact('departments'));
    }

    public function create(){
        return view('departments.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'department' => 'required',
            'desc' => 'required',
        ],[
            'department.required' => 'The department is required.',
            'desc.required' => 'The description is required.',
        ]);
    
        $postData = [
            'department' => $validatedData['department'],
            'desc' => $validatedData['desc'],
            'status' => 'Active'
        ];
    
        $postRef = $this->database->getReference($this->departments)->push($postData);
    
        if ($postRef) {
            return redirect('departments')->with('status', 'Department Added Successfully');
        } else {
            return redirect('departments')->with('status', 'Department Not Added');
        }
    }

    public function edit($id){
        $key = $id;

        $editdata = $this->database->getReference($this->departments)->getChild($key)->getValue(); 

        if($editdata){
            return view('departments.edit', compact('editdata', 'key'));
        } else {
            return redirect('departments')->with('status', 'Item ID Not Found');
        }
    }

    public function update(Request $request, $id){
        $key = $id;

        $validatedData = $request->validate([
            'department' => 'required',
            'desc' => 'required',
            'status' => 'required'
        ],[
            'department.required' => 'The department is required.',
            'desc.required' => 'The description is required.',
        ]);
    
        $postData = [
            'department' => $validatedData['department'],
            'desc' => $validatedData['desc'],
            'status' => $validatedData['status'],
        ];

        $res_updated = $this->database->getReference($this->departments. '/'.$key)->update($postData);

        if ($res_updated) {
            return redirect('departments')->with('status', 'Department Updated Successfully');
        } else {
            return redirect('departments')->with('status', 'Department Not Updated');
        }
    }

    public function archive($id){
        $key = $id;

        $department_data = $this->database->getReference($this->departments.'/'.$key)->getValue();

        $archive_data = $this->database->getReference($this->archived_departments.'/'.$key)->set($department_data);

        $del_data = $this->database->getReference($this->departments.'/'.$key)->remove();

        if ($del_data && $archive_data) {
            return redirect('departments')->with('status', 'Department Archived Successfully');
        } else {
            return redirect('departments')->with('status', 'Department Not Archived');
        }
    }


}
