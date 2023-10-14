<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\SearchAtRecordsRequest;
use App\Http\Requests\SearchUserRequest;
use App\Models\AttendanceRecord;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * Userテーブル 検索画面を返す
     * @return View
     */
    public function showUsersSearchView(Request $request): View
    {
        $results = null;
        return view('users/search', [
            'results' => $results,
        ]);
    }

    /**
     * Userテーブル 検索結果を含んだ検索画面を返す
     * @return View
     */
    public function showUsersResult(SearchUserRequest $request): View
    {
        $results = $this->searchUsers($request);
        return view('users/search', [
            'results' => $results,
            'search_field' => $this->getFieldNameJP($request->search_field),
            'keyword' => $request->keyword,
        ]);
    }

    /**
     * Userテーブル内を検索する
     * @return Collection
     */
    private function searchUsers(Request $request): Collection
    {
        $keyword = $request->keyword ?? '';
        return User::searchByKeyword($request->search_field, $keyword);
    }

    /**
     * at_recordsテーブル 検索画面を返す
     * @return View
     */
    public function showAtRecordsSearchView(Request $request): View
    {
        $results = null;
        $messages = $request->messages ?? null;
        $default_dates = $this->defaultDates();
        return view('at_records/search', [
            'results' => $results,
            'messages' => $messages,
            'default_dates' => $default_dates,
        ]);
    }

    /**
     * at_recordsテーブル 検索結果を含んだ検索画面を返す
     * @return View
     */
    public function showAtRecordsResult(SearchAtRecordsRequest $request): View
    {
        $data = $request->validated();

        $results = $this->searchAtRecords($data);

        $messages = $request->messages ?? null;

        $search_requirements = $data;
        $search_requirements['search_field'] = $this->getFieldNameJP($search_requirements['search_field']);

        $default_dates = $this->defaultDates();

        return view('at_records/search', [
            'results' => $results,
            'messages' => $messages,
            'search_requirements' => $search_requirements,
            'default_dates' => $default_dates,
        ]);
    }

    /**
     * at_recordsテーブル内を検索する
     * @return Collection
     */
    private function searchAtRecords(array $data): Collection
    {
        return AttendanceRecord::search($data);
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
