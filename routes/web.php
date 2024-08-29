<?php

use \App\Livewire\Admin\UserTable;
use App\Livewire\Users\UserTab;
use App\Livewire\Users\UserSelect;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::middleware('auth')->group(function () {
    Route::get('/admin-dashboard', App\Livewire\Admin\Dashboard::class)->name('admin-dashboard');
    Route::get('/dashboard', Dashboard::class)->name('dashboard');

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
require __DIR__.'/auth.php';
