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
            'revoke-roles',
            'sync-permissions',
            
            // System permissions
            'manage-system',
            'view-logs',
            'manage-backups',
            'system-maintenance',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create roles
        $superAdminRole = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $adminRole = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $userRole = Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Assign all permissions to super-admin
        $superAdminRole->givePermissionTo(Permission::all());

        // Assign specific permissions to admin
        $adminPermissions = [
            'view-dashboard',
            'read users',
            'update users',
            'manage-users',
            'read roles',
            'read permissions',
            'view-profile',
            'update-profile',
            'change-password',
            'view-settings',
            'access-admin-panel',
            'view-admin-dashboard',
        ];
        $adminRole->givePermissionTo($adminPermissions);

        // Assign basic permissions to user
        $userPermissions = [
            'view-dashboard',
            'view-profile',
            'update-profile',
            'change-password',
            'view-settings',
        ];
        $userRole->givePermissionTo($userPermissions);

        // Create a super admin user if it doesn't exist
        $superAdmin = User::firstOrCreate(
            ['email' => 'superadmin@gmail.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign super-admin role to the user
        if (!$superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole('super-admin');
        }

        // Create an admin user if it doesn't exist
        $admin = User::firstOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign admin role to the user
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }

        // Create a regular user if it doesn't exist
        $user = User::firstOrCreate(
            ['email' => 'user@example.com'],
            [
                'name' => 'Regular User',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Assign user role to the user
        if (!$user->hasRole('user')) {
            $user->assignRole('user');
        }
    }
}