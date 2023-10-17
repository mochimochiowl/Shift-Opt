<form action="{{route('top.post')}}" method="POST">
    @csrf
    <div>
        <label for="date">日付 : </label>
        <input type="date" name="date" id="date" value="{{old('date', getToday())}}">
        <input type="submit" value="更新">
    </div>
</form>

<h2>{{$data['date']}} の 実績</h2>
<table border="1">
    <thead>
        <tr>
            <th>氏名</th>
            <th>人件費</th>
            <th>労働時間</th>
            <th>休憩時間</th>
            <th>{{ConstParams::AT_RECORD_START_WORK_JP}}</th>
            <th>{{ConstParams::AT_RECORD_FINISH_WORK_JP}}</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>齋藤</td>
            <td>12000円</td>
            <td>8.00h</td>
            <td>1.00h</td>
            <td>9:05</td>
            <td>18:05</td>
        </tr>
        <tr>
            <td>齋藤</td>
            <td>12000円</td>
            <td>8.00h</td>
            <td>1.00h</td>
            <td>9:05</td>
            <td>18:05</td>
        </tr>
    </tbody>
</table>