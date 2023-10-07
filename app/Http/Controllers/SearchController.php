<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function showSearchView(Request $request)
    {
        $results = null;
        return view('search', ['results' => $results]);
    }

    public function showResult(Request $request)
    {
        $results = $this->search($request->table_name);
        return view('search', ['results' => $results]);
    }

    private function search(string $table_name)
    {
        return User::all();
    }
}
