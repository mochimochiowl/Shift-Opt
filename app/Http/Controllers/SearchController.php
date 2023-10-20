<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\SearchAtRecordsRequest;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Response;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Userテーブル 検索画面を返す
     * @return View
     */
    public function showUsers(Request $request): View
    {
        if (!$request->input('column')) { //検索画面を開いたとき
            $results = null;
            $search_requirements = [
                'search_field' => null,
                'keyword' => null,
                'column' => null,
                'order' => null,
                'search_field_jp' => null,
            ];
        } else { //検索を実行したとき
            $search_field = $request->input('search_field');
            $keyword = $request->input('keyword');
            $search_requirements = [
                'search_field' => $search_field,
                'keyword' => $keyword,
                'column' => $request->input('column') ?? ConstParams::USER_ID,
                'order' => $request->input('order') ?? 'asc',
                'search_field_jp' => $this->getFieldNameJP($search_field),
            ];
            $results = $this->searchUsers($search_requirements);
        }

        return view('users/search', [
            'results' => $results,
            'search_requirements' => $search_requirements,
        ]);
    }

    /**
     * Userテーブル内を検索する
     * @return LengthAwarePaginator
     */
    private function searchUsers(array $search_requirements): LengthAwarePaginator
    {
        $search_field = $search_requirements['search_field'];
        $keyword = $search_requirements['keyword'] ?? '_';
        $column = $search_requirements['column'];
        $order = $search_requirements['order'];

        return User::searchByKeyword($search_field, $keyword, $column, $order);
    }

    /**
     * at_recordsテーブル 検索画面を返す
     * @return View
     */
    public function showAtRecords(Request $request): View
    {
        if (!$request->input('column')) { //検索画面を開いたとき
            $results = null;
            $search_requirements = [
                'start_date' => null,
                'end_date' => null,
                'search_field' => null,
                'keyword' => null,
                'column' => null,
                'order' => null,
                'search_field_jp' => null,
            ];
        } else { //検索を実行したとき
            $search_field = $request->input('search_field') ?? 'all';
            $keyword = $request->input('keyword') ?? 'empty';
            if ($search_field === 'all') {
                $keyword = 'all';
            }
            $search_requirements = [
                'start_date' => $request->input('start_date'),
                'end_date' => $request->input('end_date'),
                'search_field' => $search_field,
                'keyword' => $keyword,
                'column' => $request->input('column'),
                'order' => $request->input('order'),
            ];

            $results = $this->searchAtRecords($search_requirements, false);

            $search_requirements['search_field_jp'] = $this->getFieldNameJP($search_requirements['search_field']);
        }

        $default_dates = $this->defaultDates();
        return view('at_records/search', [
            'results' => $results,
            'search_requirements' => $search_requirements,
            'default_dates' => $default_dates,
        ]);
    }

    /**
     * 検索条件に基づく at_recordsテーブル 検索結果 をCSV出力する
     */
    public function exportAtRecordCsv(Request $request)
    {
        //検索
        $data = [
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
            'search_field' => $request->input('search_field'),
            'keyword' => $request->input('keyword'),
            'column' => $request->input('column'),
            'order' => $request->input('order'),
        ];
        $results = $this->searchAtRecords($data, true);

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="AtRecords_' . $data['start_date'] . '_' . $data['end_date']  . '.csv"',
        ];

        // 出力データの作成
        $output = fopen('php://temp', 'r+');
        fputcsv($output, [
            ConstParams::AT_RECORD_ID_JP,
            ConstParams::USER_ID_JP,
            ConstParams::AT_RECORD_TYPE_JP,
            ConstParams::AT_RECORD_TYPE_TRANSLATED_JP,
            ConstParams::AT_RECORD_DATE_JP,
            ConstParams::AT_RECORD_TIME_JP,
            ConstParams::CREATED_BY_JP,
            ConstParams::UPDATED_BY_JP,
            ConstParams::CREATED_AT_JP,
            ConstParams::UPDATED_AT_JP,
        ]);

        foreach ($results as $result) {
            fputcsv($output, [
                $result[ConstParams::AT_RECORD_ID],
                $result[ConstParams::USER_ID],
                $result[ConstParams::AT_RECORD_TYPE],
                $result[ConstParams::AT_RECORD_TYPE_TRANSLATED],
                $result[ConstParams::AT_RECORD_DATE],
                $result[ConstParams::AT_RECORD_TIME],
                $result[ConstParams::CREATED_BY],
                $result[ConstParams::UPDATED_BY],
                $result[ConstParams::CREATED_AT],
                $result[ConstParams::UPDATED_AT],
            ]);
        }

        rewind($output);
        $csv = stream_get_contents($output);
        fclose($output);

        return Response::make($csv, 200, $headers);
    }

    /**
     * at_recordsテーブル内を検索する
     * @return LengthAwarePaginator|array
     */
    private function searchAtRecords(array $data, bool $asArray): LengthAwarePaginator | array
    {
        return AttendanceRecord::search($data, $asArray);
    }

    /**
     * 検索用の属性「search_field」に対応する日本語表記の項目名を返す
     * @return string
     */
    private function getFieldNameJP(string $search_field): string
    {
        switch ($search_field) {
            case ConstParams::USER_ID:
                return ConstParams::USER_ID_JP;
            case ConstParams::LOGIN_ID:
                return ConstParams::LOGIN_ID_JP;
            case 'name':
                return '名前（漢字・かな）';
            case ConstParams::EMAIL:
                return ConstParams::EMAIL_JP;
            case 'all':
                return '全件表示';
        }
    }

    /**
     * at_records 検索用に、開始日と終了日のデフォルト値を返す。
     * @return array
     */
    private function defaultDates(): array
    {
        $start_date = date('Y-m-d', strtotime('-1 week'));
        $end_date = date('Y-m-d', strtotime('+1 day'));
        return [
            'start_date' => $start_date,
            'end_date' => $end_date,
        ];
    }
}
