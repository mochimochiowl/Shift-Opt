<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * ユーザー登録画面を返す
     * @return View
     */
    public function showRegister(): View
    {
        return view('register/input');
    }

    /**
     * ユーザー情報詳細画面を返す
     * @return View
     */
    public function showUserInfo($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        return view('userInfo', ['user' => $user]);
    }

    /**
     * ユーザー編集画面を返す
     * @return View
     */
    public function showUserEdit($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        return view('userEdit', ['user' => $user]);
    }

    /**
     * ログイン画面を返す
     * @return View
     */
    public function showLogin(): View
    {
        return view('login');
    }

    /** 
     * Userデータ（給与データや状態データを含む）の新規作成
     * @return RedirectResponse
     *  */
    public function createUser(UserStoreRequest $request): RedirectResponse
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

                return redirect()->route('users.show', [ConstParams::USER_ID => $user_id]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . $e->getMessage()])->withInput($request->except(ConstParams::PASSWORD));
        }
    }


    /** 
     * Userデータの更新
     * @return RedirectResponse
     *  */
    public function updateUser($user_id, UserUpdateRequest $request): RedirectResponse
    {
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

    /**
     * ユーザー更新処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUserUpdateResult(Request $request): View
    {
        return view('userEditResult', ['user' => session('user'), 'count' => session('count')]);
    }

    /**
     * ユーザー削除処理の前の確認画面を返す
     * @return View
     */
    public function showUserDeleteConfirmation(Request $request): View
    {
        $user = User::where('user_id', $request->user_id)->first();
        return view('userDeleteConfirmation', ['user' => $user]);
    }

    /** 
     * Userデータの削除
     * @return RedirectResponse
     *  */
    public function deleteUser($user_id): View
    {
        if (!Auth::check()) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . 'ログインしていないユーザーの不正な編集は許可されません。']);
        }
        try {
            return DB::transaction(function () use ($user_id) {
                $count = User::where(ConstParams::USER_ID, '=', $user_id)->delete();
                return redirect()->route('users.delete.result', [ConstParams::USER_ID => $user_id])->with(['count' => $count]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'There was an error.' . $e->getMessage()]);
        }
    }

    /**
     * ユーザー削除処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUserDeleteResult(Request $request): View
    {
        return view('userDeleteResult', ['count' => session('count')]);
    }

    /**
     * ログイン処理、バリデーションもここで定義
     * @return RedirectResponse
     */
    public function login(LoginRequest $request): RedirectResponse
    {
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
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect(route('top'));
    }

    /**
     * 特定のログインIDをもつUserデータが存在するか
     * @return bool
     */
    public static function isExistUser(string $login_id): bool
    {
        if (UserController::findUser($login_id)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 特定のログインIDをもつUserオブジェクトを取得
     * @return  User|null
     */
    public static function findUser(string $login_id): User | null
    {
        return $user = User::where(ConstParams::LOGIN_ID, $login_id)->first();
    }
}
