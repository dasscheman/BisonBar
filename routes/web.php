<?php

use App\Http\Livewire\Admin\AssortmentManagement;
use App\Http\Livewire\Admin\ExpensesManagement;
use App\Http\Livewire\Admin\InvoicesManagement;
use App\Http\Livewire\Admin\PaymentManagement;
use App\Http\Livewire\Admin\TallyManagement;
use Illuminate\Support\Facades\Route;

use App\Http\Livewire\Auth\ForgotPassword;
use App\Http\Livewire\Auth\ResetPassword;
use App\Http\Livewire\Auth\SignUp;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Dashboard;
use App\Http\Livewire\Billing;
use App\Http\Livewire\Profile;
use App\Http\Livewire\Tables;
use App\Http\Livewire\StaticSignIn;
use App\Http\Livewire\StaticSignUp;
use App\Http\Livewire\Rtl;

use App\Http\Livewire\Users\UserProfile;
use App\Http\Livewire\Users\UserManagement;
use App\Http\Livewire\Users\UserSelect;

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function() {
    return redirect('/login');
});

Route::get('/sign-up', SignUp::class)->name('sign-up');
Route::get('/login', Login::class)->name('login');

Route::get('/login/forgot-password', ForgotPassword::class)->name('forgot-password');

Route::get('/reset-password/{id}',ResetPassword::class)->name('reset-password')->middleware('signed');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/billing', Billing::class)->name('billing');
    Route::get('/profile', Profile::class)->name('profile');
    Route::get('/tables', Tables::class)->name('tables');
    Route::get('/static-sign-in', StaticSignIn::class)->name('sign-in');
    Route::get('/static-sign-up', StaticSignUp::class)->name('static-sign-up');
    Route::get('/rtl', Rtl::class)->name('rtl');
    Route::get('/user-profile/{user?}', UserProfile::class)->name('user-profile');
    Route::get('/user-select/{user}', UserSelect::class)->name('user-select');
    Route::get('/user-management', UserManagement::class)->name('user-management');
    Route::get('/assortment-management', AssortmentManagement::class)->name('assortment-management');
    Route::get('/expenses-management', ExpensesManagement::class)->name('expenses-management');
    Route::get('/invoices-management', InvoicesManagement::class)->name('invoices-management');
    Route::get('/payment-management', PaymentManagement::class)->name('payment-management');
    Route::get('/tally-management', TallyManagement::class)->name('tally-management');
});

