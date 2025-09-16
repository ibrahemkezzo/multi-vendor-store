<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $admin = Auth::guard('admin')->user(); // جلب الأدمن المسجل
        $store = $admin->hasRole('store-manager') ? $admin->store : null; // جلب المتجر إذا كان لديه دور store-manager
        $departments = Department::pluck('name', 'id'); // جلب الأقسام

        return view('dashboard.profile.new-edit', compact('admin', 'store', 'departments'));
    }

    public function updateAdmin(Request $request)
    {
        // dd($request->all());
        $admin = Auth::guard('admin')->user();

        // التحقق من صحة بيانات الأدمن
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
            'username' => ['required', 'string', 'max:255', 'unique:admins,username,' . $admin->id],
            'phone_number' => ['required', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'current_password' => ['required_with:password', 'current_password:admin'],
        ]);

        // تحديث بيانات الأدمن
        $admin->fill([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'phone_number' => $validated['phone_number'],
        ]);


        $admin->save();

        return redirect()->route('dashboard.profile.edit')->with('success', 'Profile updated successfully.');
    }


    public function updatePassword(Request $request)
    {
        $admin = Auth::guard('admin')->user();

        // التحقق من صحة بيانات كلمة المرور
        $validated = $request->validate([
            'current_password' => ['required', 'current_password:admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // تحديث كلمة المرور
        $admin->password = Hash::make($validated['password']);
        $admin->save();

        return redirect()->route('dashboard.profile.edit')->with('success', 'Password updated successfully.');
    }

    public function updateStore(Request $request, Store $store)
    {
        $admin = Auth::guard('admin')->user();

        // التأكد من أن الأدمن لديه دور store-manager ويملك المتجر
        if (!$admin->hasRole('store-manager') || ($store->id && $admin->store_id !== $store->id)) {
            return redirect()->route('dashboard.profile.edit')->with('info', 'Unauthorized to update store information.');
        }

        // التحقق من صحة بيانات المتجر
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:stores,slug,' . ($store->id ?? 0)],
            // 'phone' => ['required', 'string', 'max:20'],
            // 'email' => ['required', 'email', 'max:255'],
            // 'address' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'department_id' => ['required', 'exists:departments,id'],
            'logo' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
            'cover' => ['nullable', 'image', 'mimes:jpg,png,jpeg', 'max:2048'],
        ]);

        // التعامل مع تحميل الصور
        if ($request->hasFile('logo')) {
            // حذف الشعار القديم إذا كان موجودًا
            if ($store->logo_image) {
                Storage::disk('public')->delete($store->logo_image);
            }
            $validated['logo_image'] = $request->file('logo')->store('logos', 'public');
        }

        if ($request->hasFile('cover')) {
            // حذف الغلاف القديم إذا كان موجودًا
            if ($store->cover_image) {
                Storage::disk('public')->delete($store->cover_image);
            }
            $validated['cover_image'] = $request->file('cover')->store('covers', 'public');
        }

        // تحديث أو إنشاء المتجر
        if ($store->exists) {
            $store->update($validated);
        } else {
            $validated['admin_id'] = $admin->id; // ربط المتجر بالأدمن
            $store = Store::create($validated);
            $admin->update(['store_id' => $store->id]); // تحديث store_id للأدمن
        }

        return redirect()->route('dashboard.profile.edit')->with('success', 'Store information updated successfully.');
    }
}
