<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Lease;
use App\Models\MeterReading;
use App\Models\Bill;
use App\Models\Payment;
use App\Models\MaintenanceRequest;
use App\Models\ActivityLog;
use Carbon\Carbon;

class SampleDataSeeder extends Seeder
{
    public function run()
    {
        // Create 20 apartment units (5 floors x 4 units)
        $units = [];
        $types = ['studio', '1br', '2br', '3br'];
        $rents = ['studio' => 5000, '1br' => 8000, '2br' => 12000, '3br' => 15000];

        for ($floor = 1; $floor <= 5; $floor++) {
            for ($unit = 1; $unit <= 4; $unit++) {
                $type = $types[$unit - 1];
                $units[] = Unit::create([
                    'unit_number' => $floor . '0' . $unit,
                    'floor' => $floor,
                    'type' => $type,
                    'monthly_rent' => $rents[$type],
                    'status' => 'vacant',
                    'description' => ucfirst(str_replace(['1br','2br','3br'], ['1 Bedroom','2 Bedrooms','3 Bedrooms'], $type)) . ' unit on floor ' . $floor,
                ]);
            }
        }

        // Create 15 tenants
        $tenantData = [
            ['first_name' => 'Juan', 'last_name' => 'Dela Cruz', 'email' => 'juan@email.com', 'phone' => '09171234567'],
            ['first_name' => 'Maria', 'last_name' => 'Santos', 'email' => 'maria@email.com', 'phone' => '09181234567'],
            ['first_name' => 'Pedro', 'last_name' => 'Reyes', 'email' => 'pedro@email.com', 'phone' => '09191234567'],
            ['first_name' => 'Ana', 'last_name' => 'Garcia', 'email' => 'ana@email.com', 'phone' => '09201234567'],
            ['first_name' => 'Jose', 'last_name' => 'Rodriguez', 'email' => 'jose@email.com', 'phone' => '09211234567'],
            ['first_name' => 'Carmen', 'last_name' => 'Lopez', 'email' => 'carmen@email.com', 'phone' => '09221234567'],
            ['first_name' => 'Roberto', 'last_name' => 'Fernandez', 'email' => 'roberto@email.com', 'phone' => '09231234567'],
            ['first_name' => 'Rosa', 'last_name' => 'Martinez', 'email' => 'rosa@email.com', 'phone' => '09241234567'],
            ['first_name' => 'Carlos', 'last_name' => 'Gonzalez', 'email' => 'carlos@email.com', 'phone' => '09251234567'],
            ['first_name' => 'Elena', 'last_name' => 'Hernandez', 'email' => 'elena@email.com', 'phone' => '09261234567'],
            ['first_name' => 'Miguel', 'last_name' => 'Diaz', 'email' => 'miguel@email.com', 'phone' => '09271234567'],
            ['first_name' => 'Sofia', 'last_name' => 'Moreno', 'email' => 'sofia@email.com', 'phone' => '09281234567'],
            ['first_name' => 'Antonio', 'last_name' => 'Jimenez', 'email' => 'antonio@email.com', 'phone' => '09291234567'],
            ['first_name' => 'Isabel', 'last_name' => 'Ruiz', 'email' => 'isabel@email.com', 'phone' => '09301234567'],
            ['first_name' => 'Francisco', 'last_name' => 'Torres', 'email' => 'francisco@email.com', 'phone' => '09311234567'],
        ];

        $tenants = [];
        foreach ($tenantData as $data) {
            $data['emergency_contact'] = 'Emergency Contact';
            $data['emergency_contact_phone'] = '09001234567';
            $data['date_of_birth'] = Carbon::now()->subYears(rand(22, 55))->format('Y-m-d');
            $data['id_type'] = 'National ID';
            $data['id_number'] = 'ID-' . rand(100000, 999999);
            $data['address'] = 'Manila, Philippines';
            $tenants[] = Tenant::create($data);
        }

        // Create leases for 12 tenants (leaving 3 without active leases)
        $leases = [];
        for ($i = 0; $i < 12; $i++) {
            $unit = $units[$i];
            $tenant = $tenants[$i];
            $startDate = Carbon::now()->subMonths(rand(1, 12));

            $lease = Lease::create([
                'tenant_id' => $tenant->id,
                'unit_id' => $unit->id,
                'start_date' => $startDate,
                'end_date' => $startDate->copy()->addYear(),
                'monthly_rent' => $unit->monthly_rent,
                'deposit' => $unit->monthly_rent * 2,
                'status' => 'active',
                'notes' => 'Standard lease agreement',
            ]);
            $leases[] = $lease;

            // Update unit status
            $unit->update(['status' => 'occupied']);
        }

        // Set one unit to maintenance
        $units[15]->update(['status' => 'maintenance']);

        // Create meter readings for occupied units
        foreach ($leases as $lease) {
            for ($month = 2; $month >= 0; $month--) {
                $readingDate = Carbon::now()->subMonths($month);

                // Water reading
                $prevWater = rand(100, 500);
                $currWater = $prevWater + rand(5, 30);
                MeterReading::create([
                    'unit_id' => $lease->unit_id,
                    'type' => 'water',
                    'previous_reading' => $prevWater,
                    'current_reading' => $currWater,
                    'consumption' => $currWater - $prevWater,
                    'rate_per_unit' => 35.00,
                    'reading_date' => $readingDate,
                    'recorded_by' => 2, // caretaker
                ]);

                // Electricity reading
                $prevElec = rand(200, 800);
                $currElec = $prevElec + rand(50, 200);
                MeterReading::create([
                    'unit_id' => $lease->unit_id,
                    'type' => 'electricity',
                    'previous_reading' => $prevElec,
                    'current_reading' => $currElec,
                    'consumption' => $currElec - $prevElec,
                    'rate_per_unit' => 12.00,
                    'reading_date' => $readingDate,
                    'recorded_by' => 2,
                ]);
            }
        }

        // Create bills for each lease
        foreach ($leases as $lease) {
            for ($month = 2; $month >= 0; $month--) {
                $periodStart = Carbon::now()->subMonths($month)->startOfMonth();
                $periodEnd = $periodStart->copy()->endOfMonth();
                $waterAmount = rand(175, 1050);
                $electricityAmount = rand(600, 2400);

                $totalAmount = $lease->monthly_rent + $waterAmount + $electricityAmount;
                $status = $month >= 1 ? 'paid' : ($month == 0 ? (rand(0,1) ? 'unpaid' : 'paid') : 'unpaid');

                $bill = Bill::create([
                    'lease_id' => $lease->id,
                    'billing_period_start' => $periodStart,
                    'billing_period_end' => $periodEnd,
                    'rent_amount' => $lease->monthly_rent,
                    'water_amount' => $waterAmount,
                    'electricity_amount' => $electricityAmount,
                    'other_charges' => 0,
                    'total_amount' => $totalAmount,
                    'status' => $status,
                    'due_date' => $periodEnd->copy()->addDays(15),
                    'created_by' => 1,
                ]);

                // Create payment for paid bills
                if ($status === 'paid') {
                    Payment::create([
                        'bill_id' => $bill->id,
                        'amount' => $totalAmount,
                        'payment_method' => ['cash', 'bank_transfer', 'gcash', 'maya'][rand(0, 3)],
                        'reference_number' => 'PAY-' . rand(100000, 999999),
                        'payment_date' => $periodEnd->copy()->addDays(rand(1, 10)),
                        'received_by' => rand(1, 2),
                        'notes' => 'Monthly payment',
                    ]);
                }
            }
        }

        // Create maintenance requests
        $maintenanceData = [
            ['title' => 'Leaking Faucet', 'description' => 'Kitchen faucet is leaking constantly', 'priority' => 'medium', 'status' => 'completed'],
            ['title' => 'Broken Window Lock', 'description' => 'Bedroom window lock is broken', 'priority' => 'high', 'status' => 'in_progress'],
            ['title' => 'AC Not Cooling', 'description' => 'Air conditioner is not cooling properly', 'priority' => 'high', 'status' => 'pending'],
            ['title' => 'Clogged Drain', 'description' => 'Bathroom drain is clogged', 'priority' => 'medium', 'status' => 'pending'],
            ['title' => 'Light Fixture Replacement', 'description' => 'Living room light fixture needs replacement', 'priority' => 'low', 'status' => 'completed'],
            ['title' => 'Door Hinge Repair', 'description' => 'Main door hinge is loose', 'priority' => 'medium', 'status' => 'in_progress'],
            ['title' => 'Water Heater Issue', 'description' => 'Water heater not producing hot water', 'priority' => 'urgent', 'status' => 'pending'],
            ['title' => 'Paint Peeling', 'description' => 'Wall paint is peeling in the bathroom', 'priority' => 'low', 'status' => 'pending'],
        ];

        foreach ($maintenanceData as $index => $data) {
            MaintenanceRequest::create([
                'unit_id' => $units[$index]->id,
                'title' => $data['title'],
                'description' => $data['description'],
                'priority' => $data['priority'],
                'status' => $data['status'],
                'reported_by' => 2,
                'completed_at' => $data['status'] === 'completed' ? Carbon::now()->subDays(rand(1, 10)) : null,
                'completion_notes' => $data['status'] === 'completed' ? 'Issue resolved successfully' : null,
            ]);
        }

        // Create activity logs
        $activities = [
            ['action' => 'create', 'description' => 'New tenant Juan Dela Cruz was registered'],
            ['action' => 'create', 'description' => 'Lease created for Unit 101'],
            ['action' => 'create', 'description' => 'Meter reading recorded for Unit 102'],
            ['action' => 'create', 'description' => 'Bill generated for Unit 103'],
            ['action' => 'update', 'description' => 'Payment received for Bill #1'],
            ['action' => 'create', 'description' => 'Maintenance request submitted for Unit 101'],
            ['action' => 'update', 'description' => 'Maintenance request completed for Unit 105'],
            ['action' => 'create', 'description' => 'New tenant Maria Santos was registered'],
            ['action' => 'update', 'description' => 'Unit 201 status changed to occupied'],
            ['action' => 'create', 'description' => 'Monthly bills generated for May 2026'],
        ];

        foreach ($activities as $index => $activity) {
            ActivityLog::create([
                'user_id' => rand(1, 2),
                'action' => $activity['action'],
                'description' => $activity['description'],
                'created_at' => Carbon::now()->subHours(rand(1, 72)),
            ]);
        }
    }
}
