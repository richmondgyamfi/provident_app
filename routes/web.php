<?php

// use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\ContributionController;
use App\Http\Controllers\MemberController;

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

//check if authenticated access dashboard
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [GoogleController::class, 'logout'])->name('logout');
    
    //route to members dashboard
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

    Route::get('/payroll-contribution', [ContributionController::class, 'create'])->name('payroll-contribution.create');
    Route::get('/payroll-contribution/{contribution}/edit', [ContributionController::class, 'edit'])->name('payroll-contribution.edit');
    
    Route::resource('payroll-uploads', \App\Http\Controllers\PayrollUploadController::class);
    
    Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {
        Route::get('/loans', [\App\Http\Controllers\Admin\LoanController::class, 'index'])->name('loans.index');
        Route::get('/loans/{loan}', [\App\Http\Controllers\Admin\LoanController::class, 'show'])->name('loans.show');
        Route::patch('/loans/{loan}/status', [\App\Http\Controllers\Admin\LoanController::class, 'approve'])->name('loans.approve');
        Route::get('/loans/{loan}/repayment/create', [\App\Http\Controllers\Admin\LoanController::class, 'createRepayment'])->name('loans.repayment.create');
        Route::post('/loans/{loan}/repayment', [\App\Http\Controllers\Admin\LoanController::class, 'storeRepayment'])->name('loans.repayment.store');
        
        Route::get('/withdrawals', [\App\Http\Controllers\Admin\WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/{withdrawal}', [\App\Http\Controllers\Admin\WithdrawalController::class, 'show'])->name('withdrawals.show');
        Route::patch('/withdrawals/{withdrawal}/status', [\App\Http\Controllers\Admin\WithdrawalController::class, 'updateStatus'])->name('withdrawals.update-status');
    });

    Route::get('/admin-dashboard', [\App\Http\Controllers\AdminDashboardController::class, 'index'])->name('admin-dashboard');

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




