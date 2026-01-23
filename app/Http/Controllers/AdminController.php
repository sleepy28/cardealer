<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function dashboard()
    {
   
        $totalAnggota = User::where('role', '!=', 'admin')->count();
        
   
        $startOfWeek = Carbon::now()->startOfWeek();
        $endOfWeek   = Carbon::now()->endOfWeek();
        $totalUnitMingguan = Sale::whereBetween('created_at', [$startOfWeek, $endOfWeek])->count();
 
        $totalInvoice = Sale::sum('sale_price');

   
        $totalGaji = Sale::sum('commission');

  
        $recentSales = Sale::with('user')->latest()->take(10)->get();

    
        $topEmployees = User::where('role', 'user')
                        ->withSum('sales', 'commission')
                        ->withCount('sales')
                        ->orderByDesc('sales_sum_commission')
                        ->take(5)
                        ->get();

        return view('admin.dashboard', compact(
            'totalAnggota', 
            'totalUnitMingguan', 
            'totalInvoice', 
            'totalGaji',
            'recentSales',
            'topEmployees'
        ));
    }

 

    public function employees()
    {
  
        $users = \App\Models\User::latest()->get(); 
        
        return view('admin.employees', compact('users'));
    }

    public function storeEmployee(Request $request)
    {
     
        $roleToAssign = $request->role;

     
        if (auth()->user()->role !== 'admin') {
            $roleToAssign = 'user';
        }

 
        $request->validate([
            'citizen_id' => 'required|string|unique:users,citizen_id',
            'name'       => 'required|string|max:255',
            'username'   => 'required|string|max:50|unique:users,username',
            'password'   => 'required|string|min:6',
         
            'role'       => 'sometimes|string' 
        ]);

  
        User::create([
            'citizen_id' => $request->citizen_id,
            'name'       => $request->name,
            'username'   => $request->username,
            'password'   => Hash::make($request->password),
            'role'       => $roleToAssign,  
            'status'     => 'active',
            'is_on_duty' => false,  
        ]);

        return redirect()->back()->with('success', 'Karyawan berhasil ditambahkan!');
    }

    public function updateEmployee(Request $request, $id)
    {
        $user = \App\Models\User::findOrFail($id);

 
        if (auth()->user()->role === 'admin') {
            
            
            $request->validate([
                'name'     => 'required',
                'username' => 'required|unique:users,username,'.$id,
                'role'     => 'required|in:admin,user,finance',
                'status'   => 'required', 
            ]);

         
            $user->name = $request->name;
            $user->username = $request->username;
            $user->role = $request->role;
         
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
        } 
        
 
        else {
            
            $request->validate([
                'status' => 'required',
            ]);
          
        }

 
        $user->is_on_duty = $request->status;

        $user->save();

        return redirect()->back()->with('success', 'Data karyawan berhasil diperbarui!');
    }

    public function deleteEmployee($id)
    {
  
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Akses Ditolak: Hanya Administrator yang berhak menghapus data karyawan!');
        }

        $user = \App\Models\User::findOrFail($id);
         
        if ($user->id == auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak bisa menghapus akun sendiri!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'Karyawan telah dihapus dari database.');
    }
}