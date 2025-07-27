<?php

use App\Http\Controllers\MolliePayment;
use App\Http\Controllers\MollieWebhook;
use App\Http\Controllers\UserController;
use App\Livewire\Admin\UserTable;
use App\Livewire\Dashboard;
use App\Livewire\Invoices\InvoiceTable;
use App\Livewire\Payments\PaymentTable;
use App\Livewire\Tallies\TallyTable;
use App\Livewire\Users\UserSelect;
use App\Livewire\Users\UserTab;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

require __DIR__.'/auth.php';

Route::middleware('auth')->group(function () {
    Route::impersonate();

    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/user-tab/{user?}', UserTab::class)->name('user-tab');
    Route::get('/user-select/{user}', UserSelect::class)->name('user-select');

    Route::middleware('can:admin')->group(function () {
        Route::get('/admin-dashboard', App\Livewire\Admin\Dashboard::class)->name('admin-dashboard');
        Route::get('/users', UserTable::class)->name('users');

        Route::get('/user-tab/{user}/invoice', [UserController::class, 'newInvoice'])->name('new-invoice');

        Route::get('/assortments', \App\Livewire\Admin\AssortmentTable::class)->name('assortments');
        Route::get('/expenses', \App\Livewire\Admin\ExpenseTable::class)->name('expenses');
        Route::get('/tally-lists', \App\Livewire\Admin\TallyListTable::class)->name('tally-lists');
    });
    Route::get('/invoices', InvoiceTable::class)->name('invoices');
    Route::get('/payments', PaymentTable::class)->name('payments');
    Route::get('/tallies', TallyTable::class)->name('tallies');
});

Route::get('mollie/payment/{payment_key}', [MolliePayment::class, 'paymentForm'])->name('mollie.payment');
Route::post('mollie/preparePayment', [MolliePayment::class, 'preparePayment'])->name('mollie.preparePayment');
Route::get('mollie/autoPayment/{payment_key}', [MolliePayment::class, 'autoPaymentForm'])->name('mollie.autoPayment');
Route::get('mollie/editAutoPayment/{payment_key}', [MolliePayment::class, 'editAutoPaymentForm'])->name('mollie.editAutoPayment');
Route::post('mollie/saveEditAutoPayment', [MolliePayment::class, 'saveEditAutoPayment'])->name('mollie.saveEditAutoPayment');
Route::post('mollie/cancelAutoPayment', [MolliePayment::class, 'cancelAutoPayment'])->name('mollie.cancelAutoPayment');
Route::post('mollie/prepareAutoPayment', [MolliePayment::class, 'prepareAutoPayment'])->name('mollie.prepareAutoPayment');

Route::get('mollie/returnPayment', [MollieWebhook::class, 'returnPayment'])->name('return.payment');
Route::post('mollie/webhook', [MollieWebhook::class, 'webhook'])->name('webhook.mollie')->middleware(VerifyCsrfToken::class);
