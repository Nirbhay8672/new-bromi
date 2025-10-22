<?php

namespace App\Http\Controllers;

use App\Traits\HasPermissionChecks;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    use HasPermissionChecks;

    public function __construct()
    {
        // Middleware is handled by route groups
    }

    /**
     * Display a listing of roles
     */
    public function index(): Response|RedirectResponse
    {
        if ($redirect = $this->requirePermission('manage-roles')) {
            return $redirect;
        }

        $roles = Role::with(['permissions', 'users'])
            ->withCount('users')
            ->get();

        $permissions = Permission::all();

        return Inertia::render('Admin/Roles', [
            'roles' => $roles,
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created role
     */
    public function store(Request $request): RedirectResponse
    {
        // Temporarily comment out permission check for debugging
        // if ($redirect = $this->requirePermission('create-roles')) {
        //     return $redirect;
        // }

        \Log::info('Role creation request:', [
            'name' => $request->name,
            'permissions' => $request->permissions,
            'all_data' => $request->all()
        ]);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:roles,name'
            ],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        \Log::info('Validation passed, creating role...');

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web'
        ]);

        \Log::info('Role created:', ['role' => $role]);

        // Always sync permissions, even if empty array
        $permissions = [];
        if ($request->has('permissions') && is_array($request->permissions)) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            \Log::info('Found permissions to sync:', ['permissions' => $permissions->pluck('name')]);
        }
        
        $role->syncPermissions($permissions);
        \Log::info('Permissions synced successfully');

        \Log::info('Role creation completed successfully');

        return redirect()->back()->with('success', 'Role created successfully.');
    }

    /**
     * Update the specified role
     */
    public function update(Request $request, Role $role): RedirectResponse
    {
        // Temporarily comment out permission check for debugging
        // if ($redirect = $this->requirePermission('update-roles')) {
        //     return $redirect;
        // }

        \Log::info('Role update request:', [
            'role_id' => $role->id,
            'role_name' => $role->name,
            'request_name' => $request->name,
            'permissions' => $request->permissions,
            'all_data' => $request->all()
        ]);

        // Prevent editing super-admin role
        if ($role->name === 'super-admin' && (!auth()->check() || !auth()->user()?->hasRole('super-admin'))) {
            return redirect()->back()->with('error', 'You cannot edit the super-admin role.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('roles', 'name')->ignore($role->id)
            ],
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        \Log::info('Validation passed, updating role...');

        $role->update([
            'name' => $request->name
        ]);

        \Log::info('Role name updated:', ['role' => $role]);

        // Always sync permissions, even if empty array
        $permissions = [];
        if ($request->has('permissions') && is_array($request->permissions)) {
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            \Log::info('Found permissions to sync:', ['permissions' => $permissions->pluck('name')]);
        }
        
        $role->syncPermissions($permissions);
        \Log::info('Permissions synced successfully');

        \Log::info('Role update completed successfully');

        return redirect()->back()->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role
     */
    public function destroy(Role $role): RedirectResponse
    {
        if ($redirect = $this->requirePermission('delete-roles')) {
            return $redirect;
        }

        // Prevent deleting super-admin role
        if ($role->name === 'super-admin') {
            return redirect()->back()->with('error', 'Cannot delete the super-admin role.');
        }

        // Check if role has users
        if ($role->users()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete role that is assigned to users.');
        }

        $role->delete();

        return redirect()->back()->with('success', 'Role deleted successfully.');
    }

    /**
     * Sync permissions for a role
     */
    public function syncPermissions(Request $request, Role $role): RedirectResponse
    {
        if ($redirect = $this->requirePermission('update-roles')) {
            return $redirect;
        }

        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id'
        ]);

        $permissions = Permission::whereIn('id', $request->permissions)->get();
        $role->syncPermissions($permissions);

        return redirect()->back()->with('success', 'Role permissions updated successfully.');
    }

    /**
     * Get role with permissions
     */
    public function show(Role $role): Response|RedirectResponse
    {
        if ($redirect = $this->requirePermission('read-roles')) {
            return $redirect;
        }

        $role->load(['permissions', 'users']);

        return Inertia::render('Admin/RoleDetails', [
            'role' => $role
        ]);
    }
}
