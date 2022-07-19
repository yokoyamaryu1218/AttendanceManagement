<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Employee\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Employee\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Employee\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Employee\Auth\NewPasswordController;
use App\Http\Controllers\Employee\Auth\PasswordResetLinkController;
use App\Http\Controllers\Employee\Auth\RegisteredUserController;
use App\Http\Controllers\Employee\Auth\VerifyEmailController;
use App\Http\Controllers\AttendanceContoroller;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MonthlyController;

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


Route::get('/dashboard', [AttendanceContoroller::class, 'index'])
    ->middleware(['auth:employee'])
    ->name('dashboard');

Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

// Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
//     ->middleware('guest')
//     ->name('password.reset');

// Route::post('/reset-password', [NewPasswordController::class, 'store'])
//     ->middleware('guest')
//     ->name('password.update');

Route::get('/verify-email', [EmailVerificationPromptController::class, '__invoke'])
    ->middleware('auth:employee')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth:employee', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:employee', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth:employee')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth:employee');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:employee')
    ->name('logout');

Route::get('/dashboard', [AttendanceContoroller::class, 'index'])
    ->middleware(['auth:employee'])
    ->name('dashboard');

Route::post('/dashboard/daily/store', [AttendanceContoroller::class, 'daily_store'])
    ->middleware(['auth:employee'])
    ->name('daily.store');

Route::post('/dashboard/daily/update', [AttendanceContoroller::class, 'daily_update'])
    ->middleware(['auth:employee'])
    ->name('daily.update');

Route::post('/dashboard/starttime/store', [AttendanceContoroller::class, 'start_time_store'])
    ->middleware(['auth:employee'])
    ->name('start_time_store');

Route::post('/dashboard/endtime/store', [AttendanceContoroller::class, 'end_time_store'])
    ->middleware(['auth:employee'])
    ->name('end_time_store');

Route::group(['middleware' => 'auth:employee'], function () {
    //月別一覧へのroute
    Route::get('/monthly', [MonthlyController::class, 'index'])->name('monthly');
    Route::post('/monthly/change', [MonthlyController::class, 'store'])->name('monthly_change');
    //部下一覧へのroute
    Route::get('/subord', [MenuController::class, 'subord'])->name('subord');

    //パスワード変更
    Route::get('/change_password', [NewPasswordController::class, 'create'])
        ->name('change_password');

    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
});
