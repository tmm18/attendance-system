<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Rest;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function index()
    {
        Carbon::setLocale('ja');
        $now = Carbon::now();

        $attendance = Attendance::where('user_id', Auth::id()) /*attendanceテーブルから、今ログインしている人を探す*/
            ->where('date', Carbon::today()->toDateString()) /*日付が「今日」のもの*/
            ->first(); /*条件に当てはまった最初の1件をください*/

        $rest = $attendance /*まだ終了してない休憩を探す、今休憩中？*/
            ? $attendance->rests()-> /*このattendanceに紐づいてるrestsを探して*/
                whereNull('rest_end')-> /*rest_endがnullのものだけ探して*/ latest() /*新しい順*/ ->first() : null;

        return view('attendance' , compact('now','attendance','rest'));
    }

public function clockIn() /*保存*/
    {
        Attendance::create([ /*新しい1件を作る*/
            'user_id' => Auth::id(), /*今ログインしている人の*/
            'date' => Carbon::today(), /*何日の？*/
            'clock_in' => Carbon::now(), /*何時出勤*/
        ]);

        return redirect('/attendance');
    }

    public function restStart()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', Carbon::today()->toDateString())
            ->first();

        Rest::create([  /*新しい1件作成,休憩開始したので、新しい休憩記録をDBに保存する*/
            'attendance_id'=>$attendance->id, /*「この休憩は、どの勤怠記録の休憩か？」を登録する*/
            'rest_start'=>Carbon::now(), /*休憩開始時間*/
        ]);

        return redirect('/attendance');

    }

    public function restEnd()
    {
        $attendance = Attendance::where('user_id', auth::id())
        ->where('date' , Carbon::today()->toDateString())
        ->first();

        $rest = $attendance->rests() /*この勤怠に紐づいている休憩たち*/
        ->whereNull('rest_end')
        ->latest()->first();
        /*attendanceのrestsを使ってね
そこで終わってないrest_endの最新のものを1件ください*/

        $rest->update([ /*既存データ更新*/
            'rest_end' => Carbon::now(),
            /*rest_endにCarbonで取得した現在時刻を入れる*/
        ]);

        return redirect('/attendance');
    }

    public function clockOut()
    {
        $attendance = Attendance::where('user_id', Auth::id())
            ->where('date', Carbon::today()->toDateString())
            ->first();

        $attendance->update([
            'clock_out' => Carbon::now(),
        ]);

        return redirect('/attendance')
            ->with('message', 'お疲れさまでした');
    }
}
