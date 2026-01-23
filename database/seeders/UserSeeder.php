<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        
        
        
        
        
        
        
        

        
        
        
        
        
        
        
        
        User::create([
            'citizen_id' => 'DXSN001',
            'name' => 'sleepy',
            'username' => 'sleepy1',
            'password' => Hash::make('123'), 
            'role' => 'user',
        ]);
        
        
        
        
        
        
        
    }
}