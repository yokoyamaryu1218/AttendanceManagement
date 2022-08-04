<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

// 部下一覧のコントローラー
class SubordController extends Controller
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 自分自身の配下の部下一覧を取得する
        if (Auth::guard('employee')->user()->subord_authority == "1") {
            $emplo_id = Auth::guard('employee')->user()->emplo_id;
            $subord_data = DataBase::getSubord($emplo_id);

            return view('menu.subord.subord', compact('subord_data'));
        }
        // 部下がいない状態で部下一覧の画面に遷移しようとした場合、TOPに遷移する
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        // パスワードの変更を行う従業員情報の取得
        $subord_id = $request->subord_id;
        $subord_name = $request->subord_name;

        return view('menu.subord.change-password', compact(
            'subord_id',
            'subord_name',
        ));
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
        $subord_id = $request->subord_id;
        $subord_name = $request->subord_name;
        $password = Hash::make($request->password);
        $password_confirmation = $request->password_confirmation;

        // 新しいパスワードを確認
        if (!password_verify($request->password, password_hash($password_confirmation, PASSWORD_DEFAULT))) {
            return redirect()->route('employee.subord.change_password', compact(
                'subord_id',
                'subord_name',
            ))->with('warning', '新しいパスワードが合致しません。');
        }

        // パスワードは6文字以上あるか，2つが一致しているかなどのチェックF
        $this->validator($request->all())->validate();

        // パスワードを保存
        Database::subord_updatepassword($password, $subord_id);

        return redirect()->route('employee.subord.change_password', compact(
            'subord_id',
            'subord_name',
        ))->with('status', 'パスワードを変更しました');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
