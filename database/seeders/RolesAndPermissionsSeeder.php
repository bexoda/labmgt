<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        //ASSAYLAB STAFF MODEL
        $staffPermissionCreate = Permission::create(['name' => 'create: staff']);
        $staffPermissionRead = Permission::create(['name' => 'read: staff']);
        $staffPermissionUpdate = Permission::create(['name' => 'update: staff']);
        $staffPermissionDelete = Permission::create(['name' => 'delete: staff']);

        //ROLE MODEL
        $rolePermissionCreate = Permission::create(['name' => 'create: role']);
        $rolePermissionRead = Permission::create(['name' => 'read: role']);
        $rolePermissionUpdate = Permission::create(['name' => 'update: role']);
        $rolePermissionDelete = Permission::create(['name' => 'delete: role']);

        //PERMISSION MODEL
        $permissionCreate = Permission::create(['name' => 'create: permission']);
        $permissionRead = Permission::create(['name' => 'read: permission']);
        $permissionUpdate = Permission::create(['name' => 'update: permission']);
        $permissionDelete = Permission::create(['name' => 'delete: permission']);

        //ADMINS
        $adminPermissionRead = Permission::create(['name' => 'read: admin']);
        $adminPermissionUpdate = Permission::create(['name' => 'update: admin']);

        //CREATE ROLES
        $adminRole = Role::create(['name' => 'Admin'])->syncPermissions([
            $staffPermissionCreate,
            $staffPermissionRead,
            $staffPermissionUpdate,
            $staffPermissionDelete,
            $rolePermissionCreate,
            $rolePermissionRead,
            $rolePermissionUpdate,
            $rolePermissionDelete,
            $permissionCreate,
            $permissionRead,
            $permissionUpdate,
            $permissionDelete,
            $adminPermissionRead,
            $adminPermissionUpdate,
        ]);

        $staffRole = Role::create(['name' => 'AssayLab Staff'])->syncPermissions([
            // $staffPermissionCreate,
            $staffPermissionRead,
            // $staffPermissionUpdate,
            // $staffPermissionDelete,
            // $rolePermissionCreate,
            $rolePermissionRead,
            // $rolePermissionUpdate,
            // $rolePermissionDelete,
            // $permissionCreate,
            $permissionRead,
            // $permissionUpdate,
            // $permissionDelete,
            // $adminPermissionRead,
            // $adminPermissionUpdate,

        ]);

        $deliveryStaffRole = Role::create(['name' => 'AssayLab Delivery Staff'])->syncPermissions([
            $staffPermissionRead,
            $rolePermissionRead,
            $permissionRead,

        ]);

        User::create([
            'name' => 'AssayLab Admin',
            // 'is_admin' => true,
            'initials' => 'AA',
            'email' => 'admin@labmgt.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(60),
        ])->assignRole($adminRole);

        User::create([
            'name' => 'AssayLab Staff',
            // 'is_admin' => true,
            'initials' => 'AS',
            'email' => 'staff@labmgt.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password1'),
            'remember_token' => Str::random(60),
        ])->assignRole($staffRole);

        User::create([
            'name' => 'AssayLab Delivery Staff',
            // 'is_admin' => true,
            'initials' => 'ADS',
            'email' => 'delivery@labmgt.com',
            'email_verified_at' => now(),
            'password' => Hash::make('password2'),
            'remember_token' => Str::random(60),
        ])->assignRole($deliveryStaffRole);
    }
}
