<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libraries\Time;
use App\Libraries\Common;
use App\Libraries\DataBase;
use App\Http\Requests\NewPostRequest;
use App\Http\Requests\UpdateRequest;
use App\Http\Requests\ManagementRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Pagination\LengthAwarePaginator;


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
     * @var App\Libraries\php\Domain\DataBase
     * @var array $retirement_authority 退職フラグ
     * @var array $employee_lists 在職者リスト
     * @var array $retirement_lists 退職者リスト
     */
    public function index(Request $request)
    {
        // 在職者だけを表示するため、退職フラグに0を付与
        try {
            $retirement_authority = "0";
            $employee_lists =  collect(DataBase::getEmployeeAll($retirement_authority));
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
            $retirement_lists = DataBase::getEmployeeAll("1");
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
     * @var App\Libraries\php\Domain\DataBase
     * @var array $retirement_authority 退職フラグ
     * @var array $retirement_lists 退職者リスト
     */
    public function retirement(Request $request)
    {
        try {
            $retirement_authority = "1";
            $employee_lists = collect(DataBase::getEmployeeAll($retirement_authority));
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
     * @var App\Libraries\php\Domain\DataBase
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
            $short_worker_lists = collect(DataBase::getshortWorker($retirement_authority, $short_working));
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
     * @var App\Libraries\php\Domain\DataBase
     * @var array $subord_authority_lists 管理者リスト
     */
    public function create()
    {
        // 管理者リストの取得
        try {
            $subord_authority_lists = DataBase::getSubordAuthority();
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
     * @var string $restraint_total_time 就業時間
     * @var string $retirement_authority 退職フラグ
     * @var string $short_working 時短フラグ
     * @var array $subord_authority 部下配属権限
     * @var App\Libraries\php\Domain\DataBase
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
        $id = DataBase::getID();
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
     * @var App\Libraries\php\Domain\DataBase
     * @var array $employee_lists 選択した従業員の詳細データ
     * @var array $subord_authority_lists 管理者リスト
     */
    public function show($emplo_id, $retirement_authority)
    {
        // 詳細画面の情報取得
        try {
            $employee_lists = DataBase::SelectEmployee($emplo_id, $retirement_authority);
        } catch (Exception $e) {
            $e->getMessage();
            return redirect()->route('admin.error');
        };

        // 管理者リストの取得
        try {
            $subord_authority_lists = DataBase::getSubordAuthority();
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
     * @var App\Libraries\php\Domain\DataBase
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
                $employee_lists =  collect(DataBase::getSearchID($retirement_authority, $request->search));
            } else {
                $employee_lists =  collect(DataBase::getSearchName($retirement_authority, $request->search));
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
            $retirement_lists = DataBase::getEmployeeAll("1");
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
     * @var string $restraint_total_time 就業時間
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
     * @var App\Libraries\php\Domain\DataBase
     * @var array $employee_lists 選択した従業員の詳細データ
     */
    public function reinstatement_check($emplo_id, $retirement_authority)
    {
        try {
            $employee_lists = DataBase::SelectEmployee($emplo_id, $retirement_authority);
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
     * @var App\Libraries\php\Domain\DataBase
     */
    public function reinstatement_action($emplo_id)
    {
        //退職フラグに0を付与し、退職日を消す
        $retirement_authority = "0";
        $retirement_date = NULL;

        try {
            DataBase::retirementAssignment($retirement_authority, $retirement_date, $emplo_id);
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
     * @var App\Libraries\php\Domain\DataBase
     * @var array $employee_lists 選択した従業員の詳細データ
     */
    public function destroy_check($emplo_id, $retirement_authority)
    {
        // 退職処理を行う従業員の情報取得
        try {
            $employee_lists = DataBase::SelectEmployee($emplo_id, $retirement_authority);
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
     * @var App\Libraries\php\Domain\DataBase
     */
    public function destroy(Request $request, $emplo_id)
    {
        //退職フラグに1を付与し、退職日を記録する
        $retirement_authority = "1";
        $retirement_date = $request->retirement_date;

        try {
            DataBase::retirementAssignment($retirement_authority, $retirement_date, $emplo_id);
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
     * @var array $working_hours 退職フラグ
     */
    public function management()
    {
        // 会社全体の就業時間の取得
        $working_hours = DataBase::Workinghours();

        //リダイレクト
        return view('menu.management.management01', compact(
            'working_hours',
        ));
    }

    /**
     * 就業時間の更新
     *
     * @param \Illuminate\Http\Request\ManagementRequest $request
     *
     * @var string $restraint_start_time  始業時間
     * @var string $restraint_closing_time 終業時間 
     * @var App\Libraries\php\Domain\Time
     * @var array $restraint_total_time 就業時間
     */
    public function update_workinghours(ManagementRequest $request)
    {
        //リクエストの取得
        $restraint_start_time = $request->restraint_start_time;
        $restraint_closing_time = $request->restraint_closing_time;
        $restraint_total_time = Time::restraint_total_time($restraint_start_time, $restraint_closing_time);

        DataBase::UpdateWorkinghours($restraint_start_time, $restraint_closing_time);
        DataBase::UpdateEmploAll($restraint_start_time, $restraint_closing_time, $restraint_total_time);

        //リダイレクト
        $message = "変更しました";
        return back()->with('status', $message);
    }
}
