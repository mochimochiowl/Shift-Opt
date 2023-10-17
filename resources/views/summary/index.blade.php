@extends('layouts.base')
@section('title', 'サマリー画面')
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{route('summary.post')}}" method="POST">
    @csrf
    <div>
        <label for="date">日付 : </label>
        <input type="date" name="date" id="date" value="{{old('date', getToday())}}">
        <input type="submit" value="更新">
    </div>
</form>
@if ($data)
<h2>{{$data['date']}} の サマリー</h2>
<table>
    <thead>
        <tr>
            <th>名前</th>
            <th>入｜出</th>
            <th>労働時間時間</th>
            <th>休憩時間</th>
            <th>人件費</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($data['rows'] as $row)
        <tr>
            <td>{{$row['name']}}</td>
            <td>{{$row['start_work_time']}} | {{$row['finish_work_time']}}</td>
            <td>{{$row['working_hours']}}</td>
            <td>{{$row['breaking_hours']}}</td>
            <td>{{$row['cost_of_labor']}}</td>
        </tr>
    @endforeach
    <tr>
        <td>合計</td>
        <td>ー</td>
        <td>{{$data['sums']['working_hours']}}</td>
        <td>{{$data['sums']['breaking_hours']}}</td>
        <td>{{$data['sums']['cost_of_labor']}}</td>
    </tr>
    </tbody>
</table>
@else
    <p>dataがありません。</p>
@endif

@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection