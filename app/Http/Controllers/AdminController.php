<?php

namespace App\Http\Controllers;

use App\Traits\HasPermissionChecks;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    use HasPermissionChecks;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display the admin dashboard
     */
    public function dashboard(): Response
    {
        // Check if user has permission to view dashboard
        if ($redirect = $this->requirePermission('view-dashboard')) {
            return $redirect;
        }

        return Inertia::render('Admin/Dashboard');
    }

    /**
     * Display roles management page
     */
    public function roles(): Response
    {
        // Check if user has permission to manage roles
        if ($redirect = $this->requirePermission('manage-roles')) {
            return $redirect;
        }

        $roles = Role::with('permissions')->get();

        return Inertia::render('Admin/Roles', [
            'roles' => $roles
        ]);
    }

    /**
     * Display permissions management page
     */
    public function permissions(): Response
    {
        // Check if user has permission to manage permissions
        if ($redirect = $this->requirePermission('manage-permissions')) {
            return $redirect;
        }

        $permissions = Permission::all();

        return Inertia::render('Admin/Permissions', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Display users management page
     */
    public function users(): Response
    {
        // Check if user has permission to manage users
        if ($redirect = $this->requirePermission('manage-users')) {
            return $redirect;
        }

        $users = \App\Models\User::with('roles')->get();

        return Inertia::render('Admin/Users', [
            'users' => $users
        ]);
    }

    /**
     * Assign role to user
     */
    public function assignRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->assignRole($request->role);

        return redirect()->back()->with('success', 'Role assigned successfully.');
    }

    /**
     * Remove role from user
     */
    public function removeRole(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'role' => 'required|string|exists:roles,name'
        ]);

        $user = \App\Models\User::findOrFail($request->user_id);
        $user->removeRole($request->role);

        return redirect()->back()->with('success', 'Role removed successfully.');
    }

    /**
     * Give permission to role
     */
    public function givePermissionToRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|string|exists:permissions,name'
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->givePermissionTo($request->permission);

        return redirect()->back()->with('success', 'Permission granted to role successfully.');
    }

    /**
     * Revoke permission from role
     */
    public function revokePermissionFromRole(Request $request)
    {
        $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission' => 'required|string|exists:permissions,name'
        ]);

        $role = Role::findOrFail($request->role_id);
        $role->revokePermissionTo($request->permission);

        return redirect()->back()->with('success', 'Permission revoked from role successfully.');
    }
}
