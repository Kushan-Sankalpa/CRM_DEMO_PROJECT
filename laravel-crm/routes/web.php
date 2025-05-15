<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\TransactionController;



Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('customers', CustomerController::class)->middleware(['auth']);
Route::post('customers/{customer}/status', [CustomerController::class, 'updateStatus'])->name('customers.updateStatus')->middleware(['auth']);

Route::resource('proposals', ProposalController::class)->middleware(['auth']);
Route::post('proposals/{proposal}/status', [ProposalController::class, 'updateStatus'])->name('proposals.updateStatus')->middleware(['auth']);

Route::resource('invoices', InvoiceController::class)->middleware(['auth']);
Route::post('invoices/{invoice}/status', [InvoiceController::class, 'updateStatus'])->name('invoices.updateStatus')->middleware(['auth']);
Route::get('invoices/{invoice}/send', [InvoiceController::class, 'send'])->name('invoices.send')->middleware(['auth']);
Route::get('invoices/{invoice}/pay', [InvoiceController::class, 'pay'])->name('invoices.pay');
Route::get('invoices/{invoice}/payment/success', [InvoiceController::class, 'paymentSuccess'])->name('invoices.payment.success');
Route::get('invoices/{invoice}/payment/cancel', [InvoiceController::class, 'paymentCancel'])->name('invoices.payment.cancel');

Route::resource('transactions', TransactionController::class)->only(['index'])->middleware(['auth']);

require __DIR__.'/auth.php';
