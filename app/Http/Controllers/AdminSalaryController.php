<?php

namespace App\Http\Controllers; 

use App\Models\User;
use App\Models\PayrollPayment; 
use App\Models\SalarySetting;  
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminSalaryController extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->has('start_date') && $request->has('end_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $endDate   = Carbon::parse($request->end_date)->endOfDay();
        } else {
            $startDate = Carbon::now()->startOfWeek();
            $endDate   = Carbon::now()->endOfWeek();
        }

        
        $employees = User::where('role', '!=', 'admin')
            ->withCount(['sales' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->withSum(['sales' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('created_at', [$startDate, $endDate]);
            }], 'commission')
            ->withSum(['dutySessions as weekly_duty_hours' => function ($query) use ($startDate, $endDate) {
                $query->whereBetween('start_time', [$startDate, $endDate]);
            }], 'duration_hours')
            ->get();

        
        $grandTotalPayout = 0;

        foreach ($employees as $emp) {
            
            $role = $emp->role ?? 'showroom_sales';
            $setting = SalarySetting::where('role', $role)->first();
            $baseSalary = $setting ? $setting->base_salary : 0;

            
            $rawHours = $emp->weekly_duty_hours ?? 0;
            $jamBulat = floor($rawHours);
            $threshold = 12; 
            $overtimeRate = 500;
            
            
            $normalRate = $threshold > 0 ? ($baseSalary / $threshold) : 0; 
            $penaltyRate = $normalRate / 2;

            $finalSalary = 0;

            if ($jamBulat > $threshold) {
                
                $overtimeHours = $jamBulat - $threshold;
                $finalSalary = $baseSalary + ($overtimeHours * $overtimeRate);
            } elseif ($jamBulat == $threshold) {
                
                $finalSalary = $baseSalary;
            } else {
                
                if ($jamBulat > 0) {
                    $finalSalary = $penaltyRate * $jamBulat;
                } else {
                    $finalSalary = 0;
                }
            }

            
            $commission = $emp->sales_sum_commission ?? 0;
            
            
            $grandTotalPayout += ($finalSalary + $commission);
        }

        
        $totalPayout = $grandTotalPayout;

        return view('admin.salary.index', compact('employees', 'totalPayout', 'startDate', 'endDate'));
    }

    
    public function markAsPaid(Request $request)
    {
        
        $request->validate([
            'employee_id' => 'required',
            'start_date' => 'required|date',
        ]);

        
        PayrollPayment::updateOrCreate(
            [
                'user_id' => $request->employee_id,
                'start_date' => $request->start_date, 
            ],
            [
                'end_date' => $request->end_date,
                'is_paid' => true,
                'paid_by_name' => auth()->user()->name 
            ]
        );

        return response()->json(['success' => true]);
    }
}