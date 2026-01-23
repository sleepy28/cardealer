<?php

namespace App\Http\Controllers;

use App\Models\Permit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PermitController extends Controller
{
    public function index()
    {
        
        
        
        $permits = Permit::with('user')
            ->whereDate('end_date', '>=', Carbon::today())
            ->orderBy('created_at', 'desc') 
            ->get();

        return view('permit.index', compact('permits'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255',
        ]);

        Permit::create([
            'user_id' => Auth::id(),
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'reason' => $request->reason,
            'status' => 'pending', 
        ]);

        return back()->with('success', 'Permohonan izin berhasil diajukan!');
    }
}