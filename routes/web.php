<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\CheckinController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/checkout', function () {
    return view('checkout');
});
Route::view('barcode', 'barcode');
Route::post('/buy-tickets', [TicketController::class, 'storeDraft'])->name('buy.tickets');
Route::get('/checkout', [TicketController::class, 'checkout'])->name('checkout');
Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
Route::get('/payment/callback', [PaymentController::class, 'paymentCallback'])->name('payment.callback');

Route::post('/payment/initiate', [PaymentController::class, 'initiate'])->name('payment.initiate');
Route::post('/payment/complete', [PaymentController::class, 'complete'])->name('payment.complete');

Route::get('/confirm-checking', [CheckinController::class, 'showConfirmationPage'])->name('confirm.checking');

Route::post('/confirm-checking', [CheckinController::class, 'confirmCheckin'])->name('confirm.checkin');


Route::get('admin/ticket', function () {
    return view('admin.ticket');
})->name('admin.ticket');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('admin/dashboard', [DashboardController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/reserve-tickets', [TicketController::class, 'reserveTickets'])->name('reserve.tickets');

    Route::get('/reservation/success', [TicketController::class, 'showSuccessPage'])->name('reservation.success');

    Route::patch('/admin/update-payment-status/{ticketId}', [TicketController::class, 'updatePaymentStatus'])
     ->name('admin.update.payment.status');
Route::patch('/admin/update-issued-status/{ticketId}', [TicketController::class, 'updateIssuedStatus'])
     ->name('admin.update.issued.status');
     Route::delete('/admin/ticket/{id}', [TicketController::class, 'destroy'])->name('admin.delete.ticket');

     Route::post('/save-qr-code', [TicketController::class, 'saveQRCode']);
     Route::get('/checkins', [CheckinController::class, 'index'])->name('checkins.index');
     

});

require __DIR__.'/auth.php';
