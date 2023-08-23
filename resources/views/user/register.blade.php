<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>買い物リスト</title>
    </head>
    <body>
        <h1>ユーザ登録</h1>
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        <form action="/user/register" method="post">
            @csrf
            名前:<input name="name" type="name"><br>
            email：<input name="email"><br>
            パスワード：<input  name="password" type="password"><br>
            パスワード(再度)：<input  name="password" type="password"><br>
            <button>登録する</button>
        </form>
    </body>
</html>