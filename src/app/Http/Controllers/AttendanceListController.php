<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AttendanceListController extends Controller
{
    public function index(Request $request)
    {
        Carbon::setLocale('ja');

        $month = $request->query('month'); /*クエリパラメータのmonthを取得*/

        if (!$month) {
            $now = Carbon::now(); /*今月*/
        } else {
            $now = Carbon::parse($month); /*URLから来たmonthをcarbonで読み取って使う*/
        }

        $startOfMonth = $now->copy()->startOfMonth(); /*$nowを利用して、分身を作って(copy)、その分身だけ月初め*/
        $endOfMonth = $now->copy()->endOfMonth();

        $dates = [];

            while ($startOfMonth <= $endOfMonth){
            $dates[] = $startOfMonth->copy(); /*$datesの箱に$startOfMonthを１つ追加する*/
            $startOfMonth->addDay(); /*１つずつ追加*/
            }

        $attendances = Attendance::where ('user_id' , Auth::id())
        ->whereBetween('date' , [ /*期間指定*/
        $now -> copy()->startOfMonth()->toDateString(),
        $now ->copy()->endOfMonth()->toDateString()
    ])
    ->get(); /*全部取って来る*/

        return view('attendance-list', compact('now','dates','month' ,'attendances'));
    }

    

}
