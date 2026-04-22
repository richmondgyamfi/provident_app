<?php

// use App\Http\Controllers\AuthController;

use App\Http\Controllers\Admin\LoanController;
use App\Http\Controllers\Admin\LoanRepaymentUploadController;
use App\Http\Controllers\Admin\WithdrawalController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PayrollUploadController;
use Illuminate\Support\Facades\Route;

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback']);

Route::get('/register', function () {
    return view('register');
});

Route::get('/', function () {
    return view('login');
})->name('login');

// Route::get('/login', function () {
//     return redirect('/auth/google');
// })->name('login');

// Route::get('/login', function () {
//     return view('login');
// });

// check if authenticated access dashboard
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');

    // route to members dashboard
    Route::get('/dashboard', [MemberController::class, 'index'])->name('dashboard');
    Route::get('/loan-application', [MemberController::class, 'loanApplication'])->name('loan-application');
    Route::post('/loans', [MemberController::class, 'storeLoan'])->name('loans.store');

    Route::get('/staff-statement', function () {
        return view('members.staff-statement');
    })->name('staff-statement');

    Route::get('admin/staff-contribution', function () {
        return view('admin.staff-contribution');
    })->name('staff-contribution');

    Route::get('/withdrawal-request', [MemberController::class, 'withdrawalRequest'])->name('withdrawal-request');
    Route::post('/withdrawals', [MemberController::class, 'storeWithdrawal'])->name('withdrawals.store');

    // Route::get('/payroll-contribution', [ContributionController::class, 'create'])->name('payroll-contribution');
    Route::get('/payroll-contribution', [ContributionController::class, 'create'])->name('payroll-contribution.create');
    Route::get('/payroll-contribution/{contribution}/edit', [ContributionController::class, 'edit'])->name('payroll-contribution.edit');

    Route::resource('payroll-uploads', PayrollUploadController::class);

    Route::get('/admin/payroll/template', [PayrollUploadController::class, 'downloadTemplate'])->name('payroll.template.download');

    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin-dashboard');
        Route::get('/loans', [LoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/{loan}', [LoanController::class, 'show'])->name('loans.show');
        Route::patch('/loans/{loan}/status', [LoanController::class, 'approve'])->name('loans.approve');
        Route::get('/loans/{loan}/repayment/create', [LoanController::class, 'createRepayment'])->name('loans.repayment.create');
        Route::post('/loans/{loan}/repayment', [LoanController::class, 'storeRepayment'])->name('loans.repayment.store');
        Route::get('/membership-form-admin', [MemberController::class, 'membershipform_admin'])->name('membership-form-admin');
        Route::post('/membership-form-admin', [MemberController::class, 'store_admin'])->name('membership-form-admin.store');

        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [WithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::patch('/withdrawals/{withdrawal}/status', [WithdrawalController::class, 'updateStatus'])->name('withdrawals.update-status');

        Route::resource('loan-repayment-uploads', LoanRepaymentUploadController::class);
        Route::get('/loan-repayments/template', [LoanRepaymentUploadController::class, 'downloadTemplate'])->name('loan-repayments.template.download');

    });

    // Route::get('/membership-form', function () {
    //     return view('members.membership-form');
    // })->name('membership-form');
    Route::resource('contributions', ContributionController::class);

    Route::get('membership-form', [MemberController::class, 'membershipform'])->name('membership-form');

    Route::resource('members', MemberController::class);

    Route::get('/logout', [GoogleController::class, 'logout'])->name('logout');

});

// Route::get('/register',[AuthController::class,'register'])->name('register');
// Route::get('/register',[AuthController::class,'register'])->name('register');
