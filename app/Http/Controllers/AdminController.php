<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Traits\HasPermissionChecks;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    use HasPermissionChecks;

    public function __construct()
    {
        // Middleware is handled by route groups
    }

    /**
     * Display the admin dashboard
     */
    public function dashboard(): Response|RedirectResponse
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
    public function roles(): Response|RedirectResponse
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
    public function permissions(): Response|RedirectResponse
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
    public function users(): Response|RedirectResponse
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

    /**
     * Store or update user (single method for both add and update)
     */
    public function storeUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email,' . ($request->user_id ?? 'NULL'),
                'password' => $request->user_id ? 'nullable|string|min:8' : 'required|string|min:8',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $validator->errors()
                ], 422);
            }

            $userData = [
                'name' => $request->name,
                'email' => $request->email,
            ];

            // Only hash password if provided
            if ($request->password) {
                $userData['password'] = Hash::make($request->password);
            }

            if ($request->user_id) {
                // Update existing user
                $user = User::findOrFail($request->user_id);
                $user->update($userData);
                $message = 'User updated successfully';
            } else {
                // Create new user
                $user = User::create($userData);
                $message = 'User created successfully';
            }

            // Always assign admin role
            $user->assignRole('admin');

            return response()->json([
                'success' => true,
                'message' => $message,
                'user' => $user->load('roles')
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Update user (alias for storeUser for consistency)
     */
    public function updateUser(Request $request, User $user)
    {
        $request->merge(['user_id' => $user->id]);
        return $this->storeUser($request);
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        try {
            // Prevent deleting super admin
            if ($user->hasRole('super-admin')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete super admin user'
                ], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ], 500);
        }
    }
}
