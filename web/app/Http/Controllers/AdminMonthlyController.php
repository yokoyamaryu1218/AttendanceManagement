<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use App\Libraries\php\Domain\Format;
use App\Libraries\php\Domain\Time;

// 勤怠一覧のコントローラー
class AdminMonthlyController extends Controller
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
    public function index(Request $request)
    {
        $emplo_id = $request->emplo_id;
        $name = $request->name;

        $format = new Format();
        $ym = $format->to_monthly();
        $day_count = date('t', strtotime($ym));
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);

        return view('menu.monthly.monthly2', compact(
            'monthly_data',
            'day_count',
            'emplo_id',
            'name',
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
        $name = $request->name;

        if (isset($request->monthly_change)) {
            $ym = $request->monthly_change;
            $day_count = date('t', strtotime($ym));
        } else {
            $ym = date('Y-m');
            $day_count = date('t');
        }

        $monthly_data = DataBase::getMonthly($emplo_id, $ym);
        $format = new Format();

        return view('menu.monthly.monthly2', compact(
            'monthly_data',
            'day_count',
            'emplo_id',
            'name',
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
            Time::updateTime($emplo_id, $start_time, $closing_time, $target_date, $daily, $daily_data);
            return redirect()->route('admin.monthly', compact('emplo_id', 'name',))->with('status', '変更しました');
        } else {
            Time::insertTime($emplo_id, $start_time, $closing_time, $target_date, $daily, $daily_data);
            return redirect()->route('admin.monthly', compact('emplo_id', 'name',))->with('status', '新規登録しました');
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
