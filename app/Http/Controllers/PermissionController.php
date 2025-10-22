<?php

namespace App\Http\Controllers;

use App\Traits\HasPermissionChecks;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    use HasPermissionChecks;

    public function __construct()
    {
        // Middleware is handled by route groups
    }

    /**
     * Display a listing of permissions
     */
    public function index(): Response|RedirectResponse
    {
        if ($redirect = $this->requirePermission('manage-permissions')) {
            return $redirect;
        }

        $permissions = Permission::with('roles')
            ->withCount('roles')
            ->get();

        return Inertia::render('Admin/Permissions', [
            'permissions' => $permissions
        ]);
    }

    /**
     * Store a newly created permission
     */
    public function store(Request $request): RedirectResponse
    {
        if ($redirect = $this->requirePermission('create-permissions')) {
            return $redirect;
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:permissions,name'
            ],
            'guard_name' => [
                'required',
                'string',
                'in:web,api'
            ]
        ]);

        Permission::create([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return redirect()->back()->with('success', 'Permission created successfully.');
    }

    /**
     * Update the specified permission
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        if ($redirect = $this->requirePermission('update-permissions')) {
            return $redirect;
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('permissions', 'name')->ignore($permission->id)
            ],
            'guard_name' => [
                'required',
                'string',
                'in:web,api'
            ]
        ]);

        $permission->update([
            'name' => $request->name,
            'guard_name' => $request->guard_name
        ]);

        return redirect()->back()->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        if ($redirect = $this->requirePermission('delete-permissions')) {
            return $redirect;
        }

        // Check if permission is assigned to roles
        if ($permission->roles()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot delete permission that is assigned to roles.');
        }

        $permission->delete();

        return redirect()->back()->with('success', 'Permission deleted successfully.');
    }
}
