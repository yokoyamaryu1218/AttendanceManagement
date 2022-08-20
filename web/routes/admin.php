<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
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

Route::group(['middleware' => 'auth:admin'], function () {
    // ログアウト処理
    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    // ログアウト処理ここまで

    // ダッシュボード表示に関するルーティング
    // 在職の従業員の表示
    Route::get('/dashboard', [AdminController::class, 'index'])
        ->name('dashboard');
    // 検索
    Route::get('/dashboard/search/{id}', [AdminController::class, 'search']);
    Route::post('/dashboard/search/{id}', [AdminController::class, 'search'])->name('search');
    // ダッシュボード表示に関するルーティングここまで

    // 従業員新規登録に関するルーティング
    // 新規登録画面の表示
    Route::get('/create', [AdminController::class, 'create'])
        ->name('emplo_create');

    // 新規登録処理の実行
    Route::post('/store', [AdminController::class, 'store'])
        ->name('emplo_store');
    // 従業員新規登録に関するルーティングここまで

    // 従業員の詳細画面に関するルーティング
    // 選択した従業員の表示
    Route::get('/detail/{id}/{id2}', [AdminController::class, 'show'])
        ->name('emplo_details');

    Route::post('/detail/{id}/{id2}', [AdminController::class, 'show'])
        ->name('emplo_details');

    // 従業員の登録情報更新の実行
    Route::post('/detail/update', [AdminController::class, 'update'])
        ->name('details_update');
    // 従業員の詳細画面に関するルーティングここまで

    // 退職処理に関するルーティング
    // 退職確認画面の表示
    Route::get('/detail/delete/{id}/{id2}', [AdminController::class, 'destroy_check'])
        ->name('destroy_check');

    //退職処理実行
    Route::post('/detail/delete/action/{id}', [AdminController::class, 'destroy'])
        ->name('destroy');
    //退職処理に関するルーティングここまで

    // 退職者一覧に関するルーティング
    // 退職した従業員の表示
    Route::get('/retirement', [AdminController::class, 'retirement'])
        ->name('retirement');
    // 退職者一覧に関するルーティングここまで

    // 復職処理に関するルーティング
    // 復職確認画面の表示
    Route::get('/detail/retirement/{id}/{id2}', [AdminController::class, 'reinstatement_check'])
        ->name('reinstatement_check');

    // 復職処理実行
    Route::post('/detail/retirement/action/{id}', [AdminController::class, 'reinstatement_action'])
        ->name('reinstatement_action');
    // 復職処理に関するルーティングここまで

    // 選択した従業員の勤怠一覧表示に関するルーティング
    // 選択した従業員の勤怠一覧の表示
    Route::post('/monthly/{id}/{id2}', [MonthlyController::class, 'index'])
        ->name('monthly');

    // 勤怠修正後に再度勤怠一覧画面へ遷移するための記載
    Route::get('/monthly/{id}/{id2}', [MonthlyController::class, 'index'])
        ->name('monthly');

    // プルダウンで月度を変える処理
    Route::post('/monthly/change/{id}/{id2}', [MonthlyController::class, 'store'])
        ->name('monthly_change');

    // バリエーションエラーを表示するための記載
    Route::get('/monthly/change/{id}/{id2}', [MonthlyController::class, 'store'])
        ->name('monthly_change');

    // 従業員の勤怠修正処理の実行
    Route::post('monthly/update', [MonthlyController::class, 'update'])
        ->name('monthly.update');

    // 勤怠勤怠合計
    Route::post('/monthly/search/{id}/{id2}', [MonthlyController::class, 'search'])
        ->name('monthly_search');

    // バリエーションエラーを表示するための記載
    Route::get('/monthly/search/{id}/{id2}', [MonthlyController::class, 'search'])
        ->name('monthly_search');

    // 選択した従業員の勤怠一覧表示に関するルーティングここまで

    // 選択した従業員のパスワード変更に関するルーティング
    // パスワード変更画面の表示
    Route::get('/emplo/change_password', [PasswordChangeController::class, 'index'])
        ->name('emplo_change_password');

    // パスワード変更後に同じ画面へ遷移するための記載
    Route::post('/emplo/change_password', [PasswordChangeController::class, 'index'])
        ->name('emplo_change_password');

    // パスワード変更処理の実行
    Route::post('/emplo/reset-password', [PasswordChangeController::class, 'store'])
        ->name('emplo_password.update');
    // 選択した従業員のパスワード変更に関するルーティングここまで

    // 管理者自身のパスワード変更に関するルーティング
    // パスワード変更画面の表示
    Route::get('/change_password', [NewPasswordController::class, 'create'])
        ->name('change_password');

    // パスワード変更処理の実行
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.update');
    // 管理者自身のパスワード変更に関するルーティングここまで

    // エラーページの表示
    Route::get('/error', [MonthlyController::class, 'errorMsg'])
        ->name('error');
    // エラーページここまで
});
