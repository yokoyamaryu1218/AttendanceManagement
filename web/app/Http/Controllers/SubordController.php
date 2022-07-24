<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Libraries\php\Domain\DataBase;
use Illuminate\Http\Request;

// 部下一覧のコントローラー
class SubordController extends Controller
{
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
        } dd("閲覧権限がありません");
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
