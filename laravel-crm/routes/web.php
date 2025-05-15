<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TransactionController;


//login page
Route::get('/', function () { 
   return redirect('/login');
});

//dashboard page(navigate only  after login)
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//profile page
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//customer page routes
Route::resource('customers', CustomerController::class)->middleware(['auth']);
Route::post('customers/{customer}/status', [CustomerController::class, 'updateStatus'])->name('customers.updateStatus')->middleware(['auth']);

//proposal page routes
Route::resource('proposals', ProposalController::class)->middleware(['auth']);
Route::post('proposals/{proposal}/status', [ProposalController::class, 'updateStatus'])->name('proposals.updateStatus')->middleware(['auth']);

//invoice page routes
Route::resource('invoices', InvoiceController::class)->middleware(['auth']);
Route::post('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus')->middleware(['auth']);
Route::get('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send')->middleware(['auth']);
Route::get('invoices/{invoice}/pay', [InvoiceController::class, 'pay'])->name('invoices.pay');
Route::get('invoices/{invoice}/payment/success', [InvoiceController::class, 'paymentSuccess'])->name('invoices.payment.success');
Route::get('invoices/{invoice}/payment/cancel', [InvoiceController::class, 'paymentCancel'])->name('invoices.payment.cancel');

//transaction page routes
Route::resource('transactions', TransactionController::class)->only(['index'])->middleware(['auth']);

//login page routes
Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

require __DIR__.'/auth.php';
