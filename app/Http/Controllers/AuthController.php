<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
 
    public function showLoginForm()
    {
        return view('login');
    }

 
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

  
            if (Auth::user()->role === 'admin') {
                return redirect()->intended('admin/dashboard');
            }
            
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'username' => 'Username atau password salah.',
        ]);
    }

     
    public function userDashboard()
    {
        $user = Auth::user();
        
       
        $data = [
            'total_hari' => 12,
            'total_jam' => 45.5,
            'total_tiket' => 150,
            'total_invoice' => 8500,  
            'user' => $user
        ];

        return view('dashboard.user', compact('data'));
    }

 
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}