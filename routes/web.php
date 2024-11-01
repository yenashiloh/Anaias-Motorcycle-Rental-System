<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignUpController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CustomerDashboardController;
use App\Http\Controllers\BookingsController;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\HomeController;
use App\Http\Middleware\PreventBackHistory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReservationsExport;

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

Route::get('/motorcycles/search', [HomeController::class, 'search'])->name('motorcycles.search');


//Motorcycle Customer
Route::get('/motorcycle/details/{id}', [HomeController::class, 'viewDetailsMotorcycle'])->name('motorcycle.details-motorcycle');

Route::middleware([PreventBackHistory::class, 'customer'])->group(function () {
    Route::post('logoutCustomer', [SignUpController::class, 'logoutCustomer'])->name('customer.logout');

    //Reservation Transaction
    Route::get('/motorcycle/reservation/details', [HomeController::class, 'viewReservationDetails'])->name('reservation.details');
    Route::post('/reservation/process', [HomeController::class, 'process'])->name('reservation.process');
    Route::get('/payment/{reservation_id}', [HomeController::class, 'showPayment'])->name('motorcycle.payment');
    Route::post('/payment/process', [HomeController::class, 'processPayment'])->name('payment.process');
    Route::get('/reservation/confirmation/{reservation_id}', [HomeController::class, 'confirmation'])->name('reservation.confirmation');
    Route::get('/reservation/success/{reservation_id}', [HomeController::class, 'showSuccessPage'])->name('motorcycle.success');

    //Dashboard
    Route::get('/customer/dashboard', [CustomerDashboardController::class, 'viewDashboard'])->name('customer.customer-dashboard');

    
});

//ADMIN SIDE 
Route::middleware([PreventBackHistory::class, 'admin'])->group(function () {
    Route::get('admin-dashboard', [AdminDashboardController::class, 'showAdminDashboard'])->name('admin.admin-dashboard');
    Route::get('/motorcycles/manage-motorcycles', [MotorcycleController::class, 'showManageMotorcycles'])->name('admin.motorcycles.manage-motorcycles');
    Route::post('/motorcycles/update-status/{motor_id}', [MotorcycleController::class, 'updateStatus'])->name('admin.motorcycles.update-status');
    Route::post('motorcycles', [MotorcycleController::class, 'store'])->name('motorcycles.store');
    Route::get('/motorcycles/add-motorcycles', [MotorcycleController::class, 'showaddMotorcycles'])->name('admin.motorcycles.add-motorcycle');
    Route::delete('/motorcycles/{id}', [MotorcycleController::class, 'destroy'])->name('motorcycles.destroy');
    Route::get('edit-motorcycle/{motor_id}', [MotorcycleController::class, 'edit'])->name('admin.motorcycles.edit-motorcycle');
    Route::put('/motorcycles/{motor_id}', [MotorcycleController::class, 'update'])->name('admin.motorcycles.update');
    Route::get('/view-motorcycle/{motor_id}', [MotorcycleController::class, 'viewMotorcycle'])->name('admin.motorcycles.view-motorcycle');
    Route::post('/logout', [AdminLoginController::class, 'logoutAdmin'])->name('logout');

    //bookings
    Route::get('/reservation/bookings', [BookingsController::class, 'showBookings'])->name('admin.reservation.bookings');
    Route::get('/bookings/view/{id}', [BookingsController::class, 'viewBookings'])->name('admin.reservation.view-bookings');

    //all bookings record
    Route::get('/reservation/all-bookings-record', [BookingsController::class, 'showAllBookings'])->name('admin.reservation.all-bookings-record');
    Route::get('/all-bookings-record/view/{id}', [BookingsController::class, 'viewAllBookingsRecord'])->name('admin.reservation.view-all-bookings');

    Route::get('/reservation/ongoing-bookings', [BookingsController::class, 'showOngoingBookings'])->name('admin.reservation.ongoing-bookings');
    Route::get('/ongoing-bookings/view/{id}', [BookingsController::class, 'viewOngoingBookings'])->name('admin.reservation.view-ongoing-bookings');

    //change status
    Route::post('reservations/approve/{id}', [BookingsController::class, 'approve'])->name('reservations.approve');
    Route::post('reservations/decline/{id}', [BookingsController::class, 'decline'])->name('reservations.decline');
    Route::post('reservations/cancel/{reservation}', [BookingsController::class, 'cancel'])->name('reservations.cancel');
    Route::post('reservations/mark-ongoing/{reservation}', [BookingsController::class, 'markOngoing'])->name('reservations.markOngoing');
    Route::post('reservations/completed/{reservation}', [BookingsController::class, 'completed'])->name('reservations.completed');

   
    Route::get('/reservations/invoice/{reservationId}', [BookingsController::class, 'generateInvoice'])->name('reservations.invoice');

    Route::get('/export-reservations', function () {
        return Excel::download(new ReservationsExport, 'reservations.xlsx');
    })->name('export.reservations');
});
