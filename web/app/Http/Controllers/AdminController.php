<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Employee;
use App\Libraries\php\Domain\Common;

// 管理者画面用のコントローラー
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 在職者だけを表示するため、退職フラグに0を付与
        $retirement_authority = "0";
        $employee_lists = DataBase::getEmployeeAll($retirement_authority);

        // 退職者がいる場合、退職者一覧のリンクを表示するため、退職者リストも取得する
        $retirement_authority = "1";
        $retirement_lists = DataBase::getEmployeeAll($retirement_authority);

        return view('admin.dashboard', compact(
            'employee_lists',
            'retirement_lists',
        ));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function retirement()
    {
        // 退職者だけを表示するため、退職フラグに1を付与
        $retirement_authority = "1";
        $employee_lists = DataBase::getEmployeeAll($retirement_authority);

        return view('menu.emplo_detail.emplo_detail06', compact(
            'employee_lists',
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 管理者リストの取得
        $subord_authority_lists = DataBase::getSubordAuthority();
        return view('menu.emplo_detail.emplo_detail03', compact(
            'subord_authority_lists',
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //リクエストの取得
        $name = $request->name;
        $password = Hash::make($request->password);
        $management_emplo_id = $request->management_emplo_id;
        $restraint_start_time = $request->restraint_start_time;
        $restraint_closing_time = $request->restraint_closing_time;
        $restraint_total_time = $request->restraint_total_time;
        $retirement_authority = "0";

        // トグルがONになっている場合は1、OFFの場合は0
        if (is_null($request->subord_authority)) {
            $subord_authority = "0";
        } else {
            $subord_authority = $request->subord_authority;
        };

        //登録する番号を作成
        $id = DataBase::getID();
        $emplo_id = $id[0]->emplo_id + "1";

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 情報を登録
        Common::insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority, $retirement_authority,
        $restraint_start_time, $restraint_closing_time, $restraint_total_time);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        // 詳細画面の情報取得
        $emplo_id = $request->emplo_id;
        $retirement_authority = $request->retirement_authority;
        $employee_lists = DataBase::SelectEmployee($emplo_id, $retirement_authority);
        // 管理者リストの取得
        $subord_authority_lists = DataBase::getSubordAuthority();

        return view('menu.emplo_detail.emplo_detail01', compact(
            'employee_lists',
            'subord_authority_lists',
        ));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function advanced_show()
    {
        // 就業規則の表示
        return view('menu.another.advanced');
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
    public function update(Request $request)
    {
        //リクエストの取得
        $emplo_id = $request->emplo_id;
        $name = $request->name;
        $management_emplo_id = $request->management_emplo_id;
        $restraint_start_time = $request->restraint_start_time;
        $restraint_closing_time = $request->restraint_closing_time;
        $restraint_total_time = $request->restraint_total_time;

        // トグルがONになっている場合は1、OFFの場合は0
        if (is_null($request->subord_authority)) {
            $subord_authority = "0";
        } elseif ($request->subord_authority = "on") {
            $subord_authority = "1";
        } else {
            $subord_authority = $request->subord_authority;
        };

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 情報を更新
        Common::updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority, $restraint_start_time,
        $restraint_closing_time, $restraint_total_time);

        return redirect()->route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reinstatement_check(Request $request)
    {
        // 復職者処理を行う従業員の詳細取得
        $emplo_id = $request->emplo_id;
        $retirement_authority = $request->retirement_authority;
        $employee_lists = DataBase::SelectEmployee($emplo_id, $retirement_authority);

        //リダイレクト
        return view('menu.emplo_detail.emplo_detail06', compact(
            'employee_lists',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function reinstatement_action(Request $request)
    {
        //リクエストの取得
        $emplo_id = $request->emplo_id;

        //退職フラグに0を付与する
        $retirement_authority = "0";
        DataBase::retirementAssignment($retirement_authority, $emplo_id);

        // 退職日をNULLにする
        DataBase::Delete_at($emplo_id);

        //リダイレクト
        return redirect()->route('admin.dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy_check(Request $request)
    {
        // 退職処理を行う従業員の情報取得
        $emplo_id = $request->emplo_id;
        $retirement_authority = $request->retirement_authority;
        $employee_lists = DataBase::SelectEmployee($emplo_id, $retirement_authority);

        //リダイレクト
        return view('menu.emplo_detail.emplo_detail04', compact(
            'employee_lists',
        ));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //リクエストの取得
        $emplo_id = $request->emplo_id;

        //退職フラグに1を付与する
        $retirement_authority = "1";
        DataBase::retirementAssignment($retirement_authority, $emplo_id);

        // 退職日に日付を付与する
        $user = Employee::find($emplo_id);
        $user->delete();

        //リダイレクト
        return redirect()->route('admin.dashboard');
    }
}
