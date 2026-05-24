<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create Permissions
        $permissions = [
            'manage tenants',
            'record meter readings',
            'manage maintenance requests',
            'view bills',
            'view payments',
            'manage user accounts',
            'delete billing records',
            'access system settings',
            'full system access'
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create Admin Role
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $adminRole->syncPermissions(Permission::all());

        // Create Caretaker Role
        $caretakerRole = Role::firstOrCreate(['name' => 'Caretaker', 'guard_name' => 'web']);
        $caretakerRole->syncPermissions([
            'manage tenants',
            'record meter readings',
            'manage maintenance requests',
            'view bills',
            'view payments'
        ]);

        // Assign Admin role to existing owner user
        $owner = User::where('email', 'owner@thomasapartment.com')->first();
        if ($owner) {
            $owner->assignRole($adminRole);
        }

        // Assign Caretaker role to existing caretaker user
        $caretakerUser = User::where('email', 'caretaker@thomasapartment.com')->first();
        if ($caretakerUser) {
            $caretakerUser->assignRole($caretakerRole);
        }
    }
}
