@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/login.css') }}">
@endsection

@section('content')
    <div class="login">
        <div class="login-inner">

            <div class="login-corner">
                <p class="login-title">ログイン</p>
            </div>

            <div class="login-format">
                <form class="login-push" action="/login" method="post">
                        @csrf
                <div class="login-info">
                    <div class="login-info__title">メールアドレス</div>
                    <input class="login-info__form" type="email" name="email" value="">
                    <div class="login-error">
                        @error('email')
                            {{ $message }}
                        @enderror
                    </div>

                    <div class="login-info">
                        <div class="login-info__title">パスワード</div>
                        <input class="login-info__form" type="password" name="password" value="">
                    </div>
                    <div class="login-error">
                        @error('password')
                            {{ $message }}
                        @enderror
                    </div>

                        <button class="login-push__button" type="submit" name="login">ログインする</button>

                        <div class="login-error">
                            @error('login')
                            <div style="color: red;">{{ $message }}</div>
                            @enderror
                        </div>
</form>
                        <div class="registration">
                            <a href="/register" class="registration-button">会員登録はこちら</a>
                        </div>
                </div>

            </div>
        </div>

    </div>
    </div>


@endsection