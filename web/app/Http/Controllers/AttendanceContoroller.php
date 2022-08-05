<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\Common;
use App\Libraries\php\Domain\DataBase;
use App\Libraries\php\Domain\Time;

// ホーム画面のコントローラー
class AttendanceContoroller extends Controller
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
        // 今日の日付 フォーマット
        $today = date('Y-m-j');
        $format = new Common();
        $ym = $format->top_monthly();

        // 参照先：https://on-ze.com/archives/1838
        $time = intval(date('H'));
        // ユーザーの名前表示
        $name = Auth::guard('employee')->user()->name;
        if (4 <= $time && $time <= 11) { //4時～11時まで
            $message = "おはようございます、" . $name . "さん";
        } elseif (11 <= $time && $time <= 15) { //11時～15時まで
            $message = "こんにちは、" . $name . "さん";
        } else { // それ以外の時間帯のとき
            $message = "お疲れ様です、" . $name . "さん";
        };

        //日報の表示
        $emplo_id = Auth::guard('employee')->user()->emplo_id;
        $daily_data = DataBase::getDaily($emplo_id, $today);

        return view('employee.dashboard', compact(
            'ym',
            'today',
            'time',
            'format',
            'message',
            'daily_data'
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
    public function start_time_store(Request $request)
    {
        // 入力値をPOSTパラメーターから取得
        $target_date = date('Y-m-d');
        $start_time = $_POST['modal_start_time'];

        $emplo_id = Auth::guard('employee')->user()->emplo_id;

        //対象日のデータがあるかどうかチェック
        $check_date = Database::checkDate($emplo_id, $target_date);

        if ($check_date) {
            // 重複登録の場合
            return back()->with('works_warning', 'すでに打刻済みです。');
        } else {
            // 勤務開始時間をデータベースに登録する
            DataBase::insertStartTime($emplo_id, $target_date, $start_time);
            return back()->with('works_status', '出勤時間を登録しました');;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function closing_time_store(Request $request)
    {
        // 入力値をPOSTパラメーターから取得
        $target_date = date('Y-m-d');
        $closing_time = $_POST['modal_end_time'];
        $emplo_id = Auth::guard('employee')->user()->emplo_id;

        // 出勤時間の取得
        $start_time = Database::getStartTime($emplo_id, $target_date);

        // 出勤時間が打刻されている場合は新規登録し、未打刻の場合は警告MSGを出す
        if ($start_time) {
            Time::insertTime($emplo_id, $start_time[0]->start_time, $closing_time, $target_date);
            return back()->with('works_status', '退勤時間を登録しました');
        }
        return back()->with('works_warning', '出勤時間が打刻されていません');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function daily_store(Request $request)
    {
        // リクエストの取得
        $emplo_id = Auth::guard('employee')->user()->emplo_id;
        $daily = $request->daily;
        $today = date('Y-m-j');

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 日報の登録
        DataBase::insertDaily($emplo_id, $today, $daily);

        return back()->with('status', '日報を登録しました');;
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
    public function daily_update(Request $request)
    {
        // リクエストの取得
        $emplo_id = Auth::guard('employee')->user()->emplo_id;
        $daily = $request->daily;
        $today = date('Y-m-j');

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 日報の更新
        DataBase::updateDaily($emplo_id, $today, $daily);

        return back()->with('status', '日報を更新しました');;
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
