<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Libraries\php\Domain\Time;

// 部下一覧のコントローラー
class SubordController extends Controller
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
        if (Auth::guard('employee')->user()->subord_authority == "1") {
            $emplo_id = Auth::guard('employee')->user()->emplo_id;

            $subord = new DataBase();
            $subord_authority = $subord->subord_authority($emplo_id);
            $subord_data = $subord->getSubord($emplo_id);

            return view('menu.subord.subord', compact('subord_data'));
        }
        return redirect('/');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $subord_id = $request->subord_id;
        $subord_name = $request->subord_name;

        return view('menu.subord.change-password', compact(
            'subord_id',
            'subord_name',
        ));
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $subord_id = $request->subord_id;
        $subord_name = $request->subord_name;
        $password = Hash::make($request->password);
        $password_confirmation = $request->password_confirmation;

        // 新しいパスワードを確認
        if (!password_verify($request->password, password_hash($password_confirmation, PASSWORD_DEFAULT))) {
            return redirect()->route('employee.subord.change_password', compact(
                'subord_id',
                'subord_name',
            ))->with('warning', '新しいパスワードが合致しません。');
        }

        // パスワードは6文字以上あるか，2つが一致しているかなどのチェックF
        $this->validator($request->all())->validate();

        // パスワードを保存
        Database::subord_updatepassword($password, $subord_id);

        return redirect()->route('employee.subord.change_password', compact(
            'subord_id',
            'subord_name',
        ))->with('status', 'パスワードを変更しました');
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
            $restraint_start_time = Database::getRestraintStartTime($emplo_id);
            $restraint_total_time = Database::getRestraintTotalTime($emplo_id);

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
            $restraint_start_time = Database::getRestraintStartTime($emplo_id);
            $restraint_total_time = Database::getRestraintTotalTime($emplo_id);

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
