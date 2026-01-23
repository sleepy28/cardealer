<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\DutySession;
use App\Models\SalarySetting;
use Carbon\Carbon;

class SalaryReportController extends Controller
{
    public function index(Request $request)
    {
        $weeksAgo = $request->input('week', 0); 
        $startOfWeek = Carbon::now()->subWeeks($weeksAgo)->startOfWeek();
        $endOfWeek   = Carbon::now()->subWeeks($weeksAgo)->endOfWeek();

        $users = User::where('role', '!=', 'admin')->get();

        $report = [];
        $totalPayout = 0;

        foreach ($users as $user) {
            $totalHoursDecimal = DutySession::where('user_id', $user->id)
                ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
                ->whereNotNull('end_time')
                ->sum('duration_hours');

            $setting = SalarySetting::where('role', $user->role)->first();
            $baseSalary   = $setting ? $setting->base_salary : 0; 
            $overtimeRate = 500;
            $threshold    = 12;

            $jamBulat = floor($totalHoursDecimal); 
            
            
            $normalRate = $threshold > 0 ? ($baseSalary / $threshold) : 0; 
            $penaltyRate = $normalRate / 2; 
            
            
            if ($jamBulat > $threshold) {
                $activeRate = $overtimeRate; 
            } elseif ($jamBulat < $threshold) {
                $activeRate = $penaltyRate;  
            } else {
                $activeRate = $normalRate;   
            }

            $salary = 0;
            $status = '';
            $rumus  = '';
            $cssClass = '';

            if ($jamBulat > $threshold) {
                
                $overtimeHours = $jamBulat - $threshold;
                $salary = $baseSalary + ($overtimeHours * $overtimeRate);
                $status = "Target Reached (+OT)";
                $rumus  = "Base + OT";
                $cssClass = "text-success fw-bold";

            } elseif ($jamBulat == $threshold) {
                
                $salary = $baseSalary;
                $status = "Target Reached";
                $rumus  = "Full Base";
                $cssClass = "text-success";

            } else {
                
                if ($jamBulat > 0) {
                    $salary = $penaltyRate * $jamBulat; 
                    $status = "Under Target";
                    $rumus  = "Rate $$penaltyRate x $jamBulat";
                    $cssClass = "text-danger";
                } else {
                    $salary = 0;
                    $status = "No Hours";
                    $rumus  = "-";
                    $cssClass = "text-muted";
                }
            }

            $totalPayout += $salary;

            $totalSeconds = $totalHoursDecimal * 3600;
            $h = floor($totalSeconds / 3600);
            $m = floor(($totalSeconds % 3600) / 60);

            $report[] = [
                'user'            => $user,
                'role'            => ucfirst($user->role),
                'base_salary'     => $baseSalary,
                'jam_bulat'       => $jamBulat,
                'formatted_time'  => "{$h}h {$m}m",
                'salary_final'    => $salary,
                'status'          => $status,
                'rumus'           => $rumus,
                'css_class'       => $cssClass,
                'active_rate'     => $activeRate 
            ];
        }

        return view('admin.salary-report', compact('report', 'startOfWeek', 'endOfWeek', 'weeksAgo', 'totalPayout'));
    }
}