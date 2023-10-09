<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function showRegister()
    {
        return view('register/input');
    }

    public function showUserInfo($user_id)
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        return view('userInfo', ['user' => $user]);
    }

    public function showLoggedInUserInfo()
    {
        $user = Auth::user();
        return view('userInfo', ['user' => $user]);
    }

    public function indexUserEdit(Request $request)
    {
        $user = null;
        return view('userEdit', ['user' => $user]);
    }

    public function showUserEdit($user_id)
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        return view('userEdit', ['user' => $user]);
    }

    public function showLogin()
    {
        return view('login');
    }

    /** Userデータ（給与データや状態データを含む）の新規作成 */
    public function createUser(Request $request)
    {
        // バリデーションルールの定義
        $rules = [
            ConstParams::KANJI_LAST_NAME => 'required',
            ConstParams::KANJI_FIRST_NAME => 'required',
            ConstParams::KANA_LAST_NAME => 'required',
            ConstParams::KANA_FIRST_NAME => 'required',
            ConstParams::EMAIL => 'required|email',
            ConstParams::LOGIN_ID => 'required',
            ConstParams::PASSWORD => 'required',
        ];

        // エラーメッセージ
        $messages = [
            'required' => ':attributeを入力してください。',
            'email' => 'メールアドレスの形式が正しくありません。',
        ];

        //属性名
        $attributes = [
            ConstParams::KANJI_LAST_NAME => ConstParams::KANJI_LAST_NAME_JP,
            ConstParams::KANJI_FIRST_NAME => ConstParams::KANJI_FIRST_NAME_JP,
            ConstParams::KANA_LAST_NAME => ConstParams::KANA_LAST_NAME_JP,
            ConstParams::KANA_FIRST_NAME => ConstParams::KANA_FIRST_NAME_JP,
            ConstParams::EMAIL => ConstParams::EMAIL_JP,
            ConstParams::LOGIN_ID => ConstParams::LOGIN_ID_JP,
            ConstParams::PASSWORD => ConstParams::PASSWORD_JP,
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // バリデーション失敗時の処理
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except(ConstParams::PASSWORD));
        }

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

                return redirect()->route('users.show', [ConstParams::USER_ID => $user_id]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . $e->getMessage()])->withInput($request->except(ConstParams::PASSWORD));
        }
    }

    /** Userデータの更新 */
    public function updateUser($user_id, Request $request)
    {
        // バリデーションルールの定義
        $rules = [
            ConstParams::KANJI_LAST_NAME => 'required',
            ConstParams::KANJI_FIRST_NAME => 'required',
            ConstParams::KANA_LAST_NAME => 'required',
            ConstParams::KANA_FIRST_NAME => 'required',
            ConstParams::EMAIL => 'required|email',
            ConstParams::LOGIN_ID => 'required',
        ];

        // エラーメッセージ
        $messages = [
            'required' => ':attributeを入力してください。',
            'email' => 'メールアドレスの形式が正しくありません。',
        ];

        //属性名
        $attributes = [
            ConstParams::KANJI_LAST_NAME => ConstParams::KANJI_LAST_NAME_JP,
            ConstParams::KANJI_FIRST_NAME => ConstParams::KANJI_FIRST_NAME_JP,
            ConstParams::KANA_LAST_NAME => ConstParams::KANA_LAST_NAME_JP,
            ConstParams::KANA_FIRST_NAME => ConstParams::KANA_FIRST_NAME_JP,
            ConstParams::EMAIL => ConstParams::EMAIL_JP,
            ConstParams::LOGIN_ID => ConstParams::LOGIN_ID_JP,
            ConstParams::PASSWORD => ConstParams::PASSWORD_JP,
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $attributes);

        // バリデーション失敗時の処理
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except(ConstParams::PASSWORD));
        }

        try {
            return DB::transaction(function () use ($user_id, $request) {
                $count = User::where(ConstParams::USER_ID, '=', $user_id)->update(
                    [
                        ConstParams::KANJI_LAST_NAME => $request[ConstParams::KANJI_LAST_NAME],
                        ConstParams::KANJI_FIRST_NAME => $request[ConstParams::KANJI_FIRST_NAME],
                        ConstParams::KANA_LAST_NAME => $request[ConstParams::KANA_LAST_NAME],
                        ConstParams::KANA_FIRST_NAME => $request[ConstParams::KANA_FIRST_NAME],
                        ConstParams::EMAIL => $request[ConstParams::EMAIL],
                        ConstParams::LOGIN_ID => $request[ConstParams::LOGIN_ID],
                        ConstParams::UPDATED_BY => $request['logged_in_user_name'],
                    ]
                );

                $user = User::where(ConstParams::USER_ID, '=', $request[ConstParams::USER_ID])->first();
                return redirect()->route('users.update.result', [ConstParams::USER_ID => $user->user_id])->with(['user' => $user, 'count' => $count]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . $e->getMessage()]);
        }
    }

    public function showUserUpdateResult(Request $request)
    {
        return view('userEditResult', ['user' => session('user'), 'count' => session('count')]);
    }

    public function showUserDeleteConfirmation(Request $request)
    {
        $user = User::where('user_id', $request->user_id)->first();
        return view('userDeleteConfirmation', ['user' => $user]);
    }

    /** Userデータの更新 */
    public function deleteUser($user_id)
    {
        try {
            return DB::transaction(function () use ($user_id) {
                $count = User::where(ConstParams::USER_ID, '=', $user_id)->delete();
                return redirect()->route('users.delete.result', [ConstParams::USER_ID => $user_id])->with(['count' => $count]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . $e->getMessage()]);
        }
    }

    public function showUserDeleteResult(Request $request)
    {
        return view('userDeleteResult', ['count' => session('count')]);
    }

    /**
     * ログイン処理、バリデーションもここで定義
     */
    public function login(Request $request)
    {
        // 入力されたデータの検証
        $validator = Validator::make($request->all(), [
            ConstParams::LOGIN_ID => 'required|exists:users,login_id',
            ConstParams::PASSWORD => 'required',
        ], [
            ConstParams::LOGIN_ID . '.required' => 'ログインIDを入力して下さい。',
            ConstParams::LOGIN_ID . '.exists' => 'ログインIDが存在しません。',
            ConstParams::PASSWORD . '.required' => 'パスワードを入力して下さい。',
        ]);

        // 検証が失敗した場合
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput($request->except(ConstParams::PASSWORD));
        }

        $credentials = $request->only(ConstParams::LOGIN_ID, ConstParams::PASSWORD);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended(route('top'));
        }

        // パスワードが一致しない場合
        return back()->withErrors(['message' => 'パスワードが一致しません。'])->withInput($request->except(ConstParams::PASSWORD));
    }

    /**
     * ログアウト処理 トップ画面に戻る
     */
    public function logout()
    {
        Auth::logout();
        return redirect(route('top'));
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
