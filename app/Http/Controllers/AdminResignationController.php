<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resignation;
use Illuminate\Support\Facades\Auth;

class AdminResignationController extends Controller
{
    
    public function index()
    {
        
        
        $resignations = Resignation::with(['user', 'approver'])->latest()->get(); 
        
        return view('admin.resignation.index', compact('resignations'));
    }

    
    public function approve($id)
    {
        $resignation = Resignation::findOrFail($id);
        
        $resignation->update([
            'status' => 'approved',
            'approved_by' => Auth::id() 
        ]);

        return redirect()->back()->with('success', 'Pengajuan atas nama ' . $resignation->user->name . ' berhasil disetujui.');
    }

    
    public function reject($id)
    {
        $resignation = Resignation::findOrFail($id);
        
        $resignation->update([
            'status' => 'declined',
            'approved_by' => Auth::id() 
        ]);

        return redirect()->back()->with('error', 'Pengajuan atas nama ' . $resignation->user->name . ' telah ditolak.');
    }
}