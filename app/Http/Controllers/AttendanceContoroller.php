<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\DailyRequest;
use Illuminate\Support\Facades\Auth;
use App\Libraries\Time;
use App\Libraries\Common;
use App\Libraries\Database;
use Illuminate\Pagination\LengthAwarePaginator;

// 従業員側 ホーム画面のコントローラー
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
     * 出勤画面と日報の表示
     *
     * @var string $today 今日の日付
     * @var App\Libraries\php\Domain\Common
     * @var string $ym 今月の年月
     * @var array $time 今の時間
     * @var array $message 出勤画面に出すメッセージ
     * @var string $emplo_id 社員番号
     * @var App\Libraries\php\Domain\Database
     * @var array $cloumns_name カラム名
     * @var array $table_name テーブル名
     * @var array $daily_data 日報情報
     */
    public function index()
    {
        // 今日の日付 フォーマット
        $today = date('Y-m-j');
        $format = new Common();
        $ym = $format->to_monthly();

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
        $cloumns_name = "daily";
        $table_name = "daily";

        try {
            $daily_data = Database::getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $today);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        //対象日のデータがあるかどうかチェック
        try {
            $check_date = Database::checkDate($emplo_id, $today);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        // 出勤時間の取得
        $cloumns_name = "start_time";
        $table_name = "works";
        try {
            $start_time = Database::getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $today);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        return view('employee.dashboard', compact(
            'ym',
            'today',
            'time',
            'format',
            'message',
            'check_date',
            'daily_data',
            'start_time'
        ));
    }

    /**
     * 出勤時間の打刻
     *
     * @var string $today 今日の日付
     * @var string $start_time 出勤時間
     * @var array $message 出勤画面に出すメッセージ
     * @var string $emplo_id 社員番号
     * @var App\Libraries\php\Domain\Database
     * @var string $check_data 対象日にデータがある場合に取得する
     */
    public function start_time_store()
    {
        // 入力値をPOSTパラメーターから取得
        $today = date('Y-m-d');
        $start_time = $_POST['modal_start_time'];
        $emplo_id = Auth::guard('employee')->user()->emplo_id;

        //対象日のデータがあるかどうかチェック
        try {
            $check_date = Database::checkDate($emplo_id, $today);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        if ($check_date) {
            // 重複登録の場合
            $message = "すでに打刻済みです";
            return back()->with('works_warning', $message);
        } else {
            // 勤務開始時間をデータベースに登録する
            try {
                Database::insertStartTime($emplo_id, $today, $start_time);
            } catch (Exception $e) {
                $e->getMessage();
                return redirect()->route('employee.error');
            };

            $message = "出勤時間を登録しました";
            return back()->with('works_status', $message);
        }
    }

    /**
     * 退勤時間の打刻
     *
     * @var string $today 今日の日付
     * @var string $closing_time 退勤時間
     * @var string $emplo_id 社員番号
     * @var App\Libraries\php\Domain\Database
     * @var array $cloumns_name カラム名
     * @var array $table_name テーブル名
     * @var array $start_time 出勤時間
     */
    public function closing_time_store()
    {
        // 入力値をPOSTパラメーターから取得
        $today = date('Y-m-d');
        $closing_time = $_POST['modal_end_time'];
        $emplo_id = Auth::guard('employee')->user()->emplo_id;

        // 出勤時間の取得
        $cloumns_name = "start_time";
        $table_name = "works";
        try {
            $start_time = Database::getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $today);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        // 出勤時間が打刻されている場合は新規登録し、未打刻の場合は警告MSGを出す
        if ($start_time) {
            try {
                Time::updateTime($emplo_id, $start_time[0]->start_time, $closing_time, $today);
            } catch (Exception $e) {
                $e->getMessage();
                return redirect()->route('employee.error');
            };

            $message = "退勤時間を登録しました";
            return back()->with('works_status', $message);
        }
        $message = "出勤時間が打刻されていません";
        return back()->with('works_warning', $message);
    }

    /**
     * 日報の登録
     *
     * @param \Illuminate\Http\Request\DailyRequest $request
     *
     * @var string $emplo_id 社員番号
     * @var string $daily 日報
     * @var string $today 今日の日付
     * @var App\Libraries\php\Domain\Database
     */
    public function daily_store(DailyRequest $request)
    {
        // リクエストの取得
        $emplo_id = Auth::guard('employee')->user()->emplo_id;
        $daily = $request->daily;
        $today = date('Y-m-j');

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 日報の登録
        try {
            if (!(is_null($daily))) {
                Database::insertDaily($emplo_id, $today, $daily);
            };
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };


        $message = "日報を登録しました";
        return back()->with('status', $message);
    }

    /**
     * 日報の更新
     *
     * @param \Illuminate\Http\Request\DailyRequest $request
     *
     * @var string $emplo_id 社員番号
     * @var string $daily 日報
     * @var string $today 今日の日付
     * @var App\Libraries\php\Domain\Database
     */
    public function daily_update(DailyRequest $request)
    {
        // リクエストの取得
        $emplo_id = Auth::guard('employee')->user()->emplo_id;
        $daily = $request->daily;
        $today = date('Y-m-j');

        // 重複クリック対策
        $request->session()->regenerateToken();

        // DBに登録済みの日報の取得
        $cloumns_name = "daily";
        $table_name = "daily";

        try {
            $old_daily_data = Database::getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $today);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        // 日報の更新
        try {
            Database::updateDaily($emplo_id, $today, $daily);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('employee.error');
        };

        if ($daily == $old_daily_data[0]->daily) {
            if ((is_null($daily)) == true) {
                $message = "日報を登録しました";
            } else {
                $message = "日報を更新しました";
            }
        } else {
            $message = "日報を更新しました";
        };

        return back()->with('status', $message);
    }

    /**
     * 部下一覧の表示
     *
     * @var string $emplo_id 社員番号
     * @var App\Libraries\php\Domain\Database
     * @var array $subord_data 部下情報
     * @var array $retirement_authority 退職フラグ
     */
    public function subord_index(Request $request)
    {
        // 自分自身の配下の部下一覧を取得する
        if (Auth::guard('employee')->user()->subord_authority == "1") {
            $emplo_id = Auth::guard('employee')->user()->emplo_id;
            // 在職者だけ出す
            $retirement_authority = "0";
            try {
                $subord_data = collect(Database::getSubord($emplo_id, $retirement_authority));
            } catch (Exception $e) {
                $e->getMessage();
                return redirect()->route('employee.error');
            };

            // ページネーション
            // 参照：https://qiita.com/wallkickers/items/35d13a62e0d53ce05732
            $subord_data = new LengthAwarePaginator(
                $subord_data->forPage($request->page, 10),
                count($subord_data),
                10,
                $request->page,
                array('path' => $request->url())
            );

            return view('menu.subord.subord_lists', compact('subord_data'));
        }
        // 部下がいない状態で部下一覧の画面に遷移しようとした場合、以下に遷移する
        return redirect()->route('employee.error');
    }
}
