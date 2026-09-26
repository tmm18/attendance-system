@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance-detail.css') }}">
@endsection

@section('content')
            <div class="attendance-detail">
                <div class="attendance-detail__inner">
                <div class="attendance-list-title">
                    | 勤怠詳細
                </div>

                <div class="attendance-detail__table">
                    <div class="attendance-detail__table-inner">

                    <form action="/attendance/detail/{{ $attendance->id }}" method="post">
                        @csrf

                    <div class="attendance-detail__subject">
                <table>
                    <tr>
                        <th>名前</th>
                        <td>{{ $attendance->user->name }}</td> <!--その日の勤怠を持っているユーザーの名前-->
                    </tr>

                    <tr>
                        <th>日付</th>
                        <td>{{ $attendance->date }}</td>
                    </tr>

                    <tr>
                        <th>出勤・退勤</th>
                        <td>
                        <input type="time" name="clock_in" value="{{ \Carbon\Carbon::parse($pendingRequest ? $pendingRequest->clock_in :$attendance->clock_in)
                        ->format('H:i') }}"
                        >

                        <span>～</span>

                        <input type="time" name="clock_out" value="{{ \Carbon\Carbon::parse($pendingRequest ? $pendingRequest->clock_out : $attendance->clock_out)
                        ->format('H:i') }}"
                        >
                        </td>
                    </tr>

                    @foreach ($attendance->rests as $rest)
            <tr>
                <th>
                    @if ($loop->first)
                        休憩
                    @else
                        休憩{{ $loop->iteration }} <!--これはforeachが今何回目かを表す-->
                    @endif
                </th>

                <td>
                    <input
                        type="time"
                        name="rests[{{ $rest->id }}][rest_start]"
                        value="{{ \Carbon\Carbon::parse($rest->rest_start)->format('H:i') }}"
                        {{ $pendingRequest ? 'disabled' : '' }}
                    >

                    <span>〜</span>

                    <input
                        type="time"
                        name="rests[{{ $rest->id }}][rest_end]"
                        value="{{ \Carbon\Carbon::parse($rest->rest_end)->format('H:i') }}"
                        {{ $pendingRequest ? 'disabled' : '' }}
                    >
                </td>
            </tr>
        @endforeach

        @php
    $nextRestNumber = $attendance->rests->count() + 1; /*次の休憩番号を計算する処理*/
        @endphp

        <tr>
            <th>
                @if($nextRestNumber === 1)
                休憩
                @else
                休憩{{ $nextRestNumber }}
                @endif
            </th>

            <td>
                <input type="time" name="new_rest_start">
                <span>～</span>
                <input type="time" name="new_rest_end"> <!--value指定してないので、中身が空の入力欄-->
            </td>
        </tr>
                    <tr>
                        <th>備考</th>
                        <td>
                            <textarea name="remarks" {{ $pendingRequest ? 'disabled' : '' }}>{{ $pendingRequest ? $pendingRequest->remarks : '' }}</textarea>
                        </td>
                    </tr>
    </table>

                    @if ($pendingRequest)
                    <p class="pending-message">
                        承認待ちのため修正できません。
                    </p>

                    @else
                    <button type="submit">修正</button>
                    @endif

                </form>
            </div>
            </div>
            </div>

            @if(session('message'))
            <p class="message">
                {{ session('message') }}
            </p>
            @endif
            
            </div>
            </div>

@endsection