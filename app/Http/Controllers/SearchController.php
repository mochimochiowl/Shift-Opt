<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function showSearchView(Request $request)
    {
        $results = null;
        return view('searchUser', ['results' => $results]);
    }

    public function showResult(Request $request)
    {
        $results = $this->searchUser($request);
        return view('searchUser', [
            'results' => $results,
            'search_field' => $this->getFieldNameJP($request->search_field),
            'keyword' => $request->keyword,
        ]);
    }

    private function searchUser(Request $request): Collection
    {
        $keyword = $request->keyword ?? '';

        if ($request->search_field === 'name') {
            return User::where('kana_last_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('kana_first_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('kanji_last_name', 'LIKE', '%' . $keyword . '%')
                ->orWhere('kanji_first_name', 'LIKE', '%' . $keyword . '%')
                ->get();;
        }

        if ($request->search_field === 'all') {
            return User::all();
        }

        return User::where($request->search_field, 'LIKE', '%' . $keyword . '%')->get();;
    }

    private function getFieldNameJP(string $search_field)
    {
        switch ($search_field) {
            case 'user_id':
                return USER_ID_JP;
            case 'login_id':
                return LOGIN_ID_JP;
            case 'name':
                return '名前（漢字・かな）';
            case 'email':
                return EMAIL_JP;
            case 'all':
                return '全件表示';
        }
    }
}
