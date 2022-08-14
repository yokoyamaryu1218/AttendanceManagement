<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employee\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Employee\Auth\NewPasswordController;
use App\Http\Controllers\AttendanceContoroller;
use App\Http\Controllers\MonthlyController;
use App\Http\Controllers\PasswordChangeController;

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

// 初期画面(ログイン画面)
Route::get('/', [AuthenticatedSessionController::class, 'create'])
    ->middleware('guest')
    ->name('login');

Route::post('/', [AuthenticatedSessionController::class, 'store'])
    ->middleware('guest');
// 初期画面ここまで

Route::group(['middleware' => 'auth:employee'], function () {
    // ログアウト処理
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->middleware('auth:employee')
        ->name('logout');
    // ログアウト処理ここまで

    // ダッシュボード表示に関するルーティング
    // ログイン直後のTOP
    Route::get('/dashboard', [AttendanceContoroller::class, 'index'])
        ->name('dashboard');

    // 出勤登録
    Route::post('/dashboard/starttime/store', [AttendanceContoroller::class, 'start_time_store'])
        ->name('start_time_store');

    // 退勤処理
    Route::post('/dashboard/closingtime/store', [AttendanceContoroller::class, 'closing_time_store'])
        ->name('closing_time_store');

    // 日報登録
    Route::post('/dashboard/daily/store', [AttendanceContoroller::class, 'daily_store'])
        ->name('daily.store');

    // 日報更新
    Route::post('/dashboard/daily/update', [AttendanceContoroller::class, 'daily_update'])
        ->name('daily.update');
    // ダッシュボード表示に関するルーティングここまで

    // 自分自身の勤怠一覧表示に関するルーティング
    // 勤怠一覧表示
    Route::get('/monthly/{id}/{id2}', [MonthlyController::class, 'index'])
        ->name('monthly');

    // プルダウンで月度を変える処理
    Route::post('/monthly/change/{id}/{id2}', [MonthlyController::class, 'store'])
        ->name('monthly_change');

    // バリエーションエラーを表示するための記載
    Route::get('/monthly/change/{id}/{id2}', [MonthlyController::class, 'store'])
        ->name('monthly_change');

    // 勤怠絞り込み
    Route::post('/monthly/search/{id}/{id2}', [MonthlyController::class, 'search'])
        ->name('monthly_search');

    // バリエーションエラーを表示するための記載
    Route::get('/monthly/search/{id}/{id2}', [MonthlyController::class, 'search'])
        ->name('monthly_search');

    //　自分自身の勤怠一覧表示に関するルーティングここまで

    // 部下の勤怠一覧表示やパスワード変更に関するルーティング
    // 部下一覧を表示
    Route::get('/subord', [AttendanceContoroller::class, 'subord_index'])
        ->name('subord');

    // 部下の勤怠一覧を表示
    Route::post('/subord/monthly/{id}/{id2}', [MonthlyController::class, 'index'])
        ->name('subord_monthly');

    // バリエーションエラーを表示するための記載
    Route::get('/subord/monthly/{id}/{id2}', [MonthlyController::class, 'index'])
        ->name('subord_monthly');

    // 部下の勤怠内容を変更する処理
    Route::post('subord/monthly/update', [MonthlyController::class, 'update'])
        ->name('subord_monthly.update');

    // 部下のパスワード変更画面の表示
    Route::get('subord/change_password/{id}/{id2}', [PasswordChangeController::class, 'index'])
        ->name('subord.change_password');

    // パスワード変更後に同じ画面へ遷移するための記載
    Route::post('subord/change_password', [PasswordChangeController::class, 'index'])
        ->name('subord.change_password');

    // パスワード変更処理の実行
    Route::post('subord/reset-password', [PasswordChangeController::class, 'store'])
        ->name('subord.password.update');

    // 自分自身のパスワード変更に関するルーティング
    // パスワード変更画面の表示
    Route::get('/change_password', [NewPasswordController::class, 'create'])
        ->name('change_password');

    // パスワード変更処理の実行
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
    // 自分自身のパスワード変更に関するルーティングここまで

    // エラーページの表示
    Route::get('/error', [MonthlyController::class, 'errorMsg'])
        ->name('error');
    // エラーページここまで
});
