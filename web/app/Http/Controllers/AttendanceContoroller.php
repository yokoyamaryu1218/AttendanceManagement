<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\Format;
use App\Libraries\php\Domain\DataBase;

class AttendanceContoroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // 今日の日付 フォーマット
        $today = date('Y-m-j');
        $format = new Format();
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
        $daily_data = DataBase::getDaily($emplo_id, $today);


        return view('employee.dashboard', compact(
            'ym',
            'today',
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
    public function daily_store(Request $request)
    {
        $emplo_id = Auth::guard('employee')->user()->emplo_id;
        $daily = $request->daily;
        $today = date('Y-m-j');
        $old_id = DataBase:: getId($emplo_id);
        $new_id = ($old_id[0]->id) + "1";

        DataBase::insertDaily($new_id,$emplo_id,$today,$daily);
        
        return back();
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
    public function update(Request $request)
    {
        //
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
