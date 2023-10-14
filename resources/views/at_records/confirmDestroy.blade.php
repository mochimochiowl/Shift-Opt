@extends('layouts.base')
@section('title', ConstParams::AT_RECORD_JP . '削除確認画面')
@section('content')
<div>
    <p>以下のデータを削除します。</p>
    <p>データを一度削除すると、戻すことはできません。</p>
    <p>【削除対象のデータ詳細】</p>
    @component('components.atRecordShow', ['data' => $data])
    @endcomponent
</div>
<div>
    <p>本当に削除してもよろしいですか？</p>
    <form action="{{route('at_records.delete', [ConstParams::AT_RECORD_ID => $data[ConstParams::AT_RECORD_ID]])}}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">この{{ConstParams::AT_RECORD_JP}}を削除する</button>
    </form>
</div>
@endsection

@section('footer')
    copyright 2023 CoderOwlWing
@endsection