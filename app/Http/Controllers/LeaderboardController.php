<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class LeaderboardController extends Controller
{
    public function index()
    {
        
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

         
        
        $employees = User::where('role', '!=', 'admin')  
        
            ->withSum(['dutySessions as weekly_duty_hours' => function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('start_time', [$startOfWeek, $endOfWeek]);
            }], 'duration_hours')

           
            ->withSum('dutySessions as lifetime_duty_hours', 'duration_hours')

           
            ->withCount(['sales as weekly_sales' => function ($query) use ($startOfWeek, $endOfWeek) {
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
            }])

            
            ->withCount('sales as lifetime_sales')
            
           
            ->orderByDesc('weekly_duty_hours')
            ->get();

        return view('leaderboard.index', compact('employees'));
    }
}