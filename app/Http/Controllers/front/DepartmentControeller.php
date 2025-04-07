<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;

class DepartmentControeller extends Controller
{
    public function index(){
        $departments = Department::all();
        return view('front.departments.index',compact('departments'));
    }

    public function show($id)
    {
        $departments = Department::all();
        $department = Department::findOrFail($id);
        $storeIds = Store::where('department_id',$id)->pluck('id');

        $products = Product::whereIn('store_id', $storeIds)->get();
        // dd($products);

        return view('front.departments.show2',compact('departments','department','products'));
    }
    public function filterStore(int $id)
    {
        $departments = Department::all();
        $stores = Store::where('department_id',$id)->paginate();
        return view('front.store.index',compact('stores','departments'));
    }


}
