<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;

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
    public function index()
    {
        $emplo_id = Auth::guard('employee')->user()->emplo_id;

        // https://codeforfun.jp/php-calendar/
        if (isset($_GET['ym'])) {
            $ym = $_GET['ym'];
        } else {
            // 今月の年月を表示
            $ym = date('Y-m');
        }

        $timestamp = strtotime($ym . '-01');
        if ($timestamp === false) {
            $ym = date('Y-m');
            $timestamp = strtotime($ym . '-01');
        }

        // 今日の日付 フォーマット　例）2021-06-3
        $today = date('Y-m-j');
        $day_count = date('t', $timestamp);

        $monthly = new DataBase();
        $monthly_data = $monthly->getMonthly($emplo_id, $ym);
        echo('<pre>');
        var_dump($monthly_data);
        echo('</pre>');

        $i = 1;
        $work = $monthly_data[date('Y-m-d', strtotime($ym . '-' . $i))];
        $start_time = $work['start_time'];
        $end_time = $work['end_time'];
        $lest_time = $work['lest_time'];
        $achievement_time = $work['achievement_time'];
        $daily = $work['daily'];

        dd($start_time, $end_time, $lest_time, $achievement_time, $daily);

        return view('menu.monthly', compact(
            'monthly_data',
            'day_count',
            'ym',
            'start_time',
            'end_time',
            'lest_time',
            'achievement_time',
            'daily',
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
        //
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
    public function update(Request $request, $id)
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
