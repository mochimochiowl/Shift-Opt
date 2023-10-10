<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\SearchUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SearchController extends Controller
{
    /**
     * 検索画面を返す
     * @return View
     */
    public function showSearchView(Request $request): View
    {
        $results = null;
        return view('search/index', ['results' => $results]);
    }

    /**
     * 検索結果を含んだ検索画面を返す
     * @return View
     */
    public function showResult(SearchUserRequest $request): View
    {
        $results = $this->searchUser($request);
        return view('search/index', [
            'results' => $results,
            'search_field' => $this->getFieldNameJP($request->search_field),
            'keyword' => $request->keyword,
        ]);
    }

    /**
     * Userテーブル内を検索する
     * @return Collection
     */
    private function searchUser(Request $request): Collection
    {
        $keyword = $request->keyword ?? '';
        return User::searchByKeyword($request->search_field, $keyword);
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
}
