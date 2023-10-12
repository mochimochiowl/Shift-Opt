<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\UserCondition;
use App\Models\UserSalary;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * ユーザー登録画面を返す
     * @return View
     */
    public function create(): View
    {
        return view('users.create');
    }

    /** 
     * Userデータ、UserSalaryデータ、UserConditionデータの新規作成
     * 作成したUserでログインします
     * @return RedirectResponse
     *  */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $user = User::createNewUser($data);
                Auth::login($user);

                UserSalary::createForUser($user);
                UserCondition::createForUser($user);

                return redirect()->route('users.show', [ConstParams::USER_ID => $user->user_id]);
            }, 5);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['message' => 'UserController::storeでエラー' . $e->getMessage()])->withInput($request->except(ConstParams::PASSWORD));
        }
    }

    /**
     * ログイン画面を返す
     * @return View
     */
    public function showLogin(): View
    {
        return view('auth.login');
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
     * ユーザー情報詳細画面を返す
     * @return View
     */
    public function show($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        $salary = $user->salary;
        $condition = $user->condition;
        $condition_jp = $condition->getConditionMessageJP();

        $user_data = [
            ConstParams::USER_ID => $user->user_id,
            ConstParams::KANJI_LAST_NAME => $user->kanji_last_name,
            ConstParams::KANJI_FIRST_NAME => $user->kanji_first_name,
            ConstParams::KANA_LAST_NAME => $user->kana_last_name,
            ConstParams::KANA_FIRST_NAME => $user->kana_first_name,
            ConstParams::EMAIL => $user->email,
            ConstParams::EMAIL_VERIFIED_AT => $user->email_verified_at,
            ConstParams::LOGIN_ID => $user->login_id,
            ConstParams::CREATED_AT => $user->created_at,
            ConstParams::UPDATED_AT => $user->updated_at,
            ConstParams::CREATED_BY => $user->created_by,
            ConstParams::UPDATED_BY => $user->updated_by,
        ];

        $salary_data = [
            ConstParams::USER_SALARY_ID => $salary->user_salary_id,
            ConstParams::HOURLY_WAGE => $salary->hourly_wage,
            ConstParams::CREATED_AT => $salary->created_at,
            ConstParams::UPDATED_AT => $salary->updated_at,
            ConstParams::CREATED_BY => $salary->created_by,
            ConstParams::UPDATED_BY => $salary->updated_by,
        ];

        $condition_data = [
            ConstParams::USER_CONDITION_ID => $condition->user_condition_id,
            'has_attended_jp' => $condition_jp['has_attended_jp'],
            'is_breaking_jp' => $condition_jp['is_breaking_jp'],
            ConstParams::CREATED_AT => $condition->created_at,
            ConstParams::UPDATED_AT => $condition->updated_at,
            ConstParams::CREATED_BY => $condition->created_by,
            ConstParams::UPDATED_BY => $condition->updated_by,
        ];

        return view('users.show', [
            'user' => $user_data,
            'salary' => $salary_data,
            'condition' => $condition_data,
        ]);
    }

    /**
     * ユーザー編集画面を返す
     * @return View
     */
    public function edit($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        return view('users.edit', ['user' => $user]);
    }

    /** 
     * Userデータの更新
     * @return RedirectResponse
     *  */
    public function update($user_id, UserUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $data = $request->validated();
                $result = User::updateInfo($user_id, $data);
                return redirect()
                    ->route('users.update.result', [ConstParams::USER_ID => $result['user']->user_id])
                    ->with(['user' => $result['user'], 'count' => $result['count']]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'UserController::updateでエラー' . $e->getMessage()]);
        }
    }

    /**
     * ユーザー更新処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUpdateResult(Request $request): View
    {
        return view('users.editResult', ['user' => session('user'), 'count' => session('count')]);
    }

    /**
     * ユーザー削除処理の前の確認画面を返す
     * @return View
     */
    public function confirmDestroy(Request $request): View
    {
        $user = User::where('user_id', $request->user_id)->first();
        return view('users.confirmDestroy', ['user' => $user]);
    }

    /** 
     * Userデータの削除
     * @return RedirectResponse
     *  */
    public function destroy($user_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id) {
                $count = User::deletedById($user_id);
                return redirect()->route('users.delete.result', [ConstParams::USER_ID => $user_id])->with(['count' => $count]);
            }, 5);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => 'UserController::destroyでエラー' . $e->getMessage()]);
        }
    }

    /**
     * ユーザー削除処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showDestroyResult(Request $request): View
    {
        return view('users.destroyResult', ['count' => session('count')]);
    }
}
