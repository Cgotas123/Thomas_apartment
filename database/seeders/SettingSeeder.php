<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'electricity_rate', 'value' => '15.00', 'description' => 'Electricity rate per kWh'],
            ['key' => 'water_rate', 'value' => '50.00', 'description' => 'Water rate per unit'],
            ['key' => 'wifi_monthly_fee', 'value' => '500.00', 'description' => 'Fixed monthly WiFi fee'],
            ['key' => 'security_deposit_months', 'value' => '1', 'description' => 'Number of months for security deposit'],
            ['key' => 'advance_rent_months', 'value' => '1', 'description' => 'Number of months for advance rent (Downpayment)'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
