<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $departments = Department::paginate();

        return view('dashboard.departments.index',compact('departments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department = new Department();
        return view('dashboard.departments.create',compact('department'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|string',
            'description'=>'nullable|string',
            'image'=>'nullable|image'
        ]);
        $data = $request->except('image');
        $data['image'] =$this->uploaded_image($request,'uploads');

        $department= Department::create($data);
        return redirect()->route('dashboard.departments.index')->with('success','department created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stores = Store::where('department_id',$id)->paginate();
        return view('dashboard.departments.show',compact('stores'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Department $department)
    {
        return view('dashboard.departments.edit',compact('department'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' =>'sometimes|required|string',
            'descriptions' => 'nullable|string',
            "image"=>'nullable|image',
        ]);

        $old_image=$department->image;
        $data = $request->except('image');
        $patt=$this->uploaded_image($request,'uploads');
        if($patt)$data['image']=$patt;



        $department->update($data);
        if($patt&& $old_image)
            Storage::disk('public')->delete($old_image);


        return redirect()->route('dashboard.departments.index')->with('success','department updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Department $department)
    {
          if($department['image'])Storage::disk('public')->delete($department->image);
          $department->delete();

        return redirect()->route('dashboard.departments.index')->with('info','department is deleted');
    }

    public function uploaded_image(Request $request,$sfolder='uploads'){
        if(!$request->hasFile('image'))
        return;
        // $data = $request->except('image');
        $file = $request->file('image');
        $path = $file->store($sfolder,'public');//storage file in folder($sfolder) in public disk
         return $path;
    }
}
