<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\PreventBackHistory;

Route::get('/', [HomeController::class, 'home'])->name('home');

//Sign up
Route::get('sign-up', [SignUpController::class, 'showSignUpForm'])->name('sign-up');
Route::post('sign-up.registration', [SignUpController::class, 'storeRegistration'])->name('storeRegistration');
Route::get('motorcycles', [HomeController::class, 'viewMotorcycleCategories'])->name('motorcycles');
Route::get('login', [SignUpController::class, 'showLoginCustomer'])->name('login');
Route::post('login', [SignUpController::class, 'loginCustomer'])->name('customer.login');

//OTP
Route::get('email/otp', [SignUpController::class, 'showOtp'])->name('email.otp');
Route::post('/email/verify', [SignUpController::class, 'verifyOtp'])->name('email.verify');
Route::post('/email/resend', [SignUpController::class, 'resendOtp'])->name('email.resend');
Route::get('success-verification', [SignUpController::class, 'successVerification'])->name('success-verification');

Route::get('/admin/admin-login', [AdminLoginController::class, 'showLoginForm'])->name('admin.admin-login')->middleware(\App\Http\Middleware\PreventBackHistory::class);
Route::post('admin/admin-login', [AdminLoginController::class, 'loginDashboard'])->middleware(\App\Http\Middleware\PreventBackHistory::class);
// Route::post('logout', [SignUpController::class, 'logoutCustomer'])->name('customer.logout');
Route::get('/details-motorcycle/{id}', [HomeController::class, 'viewDetailsMotorcycle'])->name('motorcycle.details-motorcycle');

Route::middleware([PreventBackHistory::class, 'customer'])->group(function () {
    Route::post('logoutCustomer', [SignUpController::class, 'logoutCustomer'])->name('customer.logout');
});

Route::middleware([PreventBackHistory::class, 'admin'])->group(function () {
    Route::get('admin-dashboard', [AdminDashboardController::class, 'showAdminDashboard'])->name('admin.admin-dashboard');
    Route::get('/motorcycles/manage-motorcycles', [MotorcycleController::class, 'showManageMotorcycles'])->name('admin.motorcycles.manage-motorcycles');
    Route::post('motorcycles', [MotorcycleController::class, 'store'])->name('motorcycles.store');
    Route::get('/motorcycles/add-motorcycles', [MotorcycleController::class, 'showaddMotorcycles'])->name('admin.motorcycles.add-motorcycle');
    Route::delete('/motorcycles/{id}', [MotorcycleController::class, 'destroy'])->name('motorcycles.destroy');
    Route::get('edit-motorcycle/{motor_id}', [MotorcycleController::class, 'edit'])->name('admin.motorcycles.edit-motorcycle');
    Route::put('/motorcycles/{motor_id}', [MotorcycleController::class, 'update'])->name('admin.motorcycles.update');
    Route::get('/view-motorcycle/{motor_id}', [MotorcycleController::class, 'viewMotorcycle'])->name('admin.motorcycles.view-motorcycle');
    Route::post('/logout', [AdminLoginController::class, 'logoutAdmin'])->name('logout');
});
