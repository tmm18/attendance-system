<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>勤怠管理</title>

    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/common.css') }}" />

    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <a class="header__logo" href="/register">
                <img src="{{ asset('img/COACHTECHヘッダーロゴ.png') }}" alt="COACHTECH">
            </a>

            @if (!(request()->is('login') || request()->is('register') || request()->is('verify')))

                <nav class="item-nav">
                    @auth
                        <form class="item-nav__logout-form" action="/logout" method="post">
                            @csrf
                        <a href="/attendance" class="item-link">勤怠</a>
                        <a href="/attendance/list" class="item-link">勤怠一覧</a>
                        <a href="/stamp_correction_request/list" class="item-link">申請</a>
                        <button type="submit" class="item-link item-link--button">ログアウト</button>
                        </form>

                    @else

                    @endauth
                </nav>
            @endif
        </div>
    </header>
        </div>
    </header>

    <main>
        @yield('content')
    </main>
</body>

</html>