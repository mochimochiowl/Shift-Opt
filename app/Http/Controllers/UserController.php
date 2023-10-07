<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;

class UserController extends Controller
{
    public function showRegister()
    {
        return view('register/input');
    }

    public function showUserInfo(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        return view('userInfo', ['user' => $user]);
    }

    public function showLoggedInUserInfo()
    {
        $user = Auth::user();
        return view('userInfo', ['user' => $user]);
    }

    public function showLogin()
    {
        return view('login');
    }

    /** Userデータ（給与データや状態データを含む）の新規作成 */
    public function createUser(Request $request)
    {

        try {
            return DB::transaction(function () use ($request) {
                // Userの作成
                $user = User::query()->create(
                    [
                        ConstParams::KANJI_LAST_NAME => $request[ConstParams::KANJI_LAST_NAME],
                        ConstParams::KANJI_FIRST_NAME => $request[ConstParams::KANJI_FIRST_NAME],
                        ConstParams::KANA_LAST_NAME => $request[ConstParams::KANA_LAST_NAME],
                        ConstParams::KANA_FIRST_NAME => $request[ConstParams::KANA_FIRST_NAME],
                        ConstParams::EMAIL => $request[ConstParams::EMAIL],
                        ConstParams::LOGIN_ID => $request[ConstParams::LOGIN_ID],
                        ConstParams::PASSWORD => Hash::make($request[ConstParams::PASSWORD]),
                        ConstParams::CREATED_BY => '新規登録',
                        ConstParams::UPDATED_BY => '新規登録',
                    ]
                );

                Auth::login($user);

                $user_id = Auth::user()->user_id;
                // UserSalaryの作成
                $user->salary()->create([
                    ConstParams::USER_ID => $user_id,
                    ConstParams::HOURLY_WAGE => ConstParams::HOURLY_WAGE_DEFAULT,
                    ConstParams::CREATED_BY => '新規登録',
                    ConstParams::UPDATED_BY => '新規登録',
                ]);

                // UserConditionの作成
                $user->condition()->create([
                    ConstParams::USER_ID => $user_id,
                    ConstParams::HAS_ATTENDED => false,
                    ConstParams::IS_BREAKING => false,
                    ConstParams::CREATED_BY => '新規登録',
                    ConstParams::UPDATED_BY => '新規登録',
                ]);

                return redirect()->route('userInfo');
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . $e->getMessage()]);
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            ConstParams::LOGIN_ID => ['required'],
            ConstParams::PASSWORD => ['required'],
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

    public static function isExistUser(string $login_id): bool
    {
        if (UserController::findUser($login_id)) {
            return true;
        } else {
            return false;
        }
    }

    public static function findUser(string $login_id): User | null
    {
        return $user = User::where(ConstParams::LOGIN_ID, $login_id)->first();
    }
}
