<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Libraries\php\Domain\DataBase;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;
use App\Models\Employee;

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

        return view('admin.dashboard', compact(
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
        // 管理者リスト
        $subord_authority_lists = DataBase::getSubordAuthority();
        return view('menu.admin.store', compact(
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

        // 人員を登録
        DataBase::insertEmployee($emplo_id, $name, $password, $management_emplo_id, $subord_authority);

        // 就業時間を登録
        DataBase::insertOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time);

        //階層に登録
        DataBase::insertHierarchy($emplo_id, $management_emplo_id);

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
        $emplo_id = $request->emplo_id;
        $employee_lists = DataBase::SelectEmployee($emplo_id);
        $subord_authority_lists = DataBase::getSubordAuthority();

        return view('menu.admin.detail', compact(
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
        return view('menu.admin.advanced');
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

        // 人員を更新
        DataBase::updateEmployee($emplo_id, $name, $management_emplo_id, $subord_authority);

        // 就業時間を更新
        DataBase::updateOverTime($emplo_id, $restraint_start_time, $restraint_closing_time, $restraint_total_time);

        //階層に更新
        DataBase::updateHierarchy($management_emplo_id, $emplo_id);

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
        $emplo_id = $request->emplo_id;
        $employee_lists = DataBase::SelectEmployee($emplo_id);

        //リダイレクト
        return view('menu.admin.delete', compact(
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
        //参照：https://nekoroblog.com/sql-delete/
        // https://laraweb.net/practice/10618/
        $retirement_authority = "1";
        DataBase::retirementAssignment($retirement_authority, $emplo_id);

        // 退職日に日付を付与する
        $user = Employee::find($emplo_id);
        $user->delete();

        //リダイレクト
        return redirect()->route('admin.dashboard');
    }
}
