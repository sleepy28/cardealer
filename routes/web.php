<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PermitController;
use App\Http\Controllers\AdminPermitController;
use App\Http\Controllers\AdminSalaryController;
use App\Http\Controllers\AdminCommissionController;
use App\Http\Controllers\SalarySettingController;
use App\Http\Controllers\SalaryReportController;
use App\Http\Controllers\ResignationController;
 


Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.view');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});



Route::middleware(['auth', 'admin'])->group(function () {

 
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/resignations', [App\Http\Controllers\AdminResignationController::class, 'index'])->name('resignation.index');
    Route::put('/resignations/{id}/approve', [App\Http\Controllers\AdminResignationController::class, 'approve'])->name('resignation.approve');
    Route::put('/resignations/{id}/reject', [App\Http\Controllers\AdminResignationController::class, 'reject'])->name('resignation.reject');
});
    Route::post('/admin/salary/pay', [App\Http\Controllers\AdminSalaryController::class, 'markAsPaid'])->name('admin.salary.pay');
    
    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    
    
    Route::get('/admin/employees', [AdminController::class, 'employees'])->name('admin.employees');
    Route::post('/admin/karyawan/store', [AdminController::class, 'storeEmployee'])->name('admin.employee.store');
    Route::put('/admin/employees/{id}', [AdminController::class, 'updateEmployee'])->name('admin.employees.update');
    Route::delete('/admin/employees/{id}', [AdminController::class, 'deleteEmployee'])->name('admin.employees.delete');

    
    Route::get('/admin/permits', [AdminPermitController::class, 'index'])->name('admin.permits.index');
    Route::patch('/admin/permits/{id}/approve', [AdminPermitController::class, 'approve'])->name('admin.permits.approve');
    Route::patch('/admin/permits/{id}/reject', [AdminPermitController::class, 'reject'])->name('admin.permits.reject');

    
    Route::get('/admin/salary', [AdminSalaryController::class, 'index'])->name('admin.salary.index');

    
    Route::get('/salary-settings', [SalarySettingController::class, 'index'])->name('admin.salary_settings.index');
    Route::put('/salary-settings/{id}', [SalarySettingController::class, 'update'])->name('admin.salary_settings.update');
    
    
    Route::get('/admin/commission', [AdminCommissionController::class, 'index'])->name('admin.commission.index');
    Route::put('/admin/commission/{id}', [AdminCommissionController::class, 'update'])->name('admin.commission.update');
    
    // Delete sales (accessible by admin and finance)
    Route::delete('/admin/sales/{id}', [SaleController::class, 'destroy'])->name('admin.sales.destroy');
});



Route::middleware(['auth'])->group(function () {
    


 

Route::middleware(['auth'])->group(function () {
 
Route::delete('/resignation/cancel', [App\Http\Controllers\ResignationController::class, 'destroy'])->name('resignation.destroy');
    Route::get('/resignation', [ResignationController::class, 'create'])->name('resignation.create');
    Route::post('/resignation', [ResignationController::class, 'store'])->name('resignation.store');
});
    Route::get('/leaderboard', [LeaderboardController::class, 'index'])->name('leaderboard');
    Route::put('/leaderboard/{id}', [LeaderboardController::class, 'update'])->name('leaderboard.update');
    Route::get('/duty-salary', [DashboardController::class, 'dutySalary'])->name('dashboard.duty-salary');
    
    Route::get('/permit', [PermitController::class, 'index'])->name('permit.index');
    Route::post('/permit', [PermitController::class, 'store'])->name('permit.store');
Route::get('/admin/salary-report', [SalaryReportController::class, 'index'])
        ->name('admin.salary.report');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard'); 
    Route::post('/dashboard/toggle-duty', [DashboardController::class, 'toggleDuty'])->name('duty.toggle');
    Route::get('/riwayat-duty', [DashboardController::class, 'history'])->name('duty.history');

    
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index');
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store');

    
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});