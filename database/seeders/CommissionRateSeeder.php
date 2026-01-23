<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CommissionRate;

class CommissionRateSeeder extends Seeder
{
    public function run()
    {
        
        CommissionRate::truncate();

        $data = [
            ['category' => 'Luxury',    'amount' => 5000],
            ['category' => 'HighClass', 'amount' => 3500],
            ['category' => 'PDM',       'amount' => 4500],
            ['category' => 'BMX',  'amount' => 1500],
        ];

        foreach ($data as $item) {
            CommissionRate::create($item);
        }
    }
}