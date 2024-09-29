<?php

use App\Http\Controllers\MolliePayment;
use App\Http\Controllers\MollieWebhook;
use App\Livewire\Admin\UserTable;
use App\Livewire\Dashboard;
use App\Livewire\Users\UserSelect;
use App\Livewire\Users\UserTab;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/admin-dashboard', App\Livewire\Admin\Dashboard::class)->name('admin-dashboard');
    Route::get('/', Dashboard::class)->name('dashboard');

    Route::get('/user-tab/{user?}', UserTab::class)->name('user-tab');
    Route::get('/user-select/{user}', UserSelect::class)->name('user-select');
    Route::get('/users', UserTable::class)->name('users');

    Route::get('/assortments', \App\Livewire\Admin\AssortmentTable::class)->name('assortments');
    Route::get('/expenses', \App\Livewire\Admin\ExpenseTable::class)->name('expenses');
    Route::get('/invoices', \App\Livewire\Admin\InvoiceTable::class)->name('invoices');
    Route::get('/payments', \App\Livewire\Admin\PaymentTable::class)->name('payments');
    Route::get('/tallies', \App\Livewire\Admin\TallyTable::class)->name('tallies');
    Route::get('/tally-lists', \App\Livewire\Admin\TallyListTable::class)->name('tally-lists');

});

Route::get('mollie/payment/{payment_key}', [MolliePayment::class, 'paymentForm'])->name('mollie.payment');
Route::post('mollie/preparePayment', [MolliePayment::class, 'preparePayment'])->name('mollie.preparePayment');
Route::get('mollie/autoPayment/{payment_key}', [MolliePayment::class, 'autoPaymentForm'])->name('mollie.autoPayment');
Route::get('mollie/editAutoPayment/{payment_key}', [MolliePayment::class, 'editAutoPaymentForm'])->name('mollie.editAutoPayment');
Route::post('mollie/saveAutoPayment', [MolliePayment::class, 'saveAutoPayment'])->name('mollie.saveAutoPayment');
Route::post('mollie/prepareAutoPayment', [MolliePayment::class, 'prepareAutoPayment'])->name('mollie.prepareAutoPayment');

Route::get('mollie/returnPayment', [MollieWebhook::class, 'returnPayment'])->name('return.payment');
Route::post('mollie/webhook', [MollieWebhook::class, 'webhook'])->name('webhook.mollie');

require __DIR__.'/auth.php';
