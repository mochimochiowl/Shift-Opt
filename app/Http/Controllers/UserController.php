<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function showRegister()
    {
        return view('register/input');
    }

    public function showUserInfo()
    {
        $user = Auth::user();
        return view('register/userInfo', ['user' => $user]);
    }

    public function showLogin()
    {
        return view('login');
    }

    public function createUser(Request $request)
    {
        $user = User::query()->create(
            [
                'kanji_last_name' => $request['kanji_last_name'],
                'kanji_first_name' => $request['kanji_first_name'],
                'kana_last_name' => $request['kana_last_name'],
                'kana_first_name' => $request['kana_first_name'],
                'email' => $request['email'],
                'login_id' => $request['login_id'],
                'password' => Hash::make($request['password']),
                'created_by' => '新規登録',
                'updated_by' => '新規登録',
            ]
        );

        Auth::login($user);

        return redirect()->route('userInfo');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'login_id' => ['required'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('userInfo');
        }

        return back();
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
