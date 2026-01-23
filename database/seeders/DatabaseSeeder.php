<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SalarySetting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        
        $settings = [
              
    ['role' => 'recruit',        'base_salary' => 4800], 
    ['role' => 'showroom_sales', 'base_salary' => 8000],
    ['role' => 'business_sales', 'base_salary' => 10800],
    
    
    ['role' => 'user',           'base_salary' => 4800],
    ['role' => 'finance',        'base_salary' => 13600],
        ];

        foreach ($settings as $setting) {
            SalarySetting::updateOrCreate(
                ['role' => $setting['role']], 
                ['base_salary' => $setting['base_salary']] 
            );
        }
    }
}