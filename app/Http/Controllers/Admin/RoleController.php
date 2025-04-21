<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch all roles and permissions
        $roles = Role::all();
        $permissions = Permission::all()->groupBy('group_name');

        // Return the view with roles and permissions
        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Fetch all permissions
        $permissions = Permission::all()->groupBy('group_name');

        // Return the view with permissions
        return view('admin.roles.create', 
        [
            'permissions' => $permissions,
            'role' => null
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name',
            'permissions' => 'array',
        ]);

        // Create a new role
        $role = Role::create(['name' => $request->name]);

        // Assign permissions to the role
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        // Redirect to the roles index with success message
        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Fetch the role by ID
        $role = Role::findOrFail($id);

        // Fetch all permissions
        $permissions = Permission::all()->groupBy('group_name');

        // Return the view with role and permissions
        return view('admin.roles.create', compact('role', 'permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $id,
            'permissions' => 'array',
        ]);

        // Find the role
        $role = Role::findOrFail($id);

        // Update the role name
        $role->name = $request->name;
        $role->save();

        // Sync permissions
        if ($request->permissions) {
            $role->syncPermissions($request->permissions);
        }

        // Redirect to the roles index with success message
        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the role
        $role = Role::findOrFail($id);

        // Delete the role
        $role->delete();

        // Redirect to the roles index with success message
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }
}
