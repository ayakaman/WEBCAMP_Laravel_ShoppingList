@extends('layout')

{{-- メインコンテンツ --}}
@section('contets')
        <h1>「買うもの」の登録</h1>
        @if ($errors->any())
            <div>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
            </div>
        @endif
        @if (session('front.user_register_success') == true)
            「買うもの」を登録しました！！<br>
        @endif
        <form action="/login" method="post">
            @csrf
            「買うもの」名:<input name="name" value="{{ old('name') }}"><br>
            <button>「買うもの」を登録する</button><br>
        </form>
        <h1>「買うもの」一覧</h1>
        <a href="/completed_tasks/list">購入済み「買うもの」一覧</a><br>
        <table border="1">
        <tr>
            <th>登録日
            <th>「買うもの」名
         <tr>
            <td>
            <td>
            <td><form action="./top.html"><button>完了</button></form>
            <td>
            <td><form action="./html"><button>削除</button></form>
        </table>
        <!-- ページネーション -->
        {{-- $list->links() --}}
        現在 1 ページ目<br>
        <a href="./top.html">最初のページ(未実装)</a> /
        <a href="./top.html">前に戻る(未実装)</a> /
        <a href="./top.html">次に進む(未実装)</a>
        <br>
        <hr>
        <menu label="リンク">
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection