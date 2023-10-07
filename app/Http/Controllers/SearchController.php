<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $results = $this->search($request->keyword);
        return view('searchUser', ['results' => $results]);
    }

    private function search(string $keyword)
    {
        return User::all();
    }
}
