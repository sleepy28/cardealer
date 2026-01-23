<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminPermitController extends Controller
{
    public function index()
    {
      
        $permits = Permit::with(['user', 'approver'])
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")  
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.permit.index', compact('permits'));
    }

    public function approve($id)
    {
        $permit = Permit::findOrFail($id);
        
        $permit->update([
            'status' => 'approved',
            'approved_by' => Auth::id()  
        ]);

        return back()->with('success', 'Permohonan izin disetujui!');
    }

    public function reject($id)
    {
        $permit = Permit::findOrFail($id);
        
        $permit->update([
            'status' => 'rejected',
            'approved_by' => Auth::id()
        ]);

        return back()->with('success', 'Permohonan izin ditolak.');
    }
}