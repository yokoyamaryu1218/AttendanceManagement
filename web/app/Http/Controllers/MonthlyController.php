<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use App\Libraries\php\Domain\Common;
use App\Libraries\php\Domain\Time;

// 勤怠一覧のコントローラー
class MonthlyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::guard('employee')->check()) {
            // 従業員のIDの取得
            if ($request->subord_id) {
                // 部下一覧からのアクセスの場合、部下のIDを取得
                $emplo_id = $request->subord_id;
            } elseif ($request->emplo_id) {
                // 勤怠修正をした場合、修正した社員のIDを取得
                $emplo_id = $request->emplo_id;
            } else {
                //　自分自身の勤怠を見る場合、自分のIDを取得
                $emplo_id = Auth::guard('employee')->user()->emplo_id;
            };
        } elseif (Auth::guard('admin')->check()) {
            // 従業員情報の取得
            $emplo_id = $request->emplo_id;
        }

        if (Auth::guard('employee')->check()) {
            // 従業員の名前を取得
            if ($request->subord_name) {
                // 部下一覧からのアクセスの場合、部下の名前を取得
                $name = $request->subord_name;
            } elseif ($request->name) {
                // 勤怠修正をした場合、修正した社員の名前を取得
                $name = $request->name;
            } else {
                //　自分自身の勤怠を見る場合、自分の名前を取得
                $name = Auth::guard('employee')->user()->name;
            };
        } elseif (Auth::guard('admin')->check()) {
            //従業員の名前を取得
            $name = $request->name;
        }

        // 今月の年月を表示
        $format = new Common();
        $ym = $format->to_monthly();
        // 月の日数を取得
        $day_count = date('t', strtotime($ym));
        // 今月の従業員の勤怠一覧を取得
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);

        if (Auth::guard('employee')->check()) {
            return view('menu.attendance.attendance01', compact(
                'monthly_data',
                'day_count',
                'emplo_id',
                'name',
                'ym',
                'format'
            ));
        } elseif (Auth::guard('admin')->check()) {
            return view('menu.attendance.attendance02', compact(
                'monthly_data',
                'day_count',
                'emplo_id',
                'name',
                'ym',
                'format'
            ));
        }
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // 従業員情報の取得
        $emplo_id = $request->emplo_id;
        $name = $request->name;

        // プルダウンで選んだ年月と月数の取得
        if (isset($request->monthly_change)) {
            $ym = $request->monthly_change;
            $day_count = date('t', strtotime($ym));
        } else {
            $ym = date('Y-m');
            $day_count = date('t');
        }

        // 勤怠一覧の取得
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);
        // フォーマットの取得
        $format = new Common();

        if (Auth::guard('employee')->check()) {
            return view('menu.attendance.attendance01', compact(
                'monthly_data',
                'day_count',
                'name',
                'emplo_id',
                'ym',
                'format'
            ));
        } elseif (Auth::guard('admin')->check()) {
            return view('menu.attendance.attendance02', compact(
                'monthly_data',
                'day_count',
                'emplo_id',
                'name',
                'ym',
                'format'
            ));
        }
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
     * 部下の勤怠修正
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // リクエスト処理の取得
        $name = $request->modal_name;
        $emplo_id = $request->modal_id;
        $target_date = $request->modal_day;
        $start_time = $request->modal_start_time;
        $closing_time = $request->modal_closing_time;
        $daily = $request->modal_daily;

        // 重複クリック対策
        $request->session()->regenerateToken();

        //対象日のデータがあるかどうかチェック
        $check_date = Database::checkDate($emplo_id, $target_date);
        $daily_data = DataBase::getDaily($emplo_id, $target_date);

        if ($check_date) {
            // 対象日にデータがある場合は、更新処理を行う
            Time::updateTime($emplo_id, $start_time, $closing_time, $target_date);
            TIme::Daily($emplo_id, $target_date, $daily, $daily_data);
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', compact('emplo_id', 'name',))->with('status', '変更しました');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', compact('emplo_id', 'name',))->with('status', '変更しました');
            }
        } else {
            // 対象日にデータがない場合は、新規登録処理を行う
            Time::insertTime($emplo_id, $start_time, $closing_time, $target_date);
            Time::Daily($emplo_id, $target_date, $daily, $daily_data);
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', compact('emplo_id', 'name',))->with('status', '新規登録しました');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', compact('emplo_id', 'name',))->with('status', '新規登録しました');
            }
        }
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
