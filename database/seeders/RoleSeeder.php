<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            // User management
            'manage-users',
            'manage-settings',

            // Tenant management
            'manage-tenants',
            'view-tenants',

            // Unit management
            'manage-units',
            'view-units',

            // Lease management
            'manage-leases',
            'view-leases',

            // Meter readings
            'manage-meter-readings',
            'view-meter-readings',

            // Bills
            'manage-bills',
            'view-bills',
            'delete-bills',

            // Payments
            'manage-payments',
            'view-payments',

            // Maintenance
            'manage-maintenance',
            'view-maintenance',

            // Reports
            'view-reports',

            // Dashboard
            'view-dashboard',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Create Admin role with all permissions
        $adminRole = Role::create(['name' => 'admin']);
        $adminRole->givePermissionTo(Permission::all());

        // Create Caretaker role with limited permissions
        $caretakerRole = Role::create(['name' => 'caretaker']);
        $caretakerRole->givePermissionTo([
            'manage-tenants', 'view-tenants',
            'manage-units', 'view-units',
            'manage-leases', 'view-leases',
            'manage-meter-readings', 'view-meter-readings',
            'manage-bills', 'view-bills',
            'manage-payments', 'view-payments',
            'manage-maintenance', 'view-maintenance',
            'view-reports',
            'view-dashboard',
        ]);
    }
}
