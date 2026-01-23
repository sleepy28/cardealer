<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DutySession;
use App\Models\Sale; 
use Carbon\Carbon;
use App\Models\SalarySetting;
class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

      
        $totalHours = DutySession::where('user_id', $user->id)
                                ->whereNotNull('end_time')
                                ->sum('duration_hours');

        $totalHari = floor($totalHours / 24); 

       
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek = Carbon::now()->endOfWeek();

     
        $salesThisWeek = Sale::where('user_id', $user->id) 
                             ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                             ->count();

        $revenueThisWeek = Sale::where('user_id', $user->id)
                               ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                               ->sum('sale_price');

       
        $grafikJam = array_fill(0, 7, 0);
        $grafikInvoice = array_fill(0, 7, 0);

      
        $sessionsData = DutySession::where('user_id', $user->id)
                                   ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
                                   ->get();
                                   
        foreach ($sessionsData as $s) {
           
            $idx = Carbon::parse($s->start_time)->dayOfWeekIso - 1; 
            
            $grafikJam[$idx] += $s->duration_hours ?? 0;
        }

        
        $salesData = Sale::where('user_id', $user->id)
                         ->whereBetween('created_at', [$startOfWeek, $endOfWeek])
                         ->get();

        foreach ($salesData as $sale) {
            $idx = Carbon::parse($sale->created_at)->dayOfWeekIso - 1;
            $grafikInvoice[$idx] += $sale->sale_price;
        }
        // ==========================================


        $data = [
            'user' => $user,
            'total_hari' => $totalHari,
            'total_jam' => number_format($totalHours, 2), 
            'total_tiket' => $salesThisWeek,
            'total_invoice' => $revenueThisWeek,
          
            'grafik_jam' => $grafikJam,
            'grafik_invoice' => $grafikInvoice,
            
      
            'recent_sessions' => DutySession::where('user_id', $user->id)
                                            ->latest()
                                            ->take(5)
                                            ->get()
        ];

        return view('dashboard.user', compact('data'));
    }
 
    public function toggleDuty(Request $request)
    {
        
        $user = Auth::user();
        $now = Carbon::now(); 

        if ($user->is_on_duty) {
            $session = DutySession::where('user_id', $user->id)
                        ->whereNull('end_time')
                        ->latest()
                        ->first();
            
            if ($session) {
                $startTime = Carbon::parse($session->start_time);
                $duration = $startTime->diffInMinutes($now) / 60; 

                $session->update([
                    'end_time' => $now,
                    'duration_hours' => $duration
                ]);
            }
            
            $user->update(['is_on_duty' => false]);
            
            return response()->json([
                'status' => 'off', 
                'message' => 'Anda telah Off-Duty. Durasi: ' . number_format($duration ?? 0, 2) . ' Jam'
            ]);

        } else {
            DutySession::create([
                'user_id' => $user->id,
                'start_time' => $now,
            ]);

            $user->update(['is_on_duty' => true]);

            return response()->json(['status' => 'on', 'message' => 'Anda sekarang On-Duty!']);
        }
        
    }
    public function history(Request $request)
    {
        $user = Auth::user();
        
    
        $startDate = $request->input('start_date', Carbon::now()->subDays(30)->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->format('Y-m-d'));
 
        $history = DutySession::where('user_id', $user->id)
                              ->whereDate('start_time', '>=', $startDate)
                              ->whereDate('start_time', '<=', $endDate)
                              ->orderBy('start_time', 'desc')
                              ->get();
 
        return view('dashboard.history', compact('history', 'startDate', 'endDate'));
    }

     



    

