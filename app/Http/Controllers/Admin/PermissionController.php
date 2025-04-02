<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mockery\Exception;

class PermissionController extends Controller
{
    public function index()
    {
        try {
            $permissions = Permission::withCount('roles')->get();
            $totalPermissions = $permissions->count();
            $modules = $permissions->pluck('module')->filter()->unique()->values();
            $totalAssignments = $permissions->sum('roles_count');
            return view('admin.permissions.index', [
                'permissions' => $permissions,
                'totalPermissions' => $totalPermissions,
                'moduleCount' => $modules->count(),
                'totalAssignments' => $totalAssignments,
                'customPermissions' => 33,
                'currentDateTime' => now()->format('Y-m-d H:m:s'),
                'currentUser' => "ayman"
            ]);
        } catch(\Exception $e) {
            \Log::error("Error fetching permissions" . $e->getMessage());
            return back()->withErrors(['error' => "Error to get stats"]);
        }
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:permissions'],
            'description' => ['required', 'string', 'max:1000']
        ]);
//        dd($request->all());
        try {
            $slug = Str::slug($request->name);

            $permission = Permission::create([
                'name' => $request->name,
                'slug' => $slug,
                'module' => $request->module,
                'description' => $request->description
            ]);
            return redirect()->route('permissions.index')->with('success', "Permission {$permission->name} created successfully");
        } catch (Exception $e) {
            \Log::error("error creating permission: " . $e->getMessage());
            return back()->withInput()->withErrors(['error' => "Failed to create permission: {$e->getMessage()}"]);
        }
    }

    public function show(Permission $permission)
    {
        $permission->load('roles');
        return view('permissions.show', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', Rule::unique('permissions')->ignore($permission->id)],
            'description' => 'nullable|string|max:1000',
            'module' => 'required|string|max:255',
        ]);

        $slug = Str::slug($request->name);

        $permission->update([
            'name' => $request->name,
            'slug' => $slug, // Add the generated slug
            'module' => $request->module, // Add module field
            'description' => $request->description,
        ]);

        return redirect()->route('permissions.index')
            ->with('success', 'Permission updated successfully.');
    }

    public function destroy(Permission $permission)
    {
        // Check if this permission is assigned to any roles
        if ($permission->roles()->count() > 0) {
            return back()->with('error', 'Cannot delete a permission that is assigned to roles.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->with('success', 'Permission deleted successfully.');
    }
}
