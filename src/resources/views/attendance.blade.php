@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
                    <div class="attendance">
                        <div class="attendance-inner">

                        <div class="attendance-status">
                            <div class="attendance-status__display">
                                <div class="attendance-status__info">
                            @if(!$attendance) <!--もし$attendanceがないなら -->
                            <div class="attendance-status__working">
                                勤務外
                            </div>

                            @elseif($attendance->clock_out)
                            <div class="attendance-status__working">退勤済
                                </div>

                            @elseif($rest)
                            <div class="attendance-status__working">休憩中
                                    </div>

                            @else
                            <div class="attendance-status__working">
                                出勤中
                            </div>
                            @endif

                        </div>
                            </div>

                            <div class="attendance-display">
                                <p class="attendance__date">
                                {{ $now->isoFormat('YYYY年M月D日(ddd)') }}</p>

                                <p class="attendance__time">
                                {{ $now->format('H:i') }}</p>
                            </div>

                </div>

                @if(!$attendance)<!--出勤-->

                <form action="/attendance/clock-in" method="post">
                    @csrf
                    <div class="attendance-form">
                        <button class="attendance-form_button" type="submit" name="attendance">出勤
                        </button>
                        </div>
    </form>

                        @elseif($attendance->clock_out)
                            <div class="attendance-form__option">
                                <!--退勤済-->
                                <form action="/attendance/clock-out" method="post">
                                    @csrf
                                @if(session('message'))
    <p class="attendance-message">
        {{ session('message') }}
    </p>
</form>
@endif
    </div>

                                @elseif($rest)
                                    <form action="/attendance/rest-end" method="post">
                                        @csrf
                                    <div class="attendance-form__option">
                                        <button class="attendance-form_button-off" type="submit" name="attendance">休憩戻
                                        </button>
                                        </div>
                                    </form>

                                @else
                                    <div class="attendance-form__option">

                                        <form action="/attendance/clock-out" method="post">
                                            @csrf
                                            <button class="attendance-form_button" type="submit" name="attendance_out">
                                                退勤
                                            </button>
                                        </form>

                                        <form action="/attendance/rest-start" method="post">
                                            @csrf
                                            <button class="attendance-form_button-off" type="submit">
                                                休憩入
                                            </button>
                                        </form>

                                    </div>
                                @endif



                        </div>
                    </div>









@endsection