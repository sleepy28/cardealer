<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DutySession;
use App\Models\Sale;
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

  
    public function update(Request $request, $id)
    {
        $user = auth()->user();

    
        if (!in_array($user->role, ['admin', 'finance'])) {
            return back()->with('error', 'Unauthorized action.');
        }

        $request->validate([
            'weekly_duty_hours' => 'required|numeric|min:0',
            'weekly_sales'      => 'required|integer|min:0',
            'lifetime_sales'    => 'required|integer|min:0',
        ]);

        $employee = User::findOrFail($id);
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();

        
        $newWeeklyHours = (float) $request->weekly_duty_hours;

        DutySession::where('user_id', $employee->id)
            ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
            ->delete();

        if ($newWeeklyHours > 0) {
            DutySession::create([
                'user_id'        => $employee->id,
                'start_time'     => $startOfWeek->copy()->addHour(),
                'end_time'       => $startOfWeek->copy()->addHour()->addHours((int) floor($newWeeklyHours))->addMinutes((int) round(($newWeeklyHours - floor($newWeeklyHours)) * 60)),
                'duration_hours' => $newWeeklyHours,
            ]);
        }


        $currentWeeklySales = Sale::where('user_id', $employee->id)
            ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->count();

        $desiredWeeklySales = (int) $request->weekly_sales;

        if ($desiredWeeklySales > $currentWeeklySales) {
  
            $toAdd = $desiredWeeklySales - $currentWeeklySales;
            for ($i = 0; $i < $toAdd; $i++) {
                Sale::create([
                    'user_id'       => $employee->id,
                    'vehicle_model' => 'Adjusted Entry',
                    'category'      => 'adjustment',
                    'buyer_name'    => 'Leaderboard Adjustment',
                    'sale_price'    => 0,
                    'commission'    => 0,
                    'notes'         => 'Added via leaderboard edit by ' . $user->name,
                    'created_at'    => Carbon::now(),
                    'updated_at'    => Carbon::now(),
                ]);
            }
        } elseif ($desiredWeeklySales < $currentWeeklySales) {

            $toRemove = $currentWeeklySales - $desiredWeeklySales;
            Sale::where('user_id', $employee->id)
                ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                ->orderByDesc('id')
                ->limit($toRemove)
                ->delete();
        }

 
        $totalSalesNow = Sale::where('user_id', $employee->id)->count();
        $desiredLifetimeSales = (int) $request->lifetime_sales;
 
        if ($desiredLifetimeSales < $desiredWeeklySales) {
            $desiredLifetimeSales = $desiredWeeklySales;
        }

        if ($desiredLifetimeSales > $totalSalesNow) {
            $toAdd = $desiredLifetimeSales - $totalSalesNow;
            for ($i = 0; $i < $toAdd; $i++) {
                Sale::create([
                    'user_id'       => $employee->id,
                    'vehicle_model' => 'Historical Entry',
                    'category'      => 'adjustment',
                    'buyer_name'    => 'Leaderboard Adjustment',
                    'sale_price'    => 0,
                    'commission'    => 0,
                    'notes'         => 'Lifetime adjustment via leaderboard by ' . $user->name,
                    'created_at'    => $startOfWeek->copy()->subWeek(),  
                    'updated_at'    => $startOfWeek->copy()->subWeek(),
                ]);
            }
        } elseif ($desiredLifetimeSales < $totalSalesNow) {
   
            $toRemove = $totalSalesNow - $desiredLifetimeSales;
            Sale::where('user_id', $employee->id)
                ->where(function($q) use ($startOfWeek, $endOfWeek) {
                    $q->where('created_at', '<', $startOfWeek)
                      ->orWhere('created_at', '>', $endOfWeek);
                })
                ->orderBy('id')
                ->limit($toRemove)
                ->delete();
        }

        return back()->with('success', 'Leaderboard data for ' . $employee->name . ' has been updated.');
    }
}