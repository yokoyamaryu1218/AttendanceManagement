<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Database;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Rules\PasswordRule;

// 従業員（部下）のパスワードを変更するコントローラー
class PasswordChangeController extends Controller
{
    /**
     * パスワード変更画面の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $name 社員名
     */
    public function index(Request $request)
    {
        // パスワードの変更を行う従業員情報の取得
        $emplo_id = $request->emplo_id;
        $name = $request->name;

        if (Auth::guard('employee')->check()) {
            return view('menu.password.subord-password', compact(
                'emplo_id',
                'name',
            ));
        } elseif (Auth::guard('admin')->check()) {
            return view('menu.password.emplo-password', compact(
                'emplo_id',
                'name',
            ));
        };
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            // reget:英数字混合を指定
            'password' => ['required', 'string', 'min:8', new PasswordRule, 'confirmed'],
        ]);
    }

    /**
     * パスワードの変更の実行
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $name 社員名
     * @var string $password パスワード
     * @var string $password_cofirmation パスワード確認用
     * @var App\Libraries\php\Domain\Database
     */
    public function store(Request $request)
    {
        // リクエストの取得
        $emplo_id = $request->emplo_id;
        $name = $request->name;
        $password = Hash::make($request->password);
        $password_confirmation = $request->password_confirmation;

        // パスワードは6文字以上あるか，2つが一致しているかなどのチェック
        $this->validator($request->all())->validate();

        // パスワードを保存
        try {
            Database::subord_updatepassword($password, $emplo_id);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

        if (Auth::guard('employee')->check()) {
            $message = "パスワードを変更しました";
            return redirect()->route('employee.subord.change_password', compact(
                'emplo_id',
                'name',
            ))->with('status', $message);
        } elseif (Auth::guard('admin')->check()) {
            $message = "パスワードを変更しました";
            return redirect()->route('admin.emplo_change_password', compact(
                'emplo_id',
                'name',
            ))->with('status', $message);
        }
    }
}
