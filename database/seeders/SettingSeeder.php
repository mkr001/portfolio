<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(['key' => 'upi_id'], ['value' => 'mukesh@upi']);
        \App\Models\Setting::updateOrCreate(['key' => 'donation_link'], ['value' => 'https://buymeacoffee.com/mukesh']);
        \App\Models\Setting::updateOrCreate(['key' => 'total_donations'], ['value' => '0']);
    }
}
