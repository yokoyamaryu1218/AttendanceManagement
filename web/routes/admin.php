<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Admin\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Admin\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\Admin\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminMonthlyController;

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

// Route::get('/dashboard', function () {
//     return view('admin.dashboard');
// })->middleware(['auth:admin'])->name('dashboard');

Route::get('/dashboard', [AdminController::class, 'index'])
    ->middleware(['auth:admin'])
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
    ->middleware('auth:admin')
    ->name('verification.notice');

Route::get('/verify-email/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->middleware(['auth:admin', 'signed', 'throttle:6,1'])
    ->name('verification.verify');

Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
    ->middleware(['auth:admin', 'throttle:6,1'])
    ->name('verification.send');

Route::get('/confirm-password', [ConfirmablePasswordController::class, 'show'])
    ->middleware('auth:admin')
    ->name('password.confirm');

Route::post('/confirm-password', [ConfirmablePasswordController::class, 'store'])
    ->middleware('auth:admin');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth:admin')
    ->name('logout');


//従業員一覧へのroute
Route::get('/detail', [AdminController::class, 'show'])
    ->middleware(['auth:admin'])
    ->name('emplo_details');
Route::post('/detail', [AdminController::class, 'show'])
    ->middleware(['auth:admin'])
    ->name('emplo_details');

// 退職者一覧へのroute
Route::get('/retirement', [AdminController::class, 'retirement'])
    ->middleware(['auth:admin'])
    ->name('retirement');

//復職画面へのroute
Route::get('/detail/retirement', [AdminController::class, 'reinstatement_check'])
    ->middleware(['auth:admin'])
    ->name('reinstatement_check');

//復職処理実行のroute
Route::post('/detail/retirement/action', [AdminController::class, 'reinstatement_action'])
    ->middleware(['auth:admin'])
    ->name('reinstatement_action');

//退職画面へのroute
Route::get('/detail/delete', [AdminController::class, 'destroy_check'])
    ->middleware(['auth:admin'])
    ->name('destroy_check');

//退職処理実行のroute
Route::post('/detail/delete/action', [AdminController::class, 'destroy'])
    ->middleware(['auth:admin'])
    ->name('destroy');

// 従業員新規登録へのroute
Route::get('/create', [AdminController::class, 'create'])
    ->middleware(['auth:admin'])
    ->name('emplo_create');

Route::post('/store', [AdminController::class, 'store'])
    ->middleware(['auth:admin'])
    ->name('emplo_store');

// 従業員の登録情報更新のroute
Route::post('/update', [AdminController::class, 'update'])
    ->middleware(['auth:admin'])
    ->name('emplo_update');

// 詳細設定へのroutei
Route::get('/advanced', [AdminController::class, 'advanced_show'])
    ->middleware(['auth:admin'])
    ->name('advanced');

//部下の勤怠一覧へのroute
Route::post('/monthly', [AdminMonthlyController::class, 'index'])
    ->name('monthly');
Route::get('/monthly', [AdminMonthlyController::class, 'index'])
    ->name('monthly');

//月度を変えたときのroute
Route::post('/monthly/change', [AdminMonthlyController::class, 'store'])
    ->name('monthly_change');
Route::get('/monthly/change', [AdminMonthlyController::class, 'store'])
    ->name('monthly_change');

//部下の勤怠修正のroute
Route::post('monthly/update', [AdminMonthlyController::class, 'update'])
    ->name('monthly.update');

//従業員のパスワード変更へのroute
Route::get('/change_password', [AdminController::class, 'password_create'])
    ->name('change_password');
Route::post('/change_password', [AdminController::class, 'password_create'])
    ->name('change_password');
Route::post('/reset-password', [AdminController::class, 'password_store'])
    ->name('password.update');

//パスワード変更
Route::get('/change_password', [NewPasswordController::class, 'create'])
    ->name('change_password');
Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');
