<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use App\Libraries\php\Domain\Common;
use App\Libraries\php\Domain\Time;
use App\Http\Requests\MonthlyRequest;

// 勤怠一覧のコントローラー
class MonthlyController extends Controller
{
    /**
     * 勤怠一覧の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員ID
     * @var string $name 社員名
     * @var App\Libraries\php\Domain\Common $format
     * @var string $ym 今月の年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\DataBase
     * @var array $monthly_data 勤怠データ
     * @var array $total_data 期間内の出勤日数、総勤務時間、残業時間の配列
     */
    public function index(Request $request, $emplo_id, $name)
    {
        // 今月の年月を表示
        $format = new Common();
        $ym = $format->to_monthly();
        // 月の日数を取得
        $day_count = date('t', strtotime($ym));
        // 今月の勤怠一覧を取得
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);

        // 期間内の出勤日数、総勤務時間、残業時間を求める
        $total_data = Common::totalTime($emplo_id, $ym);

        if (Auth::guard('employee')->check()) {
            return view('menu.attendance.attendance01', compact(
                'monthly_data',
                'day_count',
                'emplo_id',
                'name',
                'ym',
                'format',
                'total_data'
            ));
        } elseif (Auth::guard('admin')->check()) {
            return view('menu.attendance.attendance02', compact(
                'monthly_data',
                'day_count',
                'emplo_id',
                'name',
                'ym',
                'format',
                'total_data'
            ));
        }
    }

    /**
     * プロダウンで選んだ年度の勤怠一覧の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員ID
     * @var string $name 社員名
     * @var string $ym 選択した年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\Common $format
     * @var App\Libraries\php\Domain\DataBase
     * @var array $monthly_data 勤怠データ
     * @var array $total_data 期間内の出勤日数、総勤務時間、残業時間の配列
     */
    public function store(Request $request, $emplo_id, $name)
    {
        // プルダウンで選んだ年月と月数の取得
        if (isset($request->monthly_change)) {
            $ym = $request->monthly_change;
            $day_count = date('t', strtotime($ym));
        } else {
            $ym = date('Y-m');
            $day_count = date('t');
        }

        dd($ym,$day_count);

        // 勤怠一覧の取得
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);

        // 期間内の出勤日数、総勤務時間、残業時間を求める
        $total_data = Common::totalTime($emplo_id, $ym);

        // フォーマットの取得
        $format = new Common();

        if (Auth::guard('employee')->check()) {
            return view('menu.attendance.attendance01', compact(
                'monthly_data',
                'day_count',
                'name',
                'emplo_id',
                'ym',
                'format',
                'total_data'
            ));
        } elseif (Auth::guard('admin')->check()) {
            return view('menu.attendance.attendance02', compact(
                'monthly_data',
                'day_count',
                'emplo_id',
                'name',
                'ym',
                'format',
                'total_data'
            ));
        }
    }

    /**
     * 勤怠の修正
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $nama　従業員名
     * @var string $emplo_id 社員ID
     * @var string $target_date 選択した日付
     * @var string $start_time 出勤時間
     * @var string $closing_time 退勤時間
     * @var string $daily 日報
     * @var App\Libraries\php\Domain\DataBase
     * @var array $check_date 勤怠データ
     * @var array $cloumns_name カラム名
     * @var array $table_name テーブル名
     * @var array $daily_data 日報データ
     * @var App\Libraries\php\Domain\Time
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
        $cloumns_name = "daily";
        $table_name = "daily";
        $daily_data = DataBase::getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $target_date);

        // バリデーション
        // 出勤時間の必須／形式チェック
        if (empty($start_time)) {
            $message = '出勤時間を入力してください。';
            return redirect()->route('employee.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        }

        // 退勤時間のチェック
        if (!($start_time < $closing_time)) {
            $message = '退勤時間は出勤時間より後の時間を入力してください。';
            return redirect()->route('employee.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        }

        // 日報の最大サイズチェック
        if (mb_strlen($daily, 'utf-8') > 1024) {
            $message = '日報は1,024文字以内で入力してください。';
            return redirect()->route('employee.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        }
        // バリデーションここまで

        if ($check_date) {
            // 対象日にデータがある場合は、更新処理を行う
            Time::updateTime($emplo_id, $start_time, $closing_time, $target_date);
            TIme::Daily($emplo_id, $target_date, $daily, $daily_data);
            $message = "変更しました";
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])->with('status', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])->with('status', $message);
            }
        } else {
            // 対象日にデータがない場合は、新規登録処理を行う
            Time::insertTime($emplo_id, $start_time, $closing_time, $target_date);
            Time::Daily($emplo_id, $target_date, $daily, $daily_data);
            $message = "新規登録しました";
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])->with('status', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])->with('status', $message);
            }
        }
    }

    /**
     * プロダウンで選んだ年度の勤怠一覧の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員ID
     * @var string $name 社員名
     * @var string $ym 選択した年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\Common $format
     * @var App\Libraries\php\Domain\DataBase
     * @var array $monthly_data 勤怠データ
     * @var array $total_data 期間内の出勤日数、総勤務時間、残業時間の配列
     */
    public function search(Request $request, $emplo_id, $name)
    {
        $first_day = $request->first_day;
        $end_day = $request->end_day;

        // 指定した期間内の出勤日数、総勤務時間、残業時間を求める
        $total_data = Common::SearchtotalTime($emplo_id, $first_day, $end_day);

        if (Auth::guard('employee')->check()) {
            return view(
                'menu.attendance.attendance03',
                compact(
                    'first_day',
                    'end_day',
                    'emplo_id',
                    'name',
                    'total_data'
                )
            );
        } elseif (Auth::guard('admin')->check()) {
            return view(
                'menu.attendance.attendance03',
                compact(
                    'first_day',
                    'end_day',
                    'emplo_id',
                    'name',
                    'total_data'
                )
            );
        }
    }

    /**
     * エラーメッセージページ遷移
     *
     */
    public function errorMsg()
    {
        return view('menu.another.error');
    }
}
