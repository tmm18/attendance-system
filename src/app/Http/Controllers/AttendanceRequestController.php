<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Models\User;

class AttendanceRequestController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'pending');

        $status = $tab === 'approved'
            ? 'approved' : 'pending';
            //選択されたタブがapprovedか？ ?(yes):approved取得　:(no) pending取得//

        $attendanceRequests = AttendanceRequest::with([
            'user',
            'attendance',
        ])
            ->where('user_id', Auth::id())
            ->where('status', $status)
            ->latest()->get();

            
        return view(
            'attendance-request-list',
            compact('attendanceRequests', 'tab')
        );
    }
}
