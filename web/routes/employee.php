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

Route::get('/dashboard', function () {
    return view('employee.dashboard');
})->middleware(['auth:employee'])->name('dashboard');


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

//AttendanceContorollerに関するルーティング
Route::get('/top1', [AttendanceContoroller::class, 'index'])->middleware(['auth:employee'])->name('work');;

//DailyContorollerに関するルーティング
Route::get('/top2', [DailyController::class, 'index'])->middleware(['auth:employee'])->name('daily');;

//DailyContorollerに関するルーティング
//月別一覧へのroute
Route::get('/monthly', [MenuController::class, 'monthly'])->middleware(['auth:employee'])->name('monthly');
//部下一覧へのroute
Route::get('/subord', [MenuController::class, 'subord'])->middleware(['auth:employee'])->name('subord');

//パスワード変更
Route::get('/change_password', [NewPasswordController::class, 'create'])
    ->middleware(['auth:employee'])
    ->name('change_password');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->middleware(['auth:employee'])
    ->name('password.update');
