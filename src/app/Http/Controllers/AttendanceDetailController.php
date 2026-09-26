<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\AttendanceRequest;
use App\Models\RestRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceDetailController extends Controller
{
    public function show($id)
    {
        $attendance = Attendance::findOrFail($id);

        $pendingRequest = AttendanceRequest::where('attendance_id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending') //statusがpending(承認待ち)の申請を探して//
            ->latest()->first();

        return view('attendance-detail', compact('attendance' , 'pendingRequest'));
    }

    public function store(Request $request, $id)
    {
        $attendanceRequest = AttendanceRequest::create([
            'user_id' => Auth::id(),
            'attendance_id' => $id,
            'clock_in' => $request->clock_in,
            'clock_out' => $request->clock_out,
            'remarks' => $request->remarks,
            'status' => 'pending',
        ]);

        foreach ($request->input('rests', []) as $restId => $restDate) { /*既存の休憩が複数ある場合のみforeach使用*/

            if (empty($restDate['rest_start']) && empty($restDate['rest_end'])) {
                continue;
            }

            RestRequest::create([
                'attendance_request_id' => $attendanceRequest->id,
                'rest_id' => is_numeric($restId) ? $restId : null,
                'rest_start' => $restDate['new_rest_start'],
                'rest_end' => $restDate['new_rest_end'],
            ]);
        }

        return redirect()->route('attendance.detail', ['id' => $id])
            ->with('message', '修正申請を送信しました。');
    }
}
