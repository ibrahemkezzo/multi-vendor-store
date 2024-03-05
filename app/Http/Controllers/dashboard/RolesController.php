<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RolesController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Role::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $roles = Role::paginate();
        return view('dashboard.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.roles.create' , ['role'=> new Role(),'abilities'=>'']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','max:255'],
            'abilities'=>['required','array']
        ]);
        // dd($request->abilities);
        $role = Role::CreateWithAbilities($request);
        return redirect()->route('dashboard.roles.index')->with('success','role create success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $abilities = $role->abilities()->pluck('type','ability')->toarray();
        return view('dashboard.roles.show',compact('role','abilities'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $abilities = $role->abilities()->pluck('type','ability')->toArray();

        return view('dashboard.roles.edit',compact('role','abilities'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name'=>['required','string','max:255'],
            'abilities'=>['required','array']
        ]);

        $role->UpdateWithAbilities($request);
         return redirect()->route('dashboard.roles.show',$role->id)->with('success','role updated success');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::destroy($id);
        return redirect()->route('dashboard.roles.index');
    }
}
