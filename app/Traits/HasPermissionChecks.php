<?php

namespace App\Traits;

use Illuminate\Http\RedirectResponse;

trait HasPermissionChecks
{
    /**
     * Check if the current user has a specific permission
     */
    protected function hasPermission(string $permission): bool
    {
        return auth()->user()?->can($permission) ?? false;
    }

    /**
     * Check if the current user has a specific role
     */
    protected function hasRole(string $role): bool
    {
        return auth()->user()?->hasRole($role) ?? false;
    }

    /**
     * Check if the current user has any of the given roles
     */
    protected function hasAnyRole(array $roles): bool
    {
        return auth()->user()?->hasAnyRole($roles) ?? false;
    }

    /**
     * Check if the current user has all of the given roles
     */
    protected function hasAllRoles(array $roles): bool
    {
        return auth()->user()?->hasAllRoles($roles) ?? false;
    }

    /**
     * Check if the current user has any of the given permissions
     */
    protected function hasAnyPermission(array $permissions): bool
    {
        return auth()->user()?->hasAnyPermission($permissions) ?? false;
    }

    /**
     * Check if the current user has all of the given permissions
     */
    protected function hasAllPermissions(array $permissions): bool
    {
        return auth()->user()?->hasAllPermissions($permissions) ?? false;
    }

    /**
     * Redirect back with error if user doesn't have permission
     */
    protected function requirePermission(string $permission): ?RedirectResponse
    {
        if (!$this->hasPermission($permission)) {
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        return null;
    }

    /**
     * Redirect back with error if user doesn't have role
     */
    protected function requireRole(string $role): ?RedirectResponse
    {
        if (!$this->hasRole($role)) {
            return redirect()->back()->with('error', 'You do not have the required role to perform this action.');
        }

        return null;
    }
}
