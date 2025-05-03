<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Product::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // dd(Auth::user()->can('create',Product::class));
    //     $request= request();
    //     $user=Auth::user();

    //     $query=Product::query();
    //    if($user->store_id){
    //     $query->where('store_id','=',$user->store_id);
    //    }

        // $this->authorize('view-any',Product::class);
        // dd(Auth::user()->can('create',Product::class));
        $products=Product::with(['category','store'])->paginate();

        return view('dashboard.products.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $this->authorize('create',Product::class);
        $categories = Category::all()->pluck('name','id');
        $stores=Store::all()->pluck('name','id');
        // dd($categories);
        return view('dashboard.products.create',compact('categories','stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $this->authorize('create',Product::class);

        $request->validate([
            'store_id'=>['required','exists:stores,id'],
            'category_id'=>['required','exists:categories,id'],
            'name'=>['required','string','max:255'],
            'description'=>['string'],
            'image'=>['image','max:10000'],
            'price'=>['required'],
            'quantity'=>['required','integer'],
            'status'=>['required','in:active,archive,draf'],
            'tags'=>['string']
        ]);

        $request->merge(['slug'=>Str::slug($request->name)]);
        $data = $request->except('tags','image');

        $data['image']=$this->upload_image($request,'products__img');

        $product = Product::create($data);

        $tags_id= $this->tags_array($request->post('tags'));

        $product->tags()->sync($tags_id);

        return redirect()->route('dashboard.products.index')->with('success','creaate product success');


    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        // $this->authorize('view',$product);
        return view('dashboard.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // $this->authorize('update',$product);
        $tags=implode(',',$product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit',compact('product','tags'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request);
        // $this->authorize('update',$product);
        $old_image=$product->image;
        $data = $request->except(['image','tags']);
        $patt=$this->upload_image($request,'uploads');
        if($patt)$data['image']=$patt;
        $product->update($data);
        $tags = explode(',', $request->post('tags'));
        $saved_tags = Tag::all();
        $tag_ids=[];

        foreach($tags as $t_name){
            $slug = Str::slug($t_name);
            $tag=$saved_tags->where('slug',$slug)->first();
            if(!$tag){
                $tag= Tag::create([
                    'name'=>$t_name,
                    'slug'=>$slug
                ]);
            }
            $tag_ids[]=$tag->id;
        }
        $product->tags()->sync($tag_ids);
        // dd($product);
        return redirect()->route('dashboard.products.index')->with('success','update has done');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // $this->authorize('delete',$product);
        Product::destroy($product->id);
        if($product->image){
            Storage::disk('public')->delete($product->image);
        }
        return redirect()->route('dashboard.products.index')->with('info','deleted successfuly');

    }
    public function upload_image(Request $request,$sfolder= 'products_img'){
        if(!$request->hasFile('image')){
            return;
        }
        $image = $request->file('image');
        $path = $image->store($sfolder,'public');
        return $path;
    }
    public function tags_array($tags_re){
        $tags_save = Tag::all();
        $tags=explode(',',$tags_re);
        $tags_id=[];
        foreach($tags as $t_name){
            $t_slug = Str::slug($t_name);
            $tag = $tags_save->where('slug','=',$t_slug)->first();
            if(!$tag){
                $tag = Tag::create([
                    'name'=>$t_name,
                    'slug'=>$t_slug
                ]);
            }
            $tags_id[]=$tag->id;
        }
        return $tags_id;
    }
}
