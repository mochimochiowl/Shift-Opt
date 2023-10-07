<?php

namespace App\Http\Controllers;

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

    public function showUserInfo()
    {
        $user = Auth::user();
        return view('register/userInfo', ['user' => $user]);
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

                $user_id = Auth::user()->user_id;
                // UserSalaryの作成
                $user->salary()->create([
                    'user_id' => $user_id,
                    'hourly_wage' => HOURLY_WAGE_DEFAULT,
                    'created_by' => '新規登録',
                    'updated_by' => '新規登録',
                ]);

                // UserConditionの作成
                $user->condition()->create([
                    'user_id' => $user_id,
                    'has_attended' => false,
                    'is_breaking' => false,
                    'created_by' => '新規登録',
                    'updated_by' => '新規登録',
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
        return $user = User::where('login_id', $login_id)->first();
    }

    public static function getAllUser(): Collection
    {
        return User::all();
    }

    public static function getAllUserArray(): array
    {
        return User::all()->toArray();
    }
}
