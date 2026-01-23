<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommissionRate;
use Illuminate\Support\Facades\Auth; 

class AdminCommissionController extends Controller
{
    public function index()
    {
        
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.dashboard')->with('access_denied', 'Halaman Komisi hanya dapat diakses oleh Administrator Utama.');
        }
        

        $rates = CommissionRate::all();
        return view('admin.commission.index', compact('rates'));
    }

    public function update(Request $request, $id)
    {
        
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('admin.dashboard')->with('access_denied', 'Anda tidak memiliki izin mengubah nilai komisi.');
        }
        

        $request->validate([
            'amount' => 'required|numeric|min:0',
        ]);

        $rate = CommissionRate::findOrFail($id);
        
        $rate->update([
            'amount' => $request->amount,
        ]);

        return back()->with('success', 'Commission amount updated successfully!');
    }
}