<?php

use \App\Livewire\Admin\UserTable;
use App\Livewire\Users\UserProfile;
use App\Livewire\Users\UserSelect;
use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');


Route::middleware('auth')->group(function () {
//    Route::view('dashboard', 'dashboard')
//        ->middleware(['auth', 'verified'])
//        ->name('dashboard');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

//    Route::view('profile', 'profile')
//        ->middleware(['auth'])
//        ->name('profile');

//    Route::get('/users', function ($title) {
//        return view('livewire.admin.users.index', compact($title));
//    })->name('users');

    Route::get('/user/{user}', function (App\Models\User $user) {
        return view('livewire.admin.users.details', compact('user'));
    })->name('userdetails');





    Route::get('/user-profile/{user?}', UserProfile::class)->name('user-profile');
    Route::get('/user-select/{user}', UserSelect::class)->name('user-select');
    Route::get('/users', UserTable::class)->name('users');
//    Route::get('/assortment-management', AssortmentManagement::class)->name('assortment-management');
//    Route::get('/expenses-management', ExpensesManagement::class)->name('expenses-management');
//    Route::get('/invoices-management', InvoicesManagement::class)->name('invoices-management');
//    Route::get('/payment-management', PaymentManagement::class)->name('payment-management');
//    Route::get('/tally-management', TallyManagement::class)->name('tally-management');

});
require __DIR__.'/auth.php';
