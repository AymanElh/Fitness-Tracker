<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::withCount('users')->with('permissions')->get();
        $totalUsers = $roles->sum('users_count');
        $totalPermissions = Permission::count();

        return view('admin.roles.index', [
            'roles' => $roles,
            'totalRoles' => $roles->count(),
            'totalUsers' => $totalUsers,
            'totalPermissions' => $totalPermissions
        ]);
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
            'name' => ['required', 'string', 'max:255', 'unique:roles,name'],
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

            return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' created successfully.");
        } catch (\Exception $e) {
            Log::error("Error creating new role: " . $e->getMessage());
            return back()->withErrors(['error' => "Role creation failed: {$e->getMessage()}"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->load(['permissions', 'users']);
        return view('admin.roles.show', ['role' => $role]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $role->load('permissions');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $role->permissions->pluck('id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:roles,name,'.$role->id],
            'description' => ['nullable', 'string', 'max:1000'],
            'permissions' => ['nullable', 'array']
        ]);

        try {
            $role->update([
                'name' => $request->name,
                'description' => $request->description
            ]);

            // Sync permissions
            $role->givePermissionTo($request->permissions ?? []);

            return redirect()->route('admin.roles.index')->with('success', "Role '{$role->name}' updated successfully");
        } catch (\Exception $e) {
            Log::error("Error updating role: " . $e->getMessage());
            return back()->withErrors(['error' => "Error updating role: {$e->getMessage()}"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        try {
            if($role->users()->count() > 0) {
                return back()->with('error', "Cannot delete a role that has assigned users");
            }

            $roleName = $role->name;
            $role->delete();
            return redirect()->route('admin.roles.index')->with('success', "Role '{$roleName}' deleted successfully");
        } catch (\Exception $e) {
            Log::error("Error deleting role: " . $e->getMessage());
            return back()->withErrors(['error' => "Error deleting role: {$e->getMessage()}"]);
        }
    }
}
