<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\CommissionRate; 
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();

        
        $historyWeeks = Sale::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy(function($item) {
                return $item->created_at->format('o-W'); 
            });

        
        if ($request->has('filter_week') && $request->filter_week != "") {
            $parts = explode('-', $request->filter_week);
            $year = $parts[0];
            $week = $parts[1];
            
            $startDate = Carbon::now()->setISODate($year, $week)->startOfWeek();
            $endDate = Carbon::now()->setISODate($year, $week)->endOfWeek();
            
            $label = "Arsip: Minggu ke-$week Tahun $year";
        } else {
            $startDate = Carbon::now()->startOfWeek();
            $endDate = Carbon::now()->endOfWeek();
            $label = "Penjualan Minggu Ini";
        }

        
        $sales = Sale::where('user_id', $userId)
                        ->whereBetween('created_at', [$startDate, $endDate])
                        ->latest()
                        ->get();

        
        $totalSales = $sales->count();
        $totalRevenue = $sales->sum('commission');

        
        $dailyTotal = Sale::where('user_id', $userId)
                          ->whereDate('created_at', Carbon::today())
                          ->sum('sale_price');

        return view('sales.index', compact(
            'sales', 
            'totalSales', 
            'totalRevenue', 
            'historyWeeks', 
            'label', 
            'startDate',
            'dailyTotal'
        ));
    }

    public function store(Request $request)
    {
        
        
        
        $rateData = CommissionRate::where('category', $request->category)->first();

        
        $commissionAmount = $rateData ? $rateData->amount : 0;

        Sale::create([
            'user_id'       => auth()->id(), 
            'vehicle_model' => $request->vehicle_model,
            'category'      => $request->category,
            'buyer_name'    => $request->buyer_name,
            'sale_price'    => $request->price, 
            'commission'    => $commissionAmount, 
            'notes'         => $request->notes
        ]);

        return redirect()->back()->with('success', 'Penjualan berhasil dicatat! Komisi: $' . number_format($commissionAmount));
    }
}