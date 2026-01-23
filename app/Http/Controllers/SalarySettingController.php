<?php

namespace App\Http\Controllers;

use App\Models\SalarySetting;
use Illuminate\Http\Request;

class SalarySettingController extends Controller
{
    public function index()
    {
        $settings = SalarySetting::all();
        return view('admin.salary_settings.index', compact('settings'));
    }

    
    public function update(Request $request, $id)
    {
        
        $request->validate([
            'base_salary' => 'required|numeric',
            'overtime_rate' => 'required|numeric',
        ]);

        
        $setting = SalarySetting::findOrFail($id);

        
        $setting->update([
            'base_salary' => $request->base_salary,
            'overtime_rate' => $request->overtime_rate,
            
            'threshold_hours' => $request->threshold_hours ?? $setting->threshold_hours
        ]);

        
        return redirect()->back()->with('success', 'Gaji untuk role ' . $setting->role . ' berhasil diupdate!');
    }
}