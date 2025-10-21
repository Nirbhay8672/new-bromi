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
