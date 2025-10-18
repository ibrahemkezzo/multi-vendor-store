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
use Stripe\StripeClient;

class ShopStoreController extends Controller
{
    public function index()
    {
        $stores = Store::paginate(12);
        $departments = Department::all();
        return view('front.store.index', compact('stores', 'departments'));
    }
    public function show($slug)
    {
        $store = Store::where('slug', '=', $slug)->with('products')->first();
        // dd($store);

        return view('front.store.show', compact('store'));
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
        $role = Role::where('name', 'store-manager')->first();

        $validated = $request->validate([
            'admin.name'         => 'required|string|max:255',
            'admin.username'     => 'required|string|max:255|unique:admins,username',
            'admin.email'        => 'required|email|unique:admins,email',
            'admin.phone_number' => 'required|string|max:20',
            'admin.password'     => 'required|string|min:6',
            'store.name'         => 'required|string|max:255',
            'store.slug'         => 'required|string|max:255|unique:stores,slug',
            'store.department_id' => 'required|exists:departments,id',
            'store.description'  => 'nullable|string',
            'store.logo_image'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'store.cover_image'  => 'nullable|image|mimes:jpg,jpeg,png|max:4096',
        ]);

        DB::beginTransaction();
        try {
            // تجهيز الصور (كما هو)
            $logoPath = null;
            if ($request->hasFile('store.logo_image')) {
                $logoPath = $request->file('store.logo_image')->store('stores/logos', 'public');
            }

            $coverPath = null;
            if ($request->hasFile('store.cover_image')) {
                $coverPath = $request->file('store.cover_image')->store('stores/covers', 'public');
            }

            // إنشاء المتجر (كما هو)
            $store = Store::create([
                'name'          => $request->store['name'],
                'slug'          => Str::slug($request->store['slug']),
                'department_id' => $request->store['department_id'],
                'description'   => $request->store['description'] ?? null,
                'logo_image'    => $logoPath,
                'cover_image'   => $coverPath,
                'status'        => 'active',
                'stripe_status' => 'pending', // جديد
            ]);

            // إنشاء الأدمن (كما هو)
            $admin = Admin::create([
                'name'        => $request->admin['name'],
                'username'    => $request->admin['username'],
                'email'       => $request->admin['email'],
                'phone_number' => $request->admin['phone_number'],
                'password'    => Hash::make($request->admin['password']),
                'super_admin' => false,
                'status'      => 'active',
                'store_id'    => $store->id,
            ]);

            $admin->roles()->attach($role->id);

            // *** الجزء الجديد: ربط مع Stripe Connect ***
            $stripe = new StripeClient(config('services.stripe.secret_key'));

            // إنشاء حساب Express متصل (مرر بيانات الأدمن لتسهيل)
            $account = $stripe->accounts->create([
                'type' => 'express',
                'country' => 'AE', // غير إلى دولة التاجر (يمكن جمعها من النموذج إذا أردت)
                'email' => $admin->email,
                'capabilities' => [
                    // 'card_payments' => ['requested' => true],
                    'transfers' => ['requested' => true],
                ],
                'business_type' => 'company', // أو 'company' إذا كان متجرًا تجاريًا

            ]);

            // حفظ ID الحساب في المتجر
            $store->update(['stripe_account_id' => $account->id]);

            // إنشاء رابط Onboarding
            $accountLink = $stripe->accountLinks->create([
                'account' => $account->id,
                'refresh_url' => route('dashboard.stripe.refresh', $store->id), // لإعادة المحاولة إذا فشل
                'return_url' => route('dashboard.stripe.return', $store->id),   // بعد الإكمال
                'type' => 'account_onboarding',
            ]);

            DB::commit();

            Auth::guard('admin')->login($admin);

            // توجيه إلى صفحة Onboarding في Stripe
            return redirect($accountLink->url);
        } catch (\Exception $e) {
            DB::rollback();

            if ($logoPath) {
                Storage::disk('public')->delete($logoPath);
            }
            if ($coverPath) {
                Storage::disk('public')->delete($coverPath);
            }

            return redirect()->back()->with('info', 'خطأ أثناء الإنشاء: ' . $e->getMessage());
        }
    }


}
