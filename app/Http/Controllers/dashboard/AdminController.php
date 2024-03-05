<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Admin::class);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins=Admin::paginate();
        return view('dashboard.admins.index',compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admins.create',[
            'roles'=>Role::all(),
            'admin'=> new Admin()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->post('roles'));
        $request->validate([
            'name'=>['required','string','max:255'],
            'roles'=>['required','array']
        ]);
        $data_admin = $request->except('password');
        $pass = Hash::make($request->post('password'));
        $data_admin['password']= $pass;
        // dd($data_admin);
        $admin= Admin::create($data_admin);
        $admin->roles()->attach($request->post('roles'));
        return redirect()->route('dashboard.admins.index')->with('success','create admin success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        $roles = $admin->roles()->pluck('name');

        return view('dashboard.admins.show',[
            'admin'=>$admin,
            'roles'=>$roles,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        $roles = Role::all();
        $admin_role = $admin->roles()->pluck('id')->toArray();
        return view('dashboard.admins.edit',compact('admin','roles','admin_role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        // dd($request->post('roles'));
        $request->validate([
            'name'=>['required','string','max:255'],
            'roles'=>['required','array']
        ]);

        $admin->update($request->all());
        $admin->roles()->sync($request->post('roles'));
        return redirect()->route('dashboard.admins.index')->with('success','update admin success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Admin::destroy($id);
        return redirect()->route('dashboard.admins.index')->with('info','deleted admin success');

    }
}
