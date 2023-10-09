<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Userテーブル検索画面</title>
    <style>
        table {
            border-collapse: collapse;
            width: 30%;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid black;
            padding: 8px 12px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Userテーブル検索画面</h1>
    @if(session('errors'))
        <div class="alert alert-danger">
            {{ session('errors')->first('message') }}
        </div>
    @endif
    <a href="/">トップ画面に戻る</a>
    <form action="{{route('users.search.result')}}" method="post">
        @csrf
        <h2>検索条件選択・入力</h2>
        <div>
            <label>
                <input type="radio" name="search_field" value="user_id" required> {{ConstParams::USER_ID_JP}}
            </label>
            <label>
                <input type="radio" name="search_field" value="login_id" required> {{ConstParams::LOGIN_ID_JP}}
            </label>
            <label>
                <input type="radio" name="search_field" value="name"> 名前（漢字・かな）
            </label>
            <label>
                <input type="radio" name="search_field" value="email"> {{ConstParams::EMAIL_JP}}
            </label>
            <label>
                <input type="radio" name="search_field" value="all"> 全件表示
            </label>
        </div>

        <div>
            <input type="text" name="keyword" placeholder="キーワードを入力してください">
            <input type="submit" value="検索">
        </div>
    </form>

    @if ($results)
    <h2>検索ワード</h2>
    <div>
        <p>検索種類   : {{$search_field}}</p>
        <p>検索ワード : {{$keyword}}</p>
        <p>ヒット件数 : {{$results->count()}}</p>
    </div>
    <h2>検索結果</h2>
    <table>
        <thead>
            <tr>
                <th>{{ConstParams::USER_ID_JP}}</th>
                <th>{{ConstParams::KANJI_LAST_NAME_JP}}</th>
                <th>{{ConstParams::KANJI_FIRST_NAME_JP}}</th>
                <th>詳細</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{$result->user_id}}</td>
                <td>{{$result->kanji_last_name}}</td>
                <td>{{$result->kanji_first_name}}</td>
                <td>
                    <a href="{{route('users.show', [ConstParams::USER_ID => $result->user_id])}}">詳細</a>
                </td>
                <td>
                    <a href="{{route('users.edit', [ConstParams::USER_ID => $result->user_id])}}">編集</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</body>