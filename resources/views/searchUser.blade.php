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
    <form action="/search/user/result" method="post">
        @csrf
        <div>
            <div>
                <label for="table_name">テーブル名（半角英数字）</label>
            </div>
            <div>
                <input type="text" name="table_name" id="table_name">
            </div>
        </div>
        <div>
            <button type="submit">表示</button>
        </div>
    </form>
    @if ($results)
    <table>
        <thead>
            <tr>
                <th>user_id</th>
                <th>kanji_last_name</th>
                <th>kanji_first_name</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{$result->user_id}}</td>
                <td>{{$result->kanji_last_name}}</td>
                <td>{{$result->kanji_first_name}}</td>
                <td>
                    <form action="/search/user/info" method="post">
                        @csrf
                        <input type="hidden" name="user_id" value="{{$result->user_id}}">
                        <input type="submit" value="詳細">
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
</body>