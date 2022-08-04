<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use App\Libraries\php\Domain\Format;
use App\Libraries\php\Domain\Time;

// 勤怠一覧のコントローラー
class MonthlyController extends Controller
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
    public function index(Request $request)
    {
        if ($request->subord_id) {
            $emplo_id = $request->subord_id;
        } else {
            $emplo_id = Auth::guard('employee')->user()->emplo_id;
        };


        if ($request->subord_name) {
            $emplo_name = $request->subord_name;
        } else {
            $emplo_name = Auth::guard('employee')->user()->name;
        };

        $format = new Format();
        $ym = $format->to_monthly();
        $day_count = date('t', strtotime($ym));
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);

        return view('menu.monthly.monthly', compact(
            'monthly_data',
            'day_count',
            'emplo_id',
            'emplo_name',
            'ym',
            'format'
        ));
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
        $emplo_id = $request->emplo_id;
        $emplo_name = $request->emplo_name;

        if (isset($request->monthly_change)) {
            $ym = $request->monthly_change;
            $day_count = date('t', strtotime($ym));
        } else {
            $ym = date('Y-m');
            $day_count = date('t');
        }

        $monthly_data = DataBase::getMonthly($emplo_id, $ym);
        $format = new Format();

        return view('menu.monthly.monthly', compact(
            'monthly_data',
            'day_count',
            'emplo_name',
            'emplo_id',
            'ym',
            'format'
        ));
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
            //休憩時間を求めるため、総勤務時間を求める
            $cloumns_name = 'restraint_start_time';
            $restraint_start_time = Database::getOverTime($cloumns_name,$emplo_id);

            $cloumns_name = 'restraint_total_time';
            $restraint_total_time = Database::getOverTime($cloumns_name,$emplo_id);

            $total_time = Time::total_time($start_time, $closing_time, $restraint_start_time[0]->restraint_start_time);

            //休憩時間を求める
            $rest_time = Time::rest_time($total_time);

            //実績時間を求める
            $achievement_time = Time::achievement_time($total_time, $rest_time);

            // 残業時間を求める
            $over_time = Time::over_time($achievement_time, $restraint_total_time[0]->restraint_total_time);

            // データベースに登録する
            DataBase::updateTime($start_time, $closing_time, $rest_time, $achievement_time, $over_time, $emplo_id, $target_date);
            if ($daily_data == NULL) {
                DataBase::insertDaily($emplo_id, $target_date, $daily);
            }
            DataBase::updateDaily($emplo_id, $target_date, $daily);

            return redirect()->route('employee.subord')->with('status', '変更しました');
        } else {
            //休憩時間を求めるため、総勤務時間を求める
            $cloumns_name = 'restraint_start_time';
            $restraint_start_time = Database::getOverTime($cloumns_name,$emplo_id);

            $cloumns_name = 'restraint_total_time';
            $restraint_total_time = Database::getOverTime($cloumns_name,$emplo_id);

            $total_time = Time::total_time($start_time, $closing_time, $restraint_start_time[0]->restraint_start_time);

            //休憩時間を求める
            $rest_time = Time::rest_time($total_time);

            //実績時間を求める
            $achievement_time = Time::achievement_time($total_time, $rest_time);

            // 残業時間を求める
            $over_time = Time::over_time($achievement_time, $restraint_total_time[0]->restraint_total_time);

            // データベースに登録する
            DataBase::insertTime($emplo_id, $target_date, $start_time, $closing_time, $rest_time, $achievement_time, $over_time);
            if ($daily_data == NULL) {
                DataBase::insertDaily($emplo_id, $target_date, $daily);
            }
            DataBase::updateDaily($emplo_id, $target_date, $daily);

            return redirect()->route('employee.subord')->with('status', '新規登録しました');
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
