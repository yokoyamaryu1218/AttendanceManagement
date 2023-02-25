<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\MonthlyRequest;
use App\Libraries\Database;
use App\Libraries\Common;
use App\Libraries\Time;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

// 勤怠一覧のコントローラー
class MonthlyController extends Controller
{
    /**
     * 勤怠一覧の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $name 社員名
     * @var App\Libraries\php\Domain\Common $format
     * @var string $ym 今月の年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\Database
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
        try {
            $monthly_data = Database::getMonthly($emplo_id, $ym);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

        // 期間内の出勤日数、総勤務時間、残業時間を求める
        try {
            $total_data = Common::totalTime($emplo_id, $ym);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

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
     * @var string $emplo_id 社員番号
     * @var string $name 社員名
     * @var string $ym 選択した年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\Common $format
     * @var App\Libraries\php\Domain\Database
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

        // 勤怠一覧の取得
        try {
            $monthly_data = Database::getMonthly($emplo_id, $ym);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

        // 期間内の出勤日数、総勤務時間、残業時間を求める
        try {
            $total_data = Common::totalTime($emplo_id, $ym);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

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
     * @var string $emplo_id 社員番号
     * @var string $target_date 選択した日付
     * @var string $start_time 出勤時間
     * @var string $closing_time 退勤時間
     * @var string $daily 日報
     * @var App\Libraries\php\Domain\Database
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
        try {
            $check_date = Database::checkDate($emplo_id, $target_date);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

        $cloumns_name = "daily";
        $table_name = "daily";
        try {
            $daily_data = Database::getStartTimeOrDaily($cloumns_name, $table_name, $emplo_id, $target_date);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

        // バリデーション
        // 出勤時間の必須／形式チェック
        if (empty($start_time)) {
            $message = '出勤時間を入力してください。';
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            }
        }

        // 退勤時間のチェック
        if (!($start_time < $closing_time)) {
            $message = '退勤時間は、出勤時間より後の時間を入力してください。';
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            }
        }

        // 日報の最大サイズチェック
        if (mb_strlen($daily, 'utf-8') > 1024) {
            $message = '日報は、1,024文字以内で入力してください。';
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            }
        }
        // バリデーションここまで

        if ($check_date) {
            // 対象日にデータがある場合は、更新処理を行う
            try {
                Time::updateTime($emplo_id, $start_time, $closing_time, $target_date);
                TIme::Daily($emplo_id, $target_date, $daily, $daily_data);
            } catch (Exception $e) {
                $e->getMessage();
                if (Auth::guard('employee')->check()) {
                    return redirect()->route('employee.error');
                } elseif (Auth::guard('admin')->check()) {
                    return redirect()->route('employee.error');
                };
            };

            $message = "変更しました";
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            }
        } else {
            // 対象日にデータがない場合は、新規登録処理を行う
            try {
                Time::insertTime($emplo_id, $start_time, $closing_time, $target_date);
                Time::Daily($emplo_id, $target_date, $daily, $daily_data);
            } catch (Exception $e) {
                $e->getMessage();
                if (Auth::guard('employee')->check()) {
                    return redirect()->route('employee.error');
                } elseif (Auth::guard('admin')->check()) {
                    return redirect()->route('employee.error');
                };
            };

            $message = "新規登録しました";
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('admin.monthly', [$emplo_id, $name])
                    ->with('warning', $message);
            }
        }
    }

    /**
     * プロダウンで選んだ年度の勤怠一覧の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $name 社員名
     * @var string $ym 選択した年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\Common $format
     * @var App\Libraries\php\Domain\Database
     * @var array $monthly_data 勤怠データ
     * @var array $total_data 期間内の出勤日数、総勤務時間、残業時間の配列
     */
    public function search(MonthlyRequest $request, $emplo_id, $name)
    {
        $first_day = $request->first_day;
        $end_day = $request->end_day;

        // 指定した期間内の出勤日数、総勤務時間、残業時間を求める
        try {
            $total_data = Common::SearchtotalTime($emplo_id, $first_day, $end_day);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

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
     * プロダウンで選んだ年度の勤怠一覧の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $name 社員名
     * @var string $ym 選択した年月
     * @var string $day_count 月の日数
     * @var App\Libraries\php\Domain\Common $format
     * @var App\Libraries\php\Domain\Database
     * @var array $monthly_data 勤怠データ
     * @var array $total_data 期間内の出勤日数、総勤務時間、残業時間の配列
     */
    public function excel(MonthlyRequest $request, $emplo_id, $name)
    {
        $first_day = $request->first_day;
        $end_day = $request->end_day;
        $total_times = 0;

        // Excelへの書き込み
        $spreadsheet = new Spreadsheet();
        $inputFileName = '../temp/tmp1.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($inputFileName);

        $working_data = Database::SearchWorkDays($emplo_id, $first_day, $end_day);

        if (!empty($working_data)) {
            $restraint_total_time = Database::getRestraintTime($emplo_id)[0]->restraint_total_time;

            // 残業時間を求める
            $cloumns_name = "over_time";
            $total_name = "total_over_time";
            $total_over_time = Database::SearchTotalWorking($cloumns_name, $total_name, $emplo_id, $first_day, $end_day)[0]->total_over_time;

            // 総勤務時間を求める
            $cloumns_name = "achievement_time";
            $total_name = "total_achievement_time";
            $total_achievement_time = Database::SearchTotalWorking($cloumns_name, $total_name, $emplo_id, $first_day, $end_day)[0]->total_achievement_time;

            $sheet = $spreadsheet->getSheetByName('Sheet1');

            $i = 8;
            for ($date = $first_day; $date <= $end_day; $date = date('Y-m-d', strtotime($date . '+1 day'))) {
                $data = array_filter($working_data, function ($item) use ($date) {
                    return $item->date == $date;
                });

                $sheet->getStyle('C' . $i)->getNumberFormat()->setFormatCode('h:mm');
                $sheet->getStyle('D' . $i)->getNumberFormat()->setFormatCode('h:mm');
                $sheet->getStyle('E' . $i)->getNumberFormat()->setFormatCode('h:mm');
                $sheet->getStyle('F' . $i)->getNumberFormat()->setFormatCode('h:mm');

                if (empty($data)) {
                    $timestamp = strtotime($date);

                    $day_of_week = date('w', $timestamp); // 曜日を数値で取得する（0:日曜日, 1:月曜日, ..., 6:土曜日）
                    $font_color = ''; // フォントの色を格納する変数

                    if ($day_of_week == 0) { // 日曜日の場合
                        $font_color = 'FF0000'; // 赤色
                    } else if ($day_of_week == 6) { // 土曜日の場合
                        $font_color = '0000FF'; // 青色
                    }

                    $sheet->setCellValue('A' . $i, date('n/j', $timestamp));
                    $sheet->setCellValue('B' . $i, str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'), array('日', '月', '火', '水', '木', '金', '土'), date('D', $timestamp))); // 曜日を日本語で表記する
                    $sheet->getStyle('B' . $i)->getFont()->getColor()->setARGB($font_color); // フォント色を変更する
                    $sheet->setCellValue('C' . $i, '');
                    $sheet->setCellValue('D' . $i, '');
                    $sheet->setCellValue('E' . $i, '');
                    $sheet->setCellValue('F' . $i, '');
                } else {
                    $data = reset($data);
                    $timestamp = strtotime($data->date);

                    $day_of_week = date('w', $timestamp); // 曜日を数値で取得する（0:日曜日, 1:月曜日, ..., 6:土曜日）
                    $font_color = ''; // フォントの色を格納する変数

                    if ($day_of_week == 0) { // 日曜日の場合
                        $font_color = 'FF0000'; // 赤色
                    } else if ($day_of_week == 6) { // 土曜日の場合
                        $font_color = '0000FF'; // 青色
                    }

                    $sheet->setCellValue('A' . $i, date('n/j', $timestamp));
                    $sheet->setCellValue('B' . $i, str_replace(array('Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'), array('日', '月', '火', '水', '木', '金', '土'), date('D', $timestamp))); // 曜日を日本語で表記する
                    $sheet->getStyle('B' . $i)->getFont()->getColor()->setARGB($font_color); // フォント色を変更する
                    $sheet->setCellValue('C' . $i, substr($data->start_time, 0, 5));
                    $sheet->setCellValue('D' . $i, substr($data->closing_time, 0, 5));
                    if (strtotime($data->achievement_time) > strtotime($restraint_total_time)) {
                        $achievement_time = $restraint_total_time;
                        $sheet->setCellValue('E' . $i, substr($achievement_time, 0, 5));
                    } else {
                        $achievement_time = $data->achievement_time;
                        $sheet->setCellValue('E' . $i, substr($achievement_time, 0, 5));
                    }

                    $time_array = explode(":", $achievement_time);
                    $total_minutes = ($time_array[0] * 60) + $time_array[1];
                    $total_times += $total_minutes;
                    $total_hours = floor($total_times / 60); // 合計時間の時間単位を計算
                    $total_minutes = $total_times % 60; // 合計時間の分単位を計算
                    $total_time_string = sprintf("%02d:%02d", $total_hours, $total_minutes);

                    $sheet->setCellValue('F' . $i, substr($data->over_time, 0, 5));
                }

                $i++;
            }

            $sheet->setCellValue('G' . 4, $name);
            $sheet->setCellValue('E' . 39, $total_time_string);
            $sheet->setCellValue('F' . 39, substr($total_over_time, 0, 5));
            if (strlen($total_achievement_time) === 8) {
                $sheet->setCellValue('E' . 40, substr($total_achievement_time, 0, 5));
            } else if (strlen($total_achievement_time) === 9) {
                $sheet->setCellValue('E' . 40, substr($total_achievement_time, 0, 6));
            }
            $sheet->mergeCells('E40:F40');

            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
            $downloadFileName = '出勤簿.xlsx';
            $writer->save($downloadFileName);

            // ファイルをダウンロードする処理
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . basename($downloadFileName) . '"');
            header('Cache-Control: max-age=0');

            $objWriter = IOFactory::createWriter($spreadsheet, 'Xlsx');
            $objWriter->save('php://output');
            exit;
        }

        $message = "指定された日付には、勤怠情報がありませんでした。";

        if (Auth::guard('employee')->check()) {
            return redirect()->route('employee.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        }
    }

    /**
     * 指定された日付の曜日を日本語で取得する
     * @param string $date 日付文字列 (YYYY/MM/DD)
     * @return string 曜日文字列 (日〜土)
     */
    function getJapaneseDayOfWeek($date)
    {
        $weekdays = array('日', '月', '火', '水', '木', '金', '土');
        $dayOfWeek = date('w', strtotime($date)); // 0:日曜日, 1:月曜日, ..., 6:土曜日
        return $weekdays[$dayOfWeek];
    }

    public function delete($emplo_id, $name, $day)
    {
        try {
            $table_name = "daily";
            Database::deleteWorksOrDaily($table_name, $emplo_id, $day);
            $table_name = "works";
            Database::deleteWorksOrDaily($table_name, $emplo_id, $day);
        } catch (Exception $e) {
            $e->getMessage();
            if (Auth::guard('employee')->check()) {
                return redirect()->route('employee.error');
            } elseif (Auth::guard('admin')->check()) {
                return redirect()->route('employee.error');
            };
        };

        $message = "削除しました";
        if (Auth::guard('employee')->check()) {
            return redirect()->route('employee.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        } elseif (Auth::guard('admin')->check()) {
            return redirect()->route('admin.monthly', [$emplo_id, $name])
                ->with('warning', $message);
        }
    }

    /**
     * エラーメッセージの表示
     *
     */
    public function errorMsg()
    {
        return view('menu.another.error',);
    }
}
