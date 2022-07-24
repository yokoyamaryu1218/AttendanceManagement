<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use App\Libraries\php\Domain\Format;

// 勤怠一覧のコントローラー
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
    public function index(Request $request)
    {
        if ($request->subord_id) {
            $emplo_id = $request->subord_id;
        } else {
            $emplo_id = Auth::guard('employee')->user()->emplo_id;
        };


        if ($request->subord_name) {
            $emplo_name = $request->subord_name;
        } else {
            $emplo_name = Auth::guard('employee')->user()->name;
        };

        $format = new Format();
        $ym = $format->to_monthly();
        $day_count = date('t', strtotime($ym));
        $monthly_data = DataBase::getMonthly($emplo_id, $ym);

        return view('menu.monthly.monthly', compact(
            'monthly_data',
            'day_count',
            'emplo_id',
            'emplo_name',
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
        $emplo_name = $request->emplo_name;

        if (isset($request->monthly_change)) {
            $ym = $request->monthly_change;
            $day_count = date('t', strtotime($ym));
        } else {
            $ym = date('Y-m');
            $day_count = date('t');
        }

        $monthly_data = DataBase::getMonthly($emplo_id, $ym);
        $format = new Format();

        return view('menu.monthly.monthly', compact(
            'monthly_data',
            'day_count',
            'emplo_name',
            'emplo_id',
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
