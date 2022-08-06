<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

// 従業員（部下）のパスワードを変更するコントローラー
class PasswordChangeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
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
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // リクエストの取得
        $emplo_id = $request->emplo_id;
        $name = $request->name;
        $password = Hash::make($request->password);
        $password_confirmation = $request->password_confirmation;

        // 新しいパスワードを確認
        if (!password_verify($request->password, password_hash($password_confirmation, PASSWORD_DEFAULT))) {
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.subord.change_password', compact(
                    'emplo_id',
                    'name',
                ))->with('warning', '新しいパスワードが合致しません。');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.emplo_change_password', compact(
                    'emplo_id',
                    'name',
                ))->with('warning', '新しいパスワードが合致しません。');
            }
        }

        // パスワードは6文字以上あるか，2つが一致しているかなどのチェック
        $this->validator($request->all())->validate();

        // パスワードを保存
        Database::subord_updatepassword($password, $emplo_id);

        if (Auth::guard('employee')->check()) {
            return redirect()->route('employee.subord.change_password', compact(
                'emplo_id',
                'name',
            ))->with('status', 'パスワードを変更しました');
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.emplo_change_password', compact(
                'emplo_id',
                'name',
            ))->with('status', 'パスワードを変更しました');
        }
    }
}