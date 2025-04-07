<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stores = Store::with(['products','department'])->withCount(['products as product_count'=>function($query){
            return $query->where('status','=','active');
        }])->paginate(10);
        return view('dashboard.stores.index',compact('stores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $store = new Store();
        $departments = Department::all();

        return view('dashboard.stores.create',compact('store','departments'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'name'=>'required|string',
            'department_id'=>'required|integer|exists:departments,id',
            'description'=>'nullable|string',
            'logo_image'=>'nullable|image|max:10000',
            'cover_image'=>'nullable|image|max:10000',
            'status'=>'required|in:active,archived'
        ]);
        $request->merge(['slug'=>Str::slug($request->name)]);



        $data = $request->except(['logo_image','cover_image']);
        $data['logo_image'] =$this->uploaded_image($request,'logo_image','uploads');
        $data['cover_image'] =$this->uploaded_image($request,'cover_image','uploads');
        // dd($data);
        $store= Store::create($data);

        return redirect()->route('dashboard.stores.index')->with('success','store created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $products = Product::where('store_id',$id)->paginate();

        return view('dashboard.stores.show',compact('products'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Store $store)
    {
        $departments = Department::all();

        return view('dashboard.stores.edit',compact('store','departments'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name'=>'sometimes|required|string',
            'department_id'=>'sometimes|required|exists:departments,id',
            'description' => 'nullable|string',
            'logo_image'=>'nullable|image|max:10000',
            'cover_image'=>'nullable|image|max:10000',
            'status'=>'sometimes|required|in:active,archived'
        ]);

        $old_logo=$store->logo_image;
        $old_cover = $store->cover_image;
        $data = $request->except(['logo_image','cover_image']);
        $patt1=$this->uploaded_image($request,'logo_image','uploads');
        if($patt1)$data['logo_image']=$patt1;
        $patt2=$this->uploaded_image($request,'cover_image','uploads');
        if($patt2)$data['cover_image']=$patt2;



        $store->update($data);
        if($patt1&& $old_logo)
            Storage::disk('public')->delete($old_logo);
        if($patt2&& $old_cover)
            Storage::disk('public')->delete($old_cover);

        return redirect()->route('dashboard.stores.index')->with('success','store updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Store $store)
    {

        $store->delete();
        if($store['logo_image'])Storage::disk('public')->delete($store->logo_image);
        if($store['cover_image'])Storage::disk('public')->delete($store->cover_image);


        return redirect()->route('dashboard.stores.index')->with('info','store is deleted');
    }

    public function uploaded_image(Request $request,$name_file,$sfolder='uploads'){
        if(!$request->hasFile($name_file))
        return;
        // $data = $request->except('image');
        $file = $request->file($name_file);
        $path = $file->store($sfolder,'public');//storage file in folder($sfolder) in public disk
         return $path;
    }
}
