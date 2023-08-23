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
        @if (session('front.shoppinglist_register_success') == true)
            「買うもの」を登録しました！！<br>
        @endif
        <form action="/shopping_list/register" method="post">
            @csrf
            「買うもの」名:<input name="name"><br>
            <button>「買うもの」を登録する</button><br>
        </form>
        <h1>「買うもの」一覧</h1>
        <a href="/completed_tasks/list">購入済み「買うもの」一覧（未実装）</a><br>
        <table border="1">
        <tr>
            <th>登録日
            <th>「買うもの」名
@foreach ($list as $shopping_list)
        <tr>
            <td>{{ $shopping_list->created_at->format('Y/m/d') }}
            <td>{{ $shopping_list->name }}
            <td><form action="./top.html"><button>完了</button></form>
            <td>
            <td><form action="./html"><button>削除</button></form>
@endforeach
        </table>
        <!-- ページネーション -->
        {{-- $list->links() --}}
        現在 {{ $list->currentPage() }} ページ目<br>
        @if ($list->onFirstPage() === false)
        <a href="/shopping_list/list">最初のページ</a>
        @else
        最初のページ
        @endif
        /
        @if ($list->previousPageUrl() !== null)
            <a href="{{ $list->previousPageUrl() }}">前に戻る</a>
        @else
            前に戻る
        @endif
        /
        @if ($list->nextPageUrl() !== null)
            <a href="{{ $list->nextPageUrl() }}">次に進む</a>
        @else
            次に進む
        @endif
        <br>
        <hr>
        <menu label="リンク">
        <a href="/logout">ログアウト</a><br>
        </menu>
@endsection