@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance-list.css') }}">
@endsection

@section('content')
    <div class="attendance-list">
        <div class="attendance-list-inner">

            <div class="attendance-list-title">
                | 勤怠一覧
            </div>
            <div class="attendance-list-date">
                <div class="attendance-list-date__inner">
                    <a href="/attendance/list?month={{ $now->copy()->subMonth()->format('Y-m') }}">先月</a>
                    <p class="attendance-list-month">
                        {{ $now->isoFormat('YYYY年M月') }}
                    </p>
                    <a href="/attendance/list?month={{ $now->copy()->addMonth()->format('Y-m') }}">翌月</a>
                </div>

                <div class="attendance-list-table">
                    <div class="attendance-list-table__inner">

                        <div class="attendance-list-table__text">
                            <table>
                                <tr>
                                    <th>日付</th>
                                    <th>出勤</th>
                                    <th>退勤</th>
                                    <th>休憩</th>
                                    <th>合計</th>
                                    <th>詳細</th>
                                </tr>

                                @foreach ($dates as $date) <!--日付ローテーション-->
                                    <tr>
                                        @php
                                    $attendance = $attendances ->firstWhere(
                                    'date' , $date->toDateString()); //その日付を照合用に形にする//

                                    $restTotal = 0;

                                    if($attendance){
                                    foreach ($attendance->rests as $rest){

                                    $restStart = \Carbon\Carbon::parse($rest->rest_start);
                                    $restEnd = \Carbon\Carbon::parse($rest->rest_end);
                                    /*開始・終了を時刻として扱えるように*/

                                    $restTotal += $restStart->diffInMinutes($restEnd); /*その1件の休憩時間を分で出す*/
                                    /*+=休憩時間を合計に*/
                                    }
                                    }

                                    $hours = intdiv($restTotal,60); /*割り算*/
                                    $minutes = $restTotal % 60; /*余りを求める*/
                                    $restTime = sprintf('%02d:%02d', $hours, $minutes);

                                    $totalMinutes = 0;
                                    $workTotal = 0;
                                    $workTime = ''; /*空文字*/

                                    if($attendance && $attendance->clock_in && $attendance->clock_out){
                                    $clockIn =\Carbon\Carbon::parse($attendance->clock_in);
                                    $clockOut =\Carbon\Carbon::parse($attendance->clock_out);

                                    $totalMinutes = $clockIn->diffInMinutes($clockOut);
                                    $workTotal = $totalMinutes - $restTotal;
                                    }

                                    $hours = intdiv($workTotal,60);
                                    $minutes = $workTotal % 60;
                                    $workTime = sprintf('%02d:%02d' , $hours, $minutes);
                                    @endphp

                                        <td>{{ $date->isoFormat('MM/DD(ddd)') }}</td>
                                        <td>{{ $attendance?->clock_in }}</td>
                                        <td>{{ $attendance?->clock_out }}</td>
                                        <td>
                                        @if ($attendance && $attendance->rests->isNotEmpty()) <!--勤怠があるかつ休憩もある-->
                                        {{ $restTime }}
                                    @endif
                                    <!--$attendanceがあり、さらにrestsも空じゃなかったら$restTimeを表示する-->
                                </td>
                                        <td>{{$workTime}}</td>
                                        <td>
                                        @if($attendance)
                                        <a href="/attendance/detail/{{ $attendance->id }}">詳細</a>
                                        @else
                                        詳細
                                        @endif
                                    </td>
                                    </tr>


                                @endforeach


                            </table>

                        </div>
                    </div>
                </div>


















            </div>
        </div>


@endsection