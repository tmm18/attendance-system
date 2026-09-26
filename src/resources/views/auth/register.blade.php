@extends('layout.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/auth/register.css') }}">
@endsection

@section('content')
    <div class="register">
        <div class="register-inner">
            <div class="register-corner">
                <p class="register-title">会員登録</p>
            </div>

            <div class="register-format">
                <form class="register-form" action="/register" method="post">
                    @csrf

                    <div class="register-info">
                        <div class="register-info__title">名前</div>
                        <input class="register-info__form" type="text" name="name" value="{{ old('name') }}">
                        <div class="register-error">
                            @error('name')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="register-info">
                        <div class="register-info__title">メールアドレス</div>
                        <input class="register-info__form" type="email" name="email" value="{{ old('email') }}">
                        <div class="register-error">
                            @error('email')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="register-info">
                        <div class="register-info__title">パスワード</div>
                        <input class="register-info__form" type="password" name="password">
                        <div class="register-error">
                            @error('password')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>

                    <div class="register-info">
                        <div class="register-info__title">確認用パスワード</div>
                        <input class="register-info__form" type="password" name="password_confirmation">
                    </div>

                    <div class="register-push">
                        <button class="register-push__button" type="submit" name="register">登録する</button>
                    </div>
                </form>

                <div class="registration">
                    <a href="/login" class="registration-button">ログインはこちら</a>
                </div>

            </div>
        </div>
    </div>
@endsection