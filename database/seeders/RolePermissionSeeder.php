<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
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
            // Dashboard permissions
            'view-dashboard',
            
            // User CRUD permissions
            'create users',
            'read users',
            'update users',
            'delete users',
            'manage-users',
            
            // Role CRUD permissions
            'create roles',
            'read roles',
            'update roles',
            'delete roles',
            'manage-roles',
            
            // Permission CRUD permissions
            'create permissions',
            'read permissions',
            'update permissions',
            'delete permissions',
            'manage-permissions',
            
            // Profile/Settings permissions
            'view-profile',
            'update-profile',
            'delete-profile',
            'manage-profile',
            
            // Password permissions
            'change-password',
            'update-password',
            
            // Two-Factor Authentication permissions
            'manage-two-factor',
            'enable-two-factor',
            'disable-two-factor',
            
            // Appearance permissions
            'manage-appearance',
            'update-appearance',
            
            // Settings permissions
            'view-settings',
            'manage-settings',
            
            // Admin permissions
            'access-admin-panel',
            'view-admin-dashboard',
            
            // Role assignment permissions
            'assign-roles',
            'remove-roles',
            'assign-permissions',
            'revoke-permissions',
            
            // User management permissions
            'impersonate-users',
            'suspend-users',
            'activate-users',
            
            // System permissions
            'view-system-logs',
            'manage-system-settings',
            'backup-data',
            'restore-data',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin']);
        $adminRole = Role::create(['name' => 'admin']);

        // Assign all permissions to super-admin
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign limited permissions to admin
        $adminRole->givePermissionTo([
            'view-dashboard',
            'read users',
            'read roles',
            'read permissions',
            'manage-users', // Can access user management page
        ]);

        // Create users
        $superAdmin = User::create([
            'name' => 'Super Administrator',
            'email' => 'superadmin@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
        ]);

        // Assign roles to users
        $superAdmin->assignRole('super-admin');
        $admin->assignRole('admin');
    }
}
