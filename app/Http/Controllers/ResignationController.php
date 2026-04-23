<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resignation;
use Illuminate\Support\Facades\Auth;

class ResignationController extends Controller
{
    public function create()
    {
        
        $existingResignation = Resignation::where('user_id', Auth::id())->first();
        
        return view('resignation.create', compact('existingResignation'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|min:10',
        ]);

        Resignation::create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'status' => 'pending' 
        ]);

        return redirect()->back()->with('success', 'Pengajuan pengunduran diri berhasil dikirim dan sedang menunggu proses Admin.');
    }

    public function destroy()
    {
        
        $resignation = Resignation::where('user_id', Auth::id())
                                  ->where('status', 'pending')
                                  ->first();

        if ($resignation) {
            $resignation->delete(); 
            return redirect()->back()->with('success', 'Pengajuan pengunduran diri berhasil dibatalkan.');
        }

        return redirect()->back()->with('error', 'Data tidak ditemukan atau sudah diproses oleh Admin.');
    }
}