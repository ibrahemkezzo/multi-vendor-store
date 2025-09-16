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
        $user = Auth::user();

        $query = Product::with(['category', 'store']); // نبدأ بالكويري مع العلاقات

        // إذا المستخدم عنده متجر → جيب منتجات متجره فقط
        if ($user->store_id) {
            $query->where('store_id', $user->store_id);
        }
        // Authorize
        // $this->authorize('view-any', Product::class);

        // Paginate
        $products = $query->paginate();

        return view('dashboard.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::guard('admin')->user();

        // نبدأ بكويري عادي
        $query = Category::query();

        // إذا مو سوبر أدمن → نجيب فقط كاتيجوري نفس قسم متجره
        if (!$user->super_admin && $user->store_id) {
            $query->where('department_id', $user->store->department_id);
        }

        // بعدين نعمل pluck
        $categories = $query->pluck('name', 'id');

        // السوبر أدمن بيقدر يختار أي متجر
        $stores = $user->super_admin
            ? Store::pluck('name', 'id')
            : Store::where('id', $user->store_id)->pluck('name', 'id');

        return view('dashboard.products.create', compact('categories', 'stores'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('admin')->user(); // جلب الأدمن الحالي

        // ✅ Validation
        $rules = [
            'category_id' => ['required', 'exists:categories,id'],
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'image'       => ['nullable', 'image', 'max:10000'],
            'price'       => ['required'],
            'quantity'    => ['required', 'integer'],
            'status'      => ['required', 'in:active,archive,draf'],
            'tags'        => ['nullable', 'string']
        ];

        // إذا سوبر أدمن → لازم يرسل store_id
        if ($user->super_admin) {
            $rules['store_id'] = ['required', 'exists:stores,id'];
        }

        $request->validate($rules);

        // ✅ تجهيز البيانات
        $request->merge(['slug' => Str::slug($request->name)]);
        $data = $request->except('tags', 'image');

        // إذا المستخدم مو سوبر أدمن → استخدم متجره تلقائياً
        if (!$user->super_admin) {
            $data['store_id'] = $user->store_id;
        }

        // ✅ رفع الصورة
        $data['image'] = $this->upload_image($request, 'products__img');

        // ✅ إنشاء المنتج
        $product = Product::create($data);

        // ✅ ربط التاغز
        $tags_id = $this->tags_array($request->post('tags'));
        $product->tags()->sync($tags_id);

        return redirect()->route('dashboard.products.index')->with('success', 'Product created successfully!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        // $this->authorize('view',$product);
        return view('dashboard.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // $this->authorize('update',$product);

        $user = Auth::guard('admin')->user();

        // نبدأ بكويري عادي
        $query = Category::query();

        // إذا مو سوبر أدمن → نجيب فقط كاتيجوري نفس قسم متجره
        if (!$user->super_admin && $user->store_id) {
            $query->where('department_id', $user->store->department_id);
        }

        // بعدين نعمل pluck
        $categories = $query->pluck('name', 'id');
        $tags = implode(',', $product->tags()->pluck('name')->toArray());
        return view('dashboard.products.edit', compact('product', 'tags','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        // dd($request);
        // $this->authorize('update',$product);
        $old_image = $product->image;
        $data = $request->except(['image', 'tags']);
        $patt = $this->upload_image($request, 'uploads');
        if ($patt) $data['image'] = $patt;
        $product->update($data);
        $tags = explode(',', $request->post('tags'));
        $saved_tags = Tag::all();
        $tag_ids = [];

        foreach ($tags as $t_name) {
            $slug = Str::slug($t_name);
            $tag = $saved_tags->where('slug', $slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => $slug
                ]);
            }
            $tag_ids[] = $tag->id;
        }
        $product->tags()->sync($tag_ids);
        // dd($product);
        return redirect()->route('dashboard.products.index')->with('success', 'update has done');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // $this->authorize('delete',$product);
        Product::destroy($product->id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        return redirect()->route('dashboard.products.index')->with('info', 'deleted successfuly');
    }
    public function upload_image(Request $request, $sfolder = 'products_img')
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $image = $request->file('image');
        $path = $image->store($sfolder, 'public');
        return $path;
    }
    public function tags_array($tags_re)
    {
        $tags_save = Tag::all();
        $tags = explode(',', $tags_re);
        $tags_id = [];
        foreach ($tags as $t_name) {
            $t_slug = Str::slug($t_name);
            $tag = $tags_save->where('slug', '=', $t_slug)->first();
            if (!$tag) {
                $tag = Tag::create([
                    'name' => $t_name,
                    'slug' => $t_slug
                ]);
            }
            $tags_id[] = $tag->id;
        }
        return $tags_id;
    }
}
