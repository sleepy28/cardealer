<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalarySetting;

class SalarySettingSeeder extends Seeder
{
    public function run()
    {
        
        SalarySetting::updateOrCreate(
            ['role' => 'user'], 
            [
                'base_salary' => 4800, 
                'overtime_rate' => 500,
                'threshold_hours' => 12
            ]
        );

        
        SalarySetting::updateOrCreate(
            ['role' => 'finance'], 
            [
                'base_salary' => 13600, 
                'overtime_rate' => 500,
                'threshold_hours' => 12
            ]
        );

        
        SalarySetting::updateOrCreate(
            ['role' => 'admin'], 
            [
                'base_salary' => 20000, 
                'overtime_rate' => 500,
                'threshold_hours' => 12
            ]
        );
    }
}