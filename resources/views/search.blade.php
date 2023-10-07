<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Userテーブル検索画面</title>
</head>
<body>
    <h1>Userテーブル検索画面</h1>
    @if(session('errors'))
        <div class="alert alert-danger">
            {{ session('errors')->first('message') }}
        </div>
    @endif
    <form action="search/result" method="post">
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
        @foreach ($results as $result)
            <div>
                <form action="/search/userInfo" method="post">
                    @csrf
                    <input type="hidden" name="user_id" value="{{$result->user_id}}">
                    <div>
                        <span>{{$result->user_id}} : {{$result->getKanjiFullName()}}</span>
                        <input type="submit" value="詳細">
                    </div>
                </form>
            </div>
        @endforeach
    @endif
</body>