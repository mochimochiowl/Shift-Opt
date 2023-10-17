<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TopController extends Controller
{
    public function get()
    {
        return view('top', [
            'date' => getToday(),
        ]);
    }

    public function post(Request $request)
    {
        return view('top', [
            'date' => $request->input('date') ?? getToday(),
        ]);
    }
}
