<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();
        return view('admin.roles.index', ['roles' => $roles]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all();
        return view('admin.roles.create', ['permissions' => $permissions]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required'],
            'description'=> ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array']
        ]);

        try {
            $role = Role::create([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if($request->has('permissions')) {
                $role->givePermissionTo($request->permissions);
            }

            return redirect()->route('roles.index')->with('success', "Role {$role} created successfully.");
        } catch (\Exception $e) {
            \Log::error("Error creating new role: " . $e->getMessage());
            return back()->withErrors('errors', "Role Creation Failed");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load('permissions');
        return view('admin.roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        return view('admin.roles.edit', ['role' => $role]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'permissions' => ['nullable', 'array']
        ]);

        try {
            $role->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            if($request->has('permissions')) {
                $role->sync($request->permissions ?? []);
            }

            return redirect()->route('roles.show')->with("success", "Role updated successfully");
        } catch (\Exception $e) {
            \Log::error("Error updating the role: " . $e->getMessage());
            return back()->withErrors('errors', "Error updating the role");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if($role->users()->count() > 0) {
            return back()->with('errors', "Cannot delete a role has assigned roles");
        }

        $role->delete();
        return redirect()->route('admin.roles.index')->with('success', "Role deleted successfully");
    }
}
