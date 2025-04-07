<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoriesRequest;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(Category::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        // if(!Gate::allows('category.view')){
        //     abort(403);
        // }
        $request=request();

        // if($name=$request->name){
        //     $query->where('name','LIKE',"%$name%");
        // }
        // if($status=$request->query('status')){
        //     $query->where('status','=',$status);
        // }

        // $categories= $query->paginate(3); //return collection opject
        // $query=Category::query();
        // $user=Auth::user();
        // if($user->store_id){
        //     $query->where('store_id','=',$user->store_id);
        // }
        $categories= Category::with(['parent'])
        // leftJoin('categories as parents','parents.id','=','categories.parent_id')
        // ->select(['categories.*','parents.name as parent_id'])
        // ->select('categories.*')
        // ->selectRaw('(select count(*) from products where category_id = categories.id) as product_count')
        // ->addSelect(DB::raw('((select count(*) from products where category_id = categories.id) as product_count)'))
        ->withCount(['products as product_count'=>function($query){
            return $query->where('status','=','active');
        }])
        ->filter($request->query())
        //->orderBy('categories.name',)
        ->paginate(5); //return collection opject
        // dd(Auth::user()->can('create',Category::class));

        return view('dashboard.categories.index',compact('categories','request'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Gate::authorize('category.create');
        $parents=Category::all();

        $category=new Category();
        return view('dashboard.categories.create',compact('category','parents'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(Category::rules());
        $request->merge(['slug'=>Str::slug($request->name)]);



        $data = $request->except('image');
        $data['image'] =$this->uploaded_image($request,'uploads');

        $category= Category::create($data);

        return redirect()->route('dashboard.categories.index')->with('success','category created');


    // $category = new Category();
        // $category->name = $request->name;
        // $category->parent_id = $request->post('name');
        // $category->save();

        // $category = new Category([
        //     'name'=>$request->input('name'),
        //     'status'=>$request()->get('status')
        // ]);
        // $category->save();
        // $request->validate([
        //     'name'=>['required','string','min:3','max:255','unique:categories,name,$id'],
        //     'parent_id'=>['nullable','integer','exists:categories,id'],
        //     'image'=>['image','max:1000000'],
        //     'status'=>['required','in:active,archived'],
        // ],[
        //     'required'=>'this fieled is required',
        //     'image.max'=>'the zise of image is over size '
        // ]);

        // $data = $request->except('image');
        // if($request->hasFile('image')){
        //     $file = $request->file('image');
        //     $path = $file->store('uploads','public');
        //     $data['image'] = $path;
        // }

        // dd($data);
        // $category = new Category($r equest->all());
        // $category->save();

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show',compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        try{
            $category= Category::findOrFail($id);
        }catch(Exception $e){
            return redirect()->route('dashboard.categories.index')->with('info','the category not found');
        }
        $parents = Category::where('id','<>',$id)
        ->where(function ($query)use($id) {
            $query->whereNull('parent_id')->Orwhere('parent_id','<>',$id);

        })->get();

        return view('dashboard.categories.edit',compact('category','parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriesRequest $request, string $id)
    {
       // $category = fill($request->all())->save();

        //    dd($request);
        $category=Category::findOrFail($id);
        $old_image=$category->image;
        $data = $request->except('image');
        $patt=$this->uploaded_image($request,'uploads');
        if($patt)$data['image']=$patt;



        $category->update($data);
        if($patt&& $old_image)
            Storage::disk('public')->delete($old_image);

        return redirect()->route('dashboard.categories.index')->with('success','category updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // if(Gate::denies('category.delete'))
        // dd($id);
        $category = Category::where('id',$id);
        // dd($category);
        $category->delete();
        if($category['image'])Storage::disk('public')->delete($category->image);
        // Category::destroy($id);
        return redirect()->route('dashboard.categories.index')->with('info','category is deleted');
    }
    public function uploaded_image(Request $request,$sfolder='uploads'){
        if(!$request->hasFile('image'))
        return;
        // $data = $request->except('image');
        $file = $request->file('image');
        $path = $file->store($sfolder,'public');//storage file in folder($sfolder) in public disk
         return $path;
    }

    public function trash(){
        $categories=Category::onlyTrashed()->paginate(3);
        return view('dashboard.categories.trash',compact('categories'));
    }
    public function restore(Request $request,$id){
        $category=Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.index')->with('success','restore is done');
    }
    public function force_delete(Request $request,$id){

        $category=Category::onlyTrashed()->findOrFail($id);
        $category->forcedelete();

        if($category['image'])Storage::disk('public')->delete($category->image);
        return redirect()->route('dashboard.categories.trash')->with('info','deleted is done');
    }

}
