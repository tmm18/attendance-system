@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance-request-list.css') }}">
@endsection

@section('content')
<div class="attendance-request-list">
    <div class="attendance-request-list__inner">

        <div class="attendance-list-title">
            | 申請一覧
        </div>

        <div class="attendance-request-list__approval">
        <a href="{{ route('attendance.request.list', ['tab' => 'pending']) }}">
            承認待ち
        </a>
        
        <a href="{{ route('attendance.request.list', ['tab' => 'approved']) }}">
            承認済み
        </a>

        <tbody>
        @forelse ($attendanceRequests as $requestItem)
                <tr>
                    <td>
                        {{ $requestItem->status === 'pending'
                ? '承認待ち'
                : '承認済み' }}
                    </td>

                    <td>{{ $requestItem->user->name }}</td>

                    <td>{{ $requestItem->attendance->date }}</td>

                    <td>{{ $requestItem->created_at->format('Y/m/d') }}</td>

                    <td>{{ $requestItem->remarks }}</td>

                    <td>{{ $requestItem->created_at->format('Y/m/d') }}</td>

                    <td>
                        <a href="{{ route('attendance.detail', [
                'id' => $requestItem->attendance_id
            ]) }}">
                            詳細
                        </a>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="6">申請はありません。</td>
                </tr>
        @endforelse
        </tbody>
    </div>

    @endsection