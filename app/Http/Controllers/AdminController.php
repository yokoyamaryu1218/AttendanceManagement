<?php

namespace App\Http\Controllers;

use App\Http\Requests\ManagementRequest;
use App\Http\Requests\NewPostRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Requests\ExcelImportRequest;
use App\Libraries\Common;
use App\Libraries\employeeDatabase;
use App\Libraries\attendanceDatabase;
use App\Libraries\Time;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use DateTime;

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
     * 在職の従業員の表示
     *
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $retirement_authority 退職フラグ
     * @var array $employee_lists 在職者リスト
     * @var array $retirement_lists 退職者リスト
     */
    public function index(Request $request)
    {
        // 在職者だけを表示するため、退職フラグに0を付与
        try {
            $retirement_authority = "0";
            $employee_lists = collect(employeeDatabase::getEmployeeAll($retirement_authority));
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        // ページネーション
        // 参照：https://qiita.com/wallkickers/items/35d13a62e0d53ce05732
        $employee_lists = new LengthAwarePaginator(
            $employee_lists->forPage($request->page, 10),
            count($employee_lists),
            10,
            $request->page,
            array('path' => $request->url())
        );
        // 退職者がいる場合、退職者一覧のリンクを表示するため、退職者リストも取得する
        try {
            $retirement_lists = employeeDatabase::getEmployeeAll("1");
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        }

        return view('admin.dashboard', compact(
            'employee_lists',
            'retirement_authority',
            'retirement_lists',
        ));
    }

    /**
     * 退職した従業員の表示
     *
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $retirement_authority 退職フラグ
     */
    public function retirement(Request $request)
    {
        try {
            $retirement_authority = "1";
            $employee_lists = collect(employeeDatabase::getEmployeeAll($retirement_authority));
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        // ページネーション
        $employee_lists = new LengthAwarePaginator(
            $employee_lists->forPage($request->page, 10),
            count($employee_lists),
            10,
            $request->page,
            array('path' => $request->url())
        );

        return view('menu.emplo_detail.emplo_detail06', compact(
            'employee_lists',
            'retirement_authority',
        ));
    }

    /**
     * 時短社員の表示
     *
     * @var App\Libraries\php\Domain\attendanceDatabase
     * @var array $retirement_authority 退職フラグ
     * @var array $short_working 時短フラグ
     * @var array $short_worker_lists 時短社員リスト
     */
    public function short_worker(Request $request)
    {
        // 退職者だけを表示するため、退職フラグに1を付与
        try {
            $retirement_authority = "0";
            $short_working = "1";
            $short_worker_lists = collect(attendanceDatabase::getshortWorker($retirement_authority, $short_working));
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        // ページネーション
        $short_worker_lists = new LengthAwarePaginator(
            $short_worker_lists->forPage($request->page, 10),
            count($short_worker_lists),
            10,
            $request->page,
            array('path' => $request->url())
        );

        return view('menu.emplo_detail.emplo_detail08', compact(
            'short_worker_lists',
        ));
    }

    /**
     * 従業員の新規登録画面の表示
     *
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $subord_authority_lists 部下配属権限がある社員リスト
     */
    public function create()
    {
        // 部下配属権限がある社員リストの取得
        try {
            $subord_authority = "1";
            $subord_authority_lists = employeeDatabase::getSubordAuthority($subord_authority);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        return view('menu.emplo_detail.emplo_detail03', compact(
            'subord_authority_lists',
        ));
    }

    /**
     * 従業員の登録
     *
     * @param App\Http\Requests\NewPostRequest $request
     *
     * @var string $name　従業員名
     * @var string $password パスワード
     * @var string $management_emplo_id 上司社員番号
     * @var string $hire_date 入社日
     * @var string $restraint_start_time 始業時間
     * @var string $restraint_closing_time 終業時間
     * @var App\Libraries\php\Domain\Time
     * @var string $restraint_total_time 所定労働時間
     * @var string $retirement_authority 退職フラグ
     * @var string $short_working 時短フラグ
     * @var array $subord_authority 部下配属権限
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var string $emplo_id 社員番号
     * @var App\Libraries\php\Domain\Common
     */
    public function store(NewPostRequest $request)
    {
        //リクエストの取得
        $name = $request->name;
        $password = Hash::make($request->password);
        $management_emplo_id = $request->management_emplo_id;
        $hire_date = $request->hire_date;
        $restraint_start_time = $request->restraint_start_time;
        $restraint_closing_time = $request->restraint_closing_time;
        $restraint_total_time = Time::restraint_total_time($restraint_start_time, $restraint_closing_time);
        $retirement_authority = "0";

        // 時短フラグ
        $short_working = Common::working_hours($restraint_start_time, $restraint_closing_time);

        // トグルがONになっている場合は1、OFFの場合は0
        if (is_null($request->subord_authority)) {
            $subord_authority = "0";
        } else {
            $subord_authority = $request->subord_authority;
        };

        //登録する番号を作成
        $id = employeeDatabase::getID();
        $emplo_id = $id[0]->emplo_id + "1";

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 情報を登録
        Common::insertEmployee(
            $emplo_id,
            $name,
            $password,
            $management_emplo_id,
            $subord_authority,
            $retirement_authority,
            $hire_date,
            $restraint_start_time,
            $restraint_closing_time,
            $restraint_total_time,
            $short_working
        );

        $message = "登録しました";
        return redirect()->route('admin.emplo_details', [$emplo_id, $retirement_authority])
            ->with('status', $message);
    }

    /**
     * 従業員の表示
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $retirement_authority 退職フラグ
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $employee_lists 選択した従業員の詳細データ
     * @var array $subord_authority 部下配属権限
     * @var array $subord_authority_lists 部下配属権限がある社員リスト
     */
    public function show($emplo_id, $retirement_authority)
    {
        // 詳細画面の情報取得
        try {
            $employee_lists = employeeDatabase::SelectEmployee($emplo_id, $retirement_authority);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        // 部下配属権限がある社員リストの取得
        try {
            $subord_authority = "1";
            $subord_authority_lists = employeeDatabase::getSubordAuthority($subord_authority);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        return view('menu.emplo_detail.emplo_detail01', compact(
            'employee_lists',
            'subord_authority_lists',
        ));
    }

    /**
     * 在職の従業員の表示
     *
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $retirement_authority 退職フラグ
     * @var array $employee_lists 在職者リスト
     * @var array $retirement_lists 退職者リスト
     */
    public function search(Request $request, $retirement_authority)
    {
        //検索語のチェック
        if (isset($_GET['search'])) {
            $_POST['search'] = $_GET['search'];
        }

        try {
            if (is_numeric($request->search)) {
                $employee_lists = collect(employeeDatabase::getSearchID($retirement_authority, $request->search));
            } else {
                $employee_lists = collect(employeeDatabase::getSearchName($retirement_authority, $request->search));
            }
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        // ページネーション
        // 参照：https://qiita.com/wallkickers/items/35d13a62e0d53ce05732
        $employee_lists = new LengthAwarePaginator(
            $employee_lists->forPage($request->page, 10),
            count($employee_lists),
            10,
            $request->page,
            array('path' => $request->url())
        );

        // 退職者がいる場合、退職者一覧のリンクを表示するため、退職者リストも取得する
        try {
            $retirement_lists = employeeDatabase::getEmployeeAll("1");
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        if ($retirement_authority == "0") {
            return view('admin.dashboard', compact(
                'employee_lists',
                'retirement_authority',
                'retirement_lists',
            ));
        } else {
            return view('menu.emplo_detail.emplo_detail06', compact(
                'employee_lists',
                'retirement_authority',
            ));
        }
    }

    /**
     * 従業員情報の更新
     *
     * @param \Illuminate\Http\Request\UpdateRequest $request
     *
     * @var string $emplo_id 社員番号
     * @var string $name　従業員名
     * @var string $management_emplo_id 上司社員番号
     * @var string $restraint_start_time 始業時間
     * @var string $restraint_closing_time 終業時間
     * @var string $restraint_total_time 所定労働時間
     * @var array $subord_authority 部下配属権限
     * @var App\Libraries\php\Domain\Common
     * @var array $short_working 時短フラグ
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request)
    {
        //リクエストの取得
        $emplo_id = $request->emplo_id;
        $name = $request->name;
        $management_emplo_id = $request->management_emplo_id;
        $restraint_start_time = $request->restraint_start_time;
        $restraint_closing_time = $request->restraint_closing_time;
        $restraint_total_time = Time::restraint_total_time($restraint_start_time, $restraint_closing_time);

        // 時短フラグ
        $short_working = Common::working_hours($restraint_start_time, $restraint_closing_time);

        // トグルがONになっている場合は1、OFFの場合は0
        if (is_null($request->subord_authority)) {
            $subord_authority = "0";
        } elseif ($request->subord_authority = "on") {
            $subord_authority = "1";
        } else {
            $subord_authority = $request->subord_authority;
        };

        // 社員番号と上司社員番号が同一ではないかチェック
        if ($management_emplo_id == $emplo_id) {
            $message = '編集中の社員と上司は別々にしてください。';

            return back()->with('warning', $message);
        }

        // 重複クリック対策
        $request->session()->regenerateToken();

        // 情報を更新
        Common::updateEmployee(
            $emplo_id,
            $name,
            $management_emplo_id,
            $subord_authority,
            $restraint_start_time,
            $restraint_closing_time,
            $restraint_total_time,
            $short_working
        );

        $message = "更新しました";
        return back()->with('status', $message);
    }

    /**
     * 復職処理を行う従業員の詳細取得
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $retirement_authority 退職フラグ
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $employee_lists 選択した従業員の詳細データ
     */
    public function reinstatement_check($emplo_id, $retirement_authority)
    {
        try {
            $employee_lists = employeeDatabase::SelectEmployee($emplo_id, $retirement_authority);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        //リダイレクト
        return view('menu.emplo_detail.emplo_detail05', compact(
            'employee_lists',
        ));
    }

    /**
     * 復職処理の実行
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var array $retirement_authority 退職フラグ
     * @var array $retirement_date 退職日
     * @var array $deleted_at 退職処理日
     * @var App\Libraries\php\Domain\employeeDatabase
     */
    public function reinstatement_action($emplo_id)
    {
        //退職フラグに0を付与し、退職日を消す
        $retirement_authority = "0";
        $retirement_date = null;
        $deleted_at = null;

        try {
            employeeDatabase::retirementAssignment($retirement_authority, $retirement_date, $deleted_at, $emplo_id);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        //リダイレクト
        return redirect()->route('admin.dashboard');
    }

    /**
     * 退職処理を行う従業員の詳細取得
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var string $retirement_authority 退職フラグ
     * @var App\Libraries\php\Domain\employeeDatabase
     * @var array $employee_lists 選択した従業員の詳細データ
     */
    public function destroy_check($emplo_id, $retirement_authority)
    {
        // 退職処理を行う従業員の情報取得
        try {
            $employee_lists = employeeDatabase::SelectEmployee($emplo_id, $retirement_authority);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        //リダイレクト
        return view('menu.emplo_detail.emplo_detail04', compact(
            'employee_lists',
        ));
    }

    /**
     * 退職処理の実行
     *
     * @param \Illuminate\Http\Request\Request $request
     *
     * @var string $emplo_id 社員番号
     * @var array $retirement_authority 退職フラグ
     * @var array $retirement_date 退職日
     * @var App\Libraries\php\Domain\employeeDatabase
     */
    public function destroy(Request $request, $emplo_id)
    {
        //退職フラグに1を付与し、退職日を記録する
        $retirement_authority = "1";
        $retirement_date = $request->retirement_date;
        $deleted_at = null;

        try {
            employeeDatabase::retirementAssignment($retirement_authority, $retirement_date, $deleted_at, $emplo_id);

            // 退職日に日付を付与する
            $user = Employee::find($emplo_id);
            $user->delete();
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        //リダイレクト
        return redirect()->route('admin.dashboard');
    }

    /**
     * 管理画面の表示
     *
     * @var App\Libraries\php\Domain\attendanceDatabase
     * @var array $working_hours 退職フラグ
     */
    public function management()
    {
        // 管理権限の有無を確認する
        if (Auth::guard('admin')->user()->admin_authority == "1") {
            // 会社全体の所定労働時間の取得
            $working_hours = attendanceDatabase::Workinghours();

            //リダイレクト
            return view('menu.management.management01', compact(
                'working_hours',
            ));
        }
        // 権限がない状態で管理画面に遷移しようとした場合、以下に遷移する
        return redirect()->route('admin.error');
    }

    /**
     * 所定労働時間の更新
     *
     * @param \Illuminate\Http\Request\ManagementRequest $request
     *
     * @var string $restraint_start_time  始業時間
     * @var string $restraint_closing_time 終業時間
     * @var App\Libraries\php\Domain\Time
     * @var App\Libraries\php\Domain\attendanceDatabase
     * @var array $restraint_total_time 所定労働時間
     */
    public function update_workinghours(ManagementRequest $request)
    {
        //リクエストの取得
        $restraint_start_time = $request->restraint_start_time;
        $restraint_closing_time = $request->restraint_closing_time;
        $restraint_total_time = Time::restraint_total_time($restraint_start_time, $restraint_closing_time);

        attendanceDatabase::UpdateWorkinghours($restraint_start_time, $restraint_closing_time);
        $short_working = "0";
        attendanceDatabase::UpdateEmploAll($restraint_start_time, $restraint_closing_time, $restraint_total_time, $short_working);

        //リダイレクト
        $message = "変更しました";
        return back()->with('status', $message);
    }

    /**
     * 従業員情報をExcelファイルとしてダウンロードする
     *
     * @param \Illuminate\Http\Request $request
     *
     * @var string $retirement_authority 退職者情報取得フラグ
     * @var array $employee_list 従業員情報リスト
     */
    public function employeeListDownload(Request $request)
    {
        $retirement_authority = $request->has('retirement_authority') ? '1' : '0';

        // Excelへの書き込み
        $spreadsheet = new Spreadsheet();
        $inputFileName = '../temp/tmp2.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($inputFileName);

        $employee_list = employeeDatabase::getEmployeeList($retirement_authority);

        // スタイルオブジェクトを作成する
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );

        if (!empty($employee_list)) {
            $sheet = $spreadsheet->getSheetByName('Sheet1');
            $i = 4;
            foreach ($employee_list as $employee) {
                $sheet->setCellValue('A' . $i, $employee->emplo_id);
                $sheet->setCellValue('B' . $i, $employee->name);
                if ($employee->subord_authority === "1") {
                    $sheet->setCellValue('C' . $i,  "〇");
                } else {
                    $sheet->setCellValue('C' . $i,  " ");
                }
                // セルのスタイルを設定する
                $sheet->getStyle('C' . $i)->applyFromArray($style);
                $sheet->setCellValue('D' . $i, $employee->high_name);
                $sheet->setCellValue('E' . $i, $employee->restraint_start_time);
                $sheet->setCellValue('F' . $i, $employee->restraint_closing_time);

                if ($employee->short_working === "1") {
                    $sheet->setCellValue('G' . $i, "〇");
                } else {
                    $sheet->setCellValue('G' . $i, " ");
                }
                // セルのスタイルを設定する
                $sheet->getStyle('G' . $i)->applyFromArray($style);

                $sheet->setCellValue('H' . $i, $employee->hire_date);
                $sheet->setCellValue('I' . $i, $employee->retirement_date);
                $i++;
            }
            $sheet->setCellValue('I' . 1, date('Y-m-j'));

            $downloadFileName = '名簿.xlsx';
            $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');

            // 一時ファイルに保存する
            $tempFilePath = tempnam(sys_get_temp_dir(), 'tempSpreadsheet');
            $writer->save($tempFilePath);

            // ファイルをダウンロードする処理
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="' . basename($downloadFileName) . '"');
            header('Cache-Control: max-age=0');
            header('Content-Length: ' . filesize($tempFilePath));
            readfile($tempFilePath);
            unlink($tempFilePath);
            exit;
        }

        $message = "社員情報がありませんでした";
        return back()->with('warning', $message);
    }

    /**
     * テンプレートファイルのダウンロード
     *
     * @var array $subord_authority_lists 部下の名前リスト
     */
    public function templateDownload()
    {
        $subord_authority_lists = employeeDatabase::getSubordName();
        // Excelファイルへの書き込み
        $spreadsheet = new Spreadsheet();
        $inputFileName = '../temp/tmp3.xlsx';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($inputFileName);

        $sheet = $spreadsheet->getSheetByName('Sheet1');

        // スタイルオブジェクトを作成する
        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );

        // C4からC100のセルにドロップダウンリストを設定する
        $validation = $sheet->getDataValidation("C7:C102");
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $validation->setAllowBlank(false);
        $validation->setShowDropDown(true);
        $names = array_map(function ($item) {
            return $item->name;
        }, $subord_authority_lists);
        $validation->setFormula1('"' . implode(",", $names) . '"');

        // B4からB100のセルにドロップダウンリストを設定する
        $choices = ['〇', '　'];
        $validation = $sheet->getDataValidation("B7:B102");
        $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
        $validation->setErrorStyle(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::STYLE_STOP);
        $validation->setAllowBlank(false);
        $validation->setShowDropDown(true);
        $validation->setFormula1('"' . implode(",", $choices) . '"');
        $sheet->getStyle('B7:B102')->applyFromArray($style);

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $downloadFileName = 'template.xlsx';

        // 一時ファイルに保存する
        $tempFilePath = tempnam(sys_get_temp_dir(), 'tempSpreadsheet');
        $writer->save($tempFilePath);

        // ファイルをダウンロードする処理
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . basename($downloadFileName) . '"');
        header('Cache-Control: max-age=0');
        header('Content-Length: ' . filesize($tempFilePath));
        readfile($tempFilePath);
        unlink($tempFilePath);
        exit;
    }

    /**
     * 従業員情報をExcelファイルとしてダウンロードする
     *
     * @param \Illuminate\Http\ExcelImportRequest $request
     *
     * @var App\Libraries\php\Domain\attendanceDatabase
     * @var array $emplo_id 社員ID
     * @var array $check_name 名前確認用
     * @var array $high_id 管理者ID
     * @var App\Libraries\php\Domain\Time
     * @var array $restraint_total_time 所定労働時間
     * @var App\Libraries\php\Domain\Common
     * @var array $short_working 時短フラグ
     * @var App\Rules\PasswordRule
     */
    public function insertEmplyeeList(ExcelImportRequest $request)
    {
        $emplo_id = employeeDatabase::getID()[0]->emplo_id + 1;

        $file = request()->file('example');
        if (isset($file)) {
            $extension = $file->getClientOriginalExtension();
            if ($extension === 'xlsx') {
                $spreadsheet = IOFactory::load($file->getPathname());
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();
                $rowData = [];

               // 7行目からA～F列の情報を読み取る
                for ($row = 7; $row <= $highestRow; $row++) {
                    $data = [
                        'A' => $worksheet->getCellByColumnAndRow(1, $row)->getValue(),
                        'B' => $worksheet->getCellByColumnAndRow(2, $row)->getValue(),
                        'C' => $worksheet->getCellByColumnAndRow(3, $row)->getValue(),
                        'D' => $worksheet->getCellByColumnAndRow(4, $row)->getFormattedValue(),
                        'E' => $worksheet->getCellByColumnAndRow(5, $row)->getFormattedValue(),
                    ];

                    // A～FすべてがNULLの列があったら、情報の読み取りを中断する
                    if (!array_filter($data)) {
                        break;
                    }

                    if (is_numeric($data["A"])) {
                        $message = "取り込み対象外のExcelシートです。処理を中断します。";
                        return back()->with('warning', $message);
                    } else if (is_null($data["A"])) {
                        $message = "$row 列目のA列が空欄です。処理を中断します。";
                        return back()->with('warning', $message);
                    }

                    $check_name = employeeDatabase::getName($data["A"]);
                    if (isset($check_name[0])) {
                        $message = "$row 列目のA列の名前はすでに登録されています。処理を中断します。";
                        return back()->with('warning', $message);
                    } else if (!is_null($data["B"]) && $data["B"] !== "〇") {
                        $message = "$row 列目のB列に〇以外の文字が入力されています。処理を中断します。";
                        return back()->with('warning', $message);
                    }

                    $high_id = employeeDatabase::searchSubordName($data["C"]); //管理者名をもとに管理者IDに置き換える
                    if (!empty($high_id)) {
                        $data["C"] = $high_id[0]->emplo_id;
                    } else {
                        $message = "$row 列目のC列にプルダウン以外の社員名が入力されています。処理を中断します。";
                        return back()->with('warning', $message);
                    }

                    if (!preg_match('/^\d{1,2}:\d{2}$/',  $data["D"]) || !preg_match('/^\d{1,2}:\d{2}$/', $data["E"])) {
                        $message = "$row 列目のDもしくはE列の入力が不正です。処理を中断します。";
                        return back()->with('warning', $message);
                    }

                    if (strtotime($data["E"]) <= strtotime($data["D"])) {
                        $message = "$row 列目について、終業時間は始業時間より後の日時を指定してください";
                        return back()->with('warning', $message);
                    }

                    $F_value = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    if (is_numeric($F_value)) {
                        $F_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($F_value)->format('Y/m/d');
                    } else {
                        $F_date = $F_value;
                    }

                    if (!DateTime::createFromFormat('Y/m/d', $F_date)) {
                        $message = "$row 列目のF列の入力が不正です。処理を中断します。";
                        return back()->with('warning', $message);
                    } else {
                        $data['F'] = $worksheet->getCellByColumnAndRow(6, $row)->getValue() ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($worksheet->getCellByColumnAndRow(6, $row)->getValue())->format('Y/m/d') : '';
                    }

                    $rowData[] = $data;
                }

                if (isset($rowData)) {
                    $employee_data_list = array();
                    foreach ($rowData as $data) {
                        $name = $data["A"];
                        $password = Hash::make($request->password);
                        $subord_authority = $data["B"] === '〇' ? 1 : 0;
                        $management_emplo_id = $data["C"];
                        $restraint_start_time = $data["D"];
                        $restraint_closing_time = $data["E"];
                        $restraint_total_time = Time::restraint_total_time($restraint_start_time, $restraint_closing_time);
                        $retirement_authority = "0";
                        $hire_date = $data["F"];

                        // 時短フラグ
                        $short_working = Common::working_hours($restraint_start_time, $restraint_closing_time);

                        $employee_data = array(
                            "emplo_id" => $emplo_id,
                            "name" => $name,
                            "password" => $password,
                            "subord_authority" => $subord_authority,
                            "management_emplo_id" => $management_emplo_id,
                            "restraint_start_time" => $restraint_start_time,
                            "restraint_closing_time" => $restraint_closing_time,
                            "retirement_authority" => $retirement_authority,
                            "restraint_total_time" => $restraint_total_time,
                            "hire_date" => $hire_date,
                            "short_working" => $short_working
                        );

                        $emplo_id++;
                        array_push($employee_data_list, $employee_data);
                    }
                }

                if (!is_null(!$employee_data_list)) {
                    $message = "ファイルの読込に失敗しました。処理を中断します。";
                    return back()->with('warning', $message);
                }

                foreach ($employee_data_list as $employee_data) {
                    if (!isset($employee_list[$employee_data["name"]])) {
                        Common::insertEmployee(
                            $employee_data["emplo_id"],
                            $employee_data["name"],
                            $employee_data["password"],
                            $employee_data["management_emplo_id"],
                            $employee_data["subord_authority"],
                            $employee_data["retirement_authority"],
                            $employee_data["hire_date"],
                            $employee_data["restraint_start_time"],
                            $employee_data["restraint_closing_time"],
                            $employee_data["restraint_total_time"],
                            $employee_data["short_working"]
                        );
                        $employee_list[$employee_data["name"]] = true;
                    }
                }

                $count = count($employee_list);
                $message = "$count 人の登録が完了しました。";
                return back()->with('status', $message);
            }
            $message = "Excelファイルではありません。";
            return back()->with('warning', $message);
        }
        $message = "ファイルが選択されていません。";
        return back()->with('warning', $message);
    }
}
