<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>買い物リスト 管理画面 @yield('title')</title>
    </head>
    <body>
        <h1>管理画面 ログイン</h1>
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <form action="/admin/login" method="post">
            @csrf
            ログインID：<input name="login_id" value="{{ old('login_id') }}"><br>
            パスワード：<input  name="password" type="password"><br>
            <button>ログインする</button><br>
        </form>
  </body>
</html>