public function dutySalary()
{
    $user = Auth::user();

    
    $setting = SalarySetting::where('role', $user->role)->first();
    $baseSalary   = $setting ? $setting->base_salary : 0; 
    $overtimeRate = 500; 
    $threshold    = 12;
    $normalRate   = $threshold > 0 ? ($baseSalary / $threshold) : 0;
    $penaltyRate  = $normalRate / 2;

  
    $startOfWeek = Carbon::now()->startOfWeek();
    $endOfWeek   = Carbon::now()->endOfWeek();

    $totalHoursDecimal = DutySession::where('user_id', $user->id)
        ->whereBetween('start_time', [$startOfWeek, $endOfWeek])
        ->whereNotNull('end_time')
        ->sum('duration_hours'); 
    
    $totalSeconds = $totalHoursDecimal * 3600;
    $jamBulat = floor($totalHoursDecimal); 

    
    if ($jamBulat > $threshold) {
        $overtimeHours = $jamBulat - $threshold;
        $salary = $baseSalary + ($overtimeHours * $overtimeRate);
        $catatan = "Target Reached + OT";
        $rumus = "Base + (OT x 500)";
        $currentHourlyRate = $overtimeRate;
    } elseif ($jamBulat == $threshold) {
        $salary = $baseSalary;
        $catatan = "Target Reached";
        $rumus = "Full Base Salary";
        $currentHourlyRate = $normalRate;
    } else {
        if ($jamBulat > 0) {
            $salary = $penaltyRate * $jamBulat; 
            $catatan = "Under Target";
            $rumus = "Rate $$penaltyRate x $jamBulat Jam";
            $currentHourlyRate = $penaltyRate;
        } else {
            $salary = 0;
            $catatan = "0 Jam Kerja";
            $rumus = "-";
            $currentHourlyRate = $penaltyRate;  
        }
    }

    $hoursDisplay   = floor($totalSeconds / 3600);
    $minutesDisplay = floor(($totalSeconds % 3600) / 60);

    $data = [
        'start_date'     => $startOfWeek->format('d M Y'),
        'end_date'       => $endOfWeek->format('d M Y'),
        'formatted_time' => "$hoursDisplay hours $minutesDisplay minutes",
        'total_jam_raw'  => $totalHoursDecimal,
        'gaji_final'     => $salary,
        'catatan'        => $catatan,
        'rumus'          => $rumus,
        'current_rate'   => $currentHourlyRate,
        'role'           => $user->role,
        'base_salary'    => $baseSalary
    ];

    
    $history = [];
    
    for ($i = 1; $i <= 4; $i++) {
      
        $histStart = Carbon::now()->subWeeks($i)->startOfWeek();
        $histEnd   = Carbon::now()->subWeeks($i)->endOfWeek();

        $histHours = DutySession::where('user_id', $user->id)
            ->whereBetween('start_time', [$histStart, $histEnd])
            ->whereNotNull('end_time')
            ->sum('duration_hours');

        $histJamBulat = floor($histHours);
        $histSalary = 0;
        $histStatus = '';
        $histClass  = '';  
 
        if ($histJamBulat > $threshold) {
            $histOT = $histJamBulat - $threshold;
            $histSalary = $baseSalary + ($histOT * $overtimeRate);
            $histStatus = "Overtime (+". $histOT ."h)";
            $histClass = "success";
        } elseif ($histJamBulat == $threshold) {
            $histSalary = $baseSalary;
            $histStatus = "Target Reached";
            $histClass = "success";
        } else {
            if ($histJamBulat > 0) {
                $histSalary = $penaltyRate * $histJamBulat;
                $histStatus = "Under Target";
                $histClass = "warning";
            } else {
                $histSalary = 0;
                $histStatus = "No Duty";
                $histClass = "secondary";
            }
        }
 
        $hSec = $histHours * 3600;
        $hH = floor($hSec / 3600);
        $hM = floor(($hSec % 3600) / 60);

        $history[] = [
            'period' => $histStart->format('d M') . ' - ' . $histEnd->format('d M'),
            'hours'  => "{$hH}h {$hM}m",
            'salary' => $histSalary,
            'status' => $histStatus,
            'class'  => $histClass
        ];
    }

    return view('dashboard.duty-salary', compact('data', 'history'));
}
}
