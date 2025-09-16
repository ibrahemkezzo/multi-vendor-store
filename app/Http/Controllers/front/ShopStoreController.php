<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Department;
use App\Models\Role;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ShopStoreController extends Controller
{
    public function index(){
        $stores = Store::paginate(12);
        $departments = Department::all();
        return view('front.store.index',compact('stores','departments'));
    }
    public function show($slug){
        $store = Store::where('slug','=',$slug)->with('products')->first();
        // dd($store);

        return view('front.store.show',compact('store'));
    }

    /**
     * Show create store page
     */
    public function create()
    {
        // جلب الأقسام لعرضها في القائمة المنسدلة
        $departments = Department::all();
        return view('front.store.create', compact('departments'));
    }

    /**
     * Save store and admin
     */
/**
     * Save store and admin
     */
    public function store(Request $request)
    {

        // dd($request->all());
        $role = Role::where('name', 'store-manager')->first();
        // dd($role->id);
        // التحقق من صحة البيانات
        $validated = $request->validate([
            'admin.name'         => 'required|string|max:255',
            'admin.username'     => 'required|string|max:255|unique:admins,username',
            'admin.email'        => 'required|email|unique:admins,email',
            'admin.phone_number' => 'required|string|max:20',
            'admin.password'     => 'required|string|min:6',

            'store.name'         => 'required|string|max:255',
            'store.slug'         => 'required|string|max:255|unique:stores,slug',
            'store.department_id'=> 'required|exists:departments,id',
            'store.description'  => 'nullable|string',
            'store.logo_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'store.cover_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);
        // dd($validated);

        DB::beginTransaction();
        try {

            // تجهيز صور المتجر
            $logoPath = null;
            if ($request->hasFile('store.logo_image')) {
                $logoPath = $request->file('store.logo_image')->store('stores/logos', 'public');
            }

            $coverPath = null;
            if ($request->hasFile('store.cover_image')) {
                $coverPath = $request->file('store.cover_image')->store('stores/covers', 'public');
            }

            // إنشاء المتجر
            $store = Store::create([
                'name'          => $request->store['name'],
                'slug'          => Str::slug($request->store['slug']),
                'department_id' => $request->store['department_id'],
                'description'   => $request->store['description'] ?? null,
                'logo_image'    => $logoPath,
                'cover_image'   => $coverPath,
                'status'        => 'active',
            ]);

            // إنشاء الأدمن
            $admin = Admin::create([
                'name'        => $request->admin['name'],
                'username'    => $request->admin['username'],
                'email'       => $request->admin['email'],
                'phone_number'=> $request->admin['phone_number'],
                'password'    => Hash::make($request->admin['password']),
                'super_admin' => false,
                'status'      => 'active',
                'store_id'      => $store->id,
            ]);

            $admin->roles()->attach($role->id);

            DB::commit();

            Auth::guard('admin')->login($admin);

            // ممكن تضيف علاقة بين المتجر والأدمن هنا لو بدك (ex: store_admins table)

            return redirect()->route('dashboard.')->with('success', 'Store and Admin created successfully!');
        } catch (\Exception $e) {
            DB::rollback();

            // حذف الملفات المرفوعة إذا حدث خطأ
            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }

            return redirect()->back()->with('info', 'An error occurred while creating the store and admin: ' . $e->getMessage());
        }
        return redirect()->route('dashboard.')->with('success','created store successfuly');
    }

}
