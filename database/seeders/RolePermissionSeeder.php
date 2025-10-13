<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'view-dashboard',
            'manage-users',
            'manage-roles',
            'manage-permissions',
            'view-settings',
            'edit-settings',
            'view-reports',
            'manage-content',
            'delete-content',
            'publish-content',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles and assign permissions
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo(Permission::all());

        $editorRole = Role::create(['name' => 'editor', 'guard_name' => 'web']);
        $editorRole->givePermissionTo([
            'view-dashboard',
            'manage-content',
            'publish-content',
            'view-reports',
        ]);

        $authorRole = Role::create(['name' => 'author', 'guard_name' => 'web']);
        $authorRole->givePermissionTo([
            'view-dashboard',
            'manage-content',
            'publish-content',
        ]);

        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);
        $userRole->givePermissionTo([
            'view-dashboard',
        ]);
    }
}
