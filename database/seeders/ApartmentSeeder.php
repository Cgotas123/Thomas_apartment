<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Create Staff Users (Slide 4 roles)
        $owner = \App\Models\User::create([
            'name' => 'Mrs. Lovely Thomas',
            'email' => 'owner@thomasapartment.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'John Caretaker',
            'email' => 'caretaker@thomasapartment.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Mike Technician',
            'email' => 'tech@thomasapartment.com',
            'password' => bcrypt('password'),
        ]);

        \App\Models\User::create([
            'name' => 'Sarah Bill Manager',
            'email' => 'billing@thomasapartment.com',
            'password' => bcrypt('password'),
        ]);

        // 2. Create 21 Units across 3 Floors (Slide 2)
        for ($floor = 1; $floor <= 3; $floor++) {
            for ($unit = 1; $unit <= 7; $unit++) {
                \App\Models\Unit::create([
                    'unit_number' => $floor . '0' . $unit,
                    'floor' => $floor,
                    'type' => ($unit % 2 == 0) ? 'AC' : 'Non-AC',
                    'base_rent' => ($unit % 2 == 0) ? 5000.00 : 3500.00,
                    'status' => 'Vacant',
                ]);
            }
        }

        // 3. Create Sample Tenants
        $tenant1 = \App\Models\Tenant::create([
            'full_name' => 'Alice Student',
            'email' => 'alice@test.com',
            'category' => 'Student',
        ]);

        // 4. Create a Lease for Tenant 1
        $unit1 = \App\Models\Unit::first();
        $unit1->update(['status' => 'Occupied']);

        \App\Models\Lease::create([
            'unit_id' => $unit1->id,
            'tenant_id' => $tenant1->id,
            'start_date' => now()->startOfMonth(),
            'monthly_rent' => $unit1->base_rent,
            'security_deposit' => $unit1->base_rent * 2,
        ]);
    }
}
