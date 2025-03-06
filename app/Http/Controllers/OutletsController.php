<?php

namespace App\Http\Controllers;

use Kreait\Firebase\Contract\Database;
use Illuminate\Http\Request;

class OutletsController extends Controller
{
    protected $database, $categories, $archived_categories;

    public function __construct(Database $database){
        $this->database = $database;
        $this->categories = 'categories';
        $this->archived_categories = 'archived_categories';
    }

    public function index(){
        $categories = $this->database->getReference('categories')->getValue();
        $categories = is_array($categories) ? $categories : [];

        return view('categories.index', compact('categories'));
    }

    public function create(){
        return view('categories.create');
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'category' => 'required',
            'desc' => 'required',
        ],[
            'category.required' => 'The first name field is required.',
            'desc.required' => 'The last name field is required.',
        ]);
    
        $postData = [
            'category' => $validatedData['category'],
            'desc' => $validatedData['desc'],
            'status' => 'Active'
        ];
    
        $postRef = $this->database->getReference($this->categories)->push($postData);
    
        if ($postRef) {
            return redirect('categories')->with('status', 'Category Added Successfully');
        } else {
            return redirect('categories')->with('status', 'Category Not Added');
        }
    }

    public function edit($id){
        $key = $id;

        $editdata = $this->database->getReference($this->categories)->getChild($key)->getValue(); 

        if($editdata){
            return view('categories.edit', compact('editdata', 'key'));
        } else {
            return redirect('categories')->with('status', 'Item ID Not Found');
        }
    }

    public function update(Request $request, $id){
        $key = $id;

        $validatedData = $request->validate([
            'category' => 'required',
            'desc' => 'required',
            'status' => 'required'
        ],[
            'category.required' => 'The first name field is required.',
            'desc.required' => 'The last name field is required.',
        ]);
    
        $postData = [
            'category' => $validatedData['category'],
            'desc' => $validatedData['desc'],
            'status' => $validatedData['status'],
        ];

        $res_updated = $this->database->getReference($this->categories. '/'.$key)->update($postData);

        if ($res_updated) {
            return redirect('categories')->with('status', 'Category Updated Successfully');
        } else {
            return redirect('categories')->with('status', 'Category Not Updated');
        }
    }

    public function archive($id){
        $key = $id;

        $categories_data = $this->database->getReference($this->categories.'/'.$key)->getValue();

        $archive_data = $this->database->getReference($this->archived_categories.'/'.$key)->set($categories_data);

        $del_data = $this->database->getReference($this->categories.'/'.$key)->remove();

        if ($del_data && $archive_data) {
            return redirect('categories')->with('status', 'Category Archived Successfully');
        } else {
            return redirect('categories')->with('status', 'Category Not Archived');
        }
    }


}
