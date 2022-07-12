<?php

namespace App\Http\Controllers\Employee\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

// パスワード変更のコントローラー
class NewPasswordController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee');
    }

    public function create()
    {
        return view('employee.auth.change-password');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    public function messages()
    {
        return [
            'password.confirmed' => '新しいパスワードが合致しません。',
            'password.min' => '新しいパスワードが6文字以下です。',
        ];
    }

    public function store(Request $request)
    {
        // 現在のパスワードを確認
        if (!password_verify($request->old_password, Auth::guard('employee')->user()->password)) {
            return redirect()->route('employee.change_password')
                ->with('warning', '現在のパスワードが違います。');
        }

        // 新しいパスワードを確認
        if (!password_verify($request->password, $request->password_confirmation)) {
            return redirect()->route('employee.change_password')
                ->with('warning', '新しいパスワードが合致しません。');
        }

        // パスワードは6文字以上あるか，2つが一致しているかなどのチェック
        $this->validator($request->all())->validate();

        // パスワードを保存
        Auth::guard('employee')->user()->password = bcrypt($request->password);
        Auth::guard('employee')->user()->save();
        return redirect()->route('employee.change_password')
            ->with('status', 'パスワードを変更しました');
    }
}
