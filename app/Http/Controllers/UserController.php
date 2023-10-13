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
        $user_data = $user->dataArray();
        $salary_data = $user->salary->dataArray();
        $condition_data = $user->condition->dataArray();

        return view('users.show', [
            'user_data' => $user_data,
            'salary_data' => $salary_data,
            'condition_data' => $condition_data,
        ]);
    }

    /**
     * ユーザー編集画面を返す
     * @return View
     */
    public function edit($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        $user_data = $user->dataArray();
        return view('users.edit', ['user_data' => $user_data]);
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
                /** @var \App\Models\User $logged_in_user */
                $logged_in_user = Auth::user();
                $updated_by = $logged_in_user->getKanjiFullName();

                //ログインユーザー自身の情報を更新する場合、変更後の氏名（＝最新の氏名）を最終更新者に記録するようにする
                if ($user_id == $logged_in_user->user_id) {
                    $updated_by = $data[ConstParams::KANJI_LAST_NAME] . ' ' . $data[ConstParams::KANJI_FIRST_NAME];
                }

                $data = [
                    ConstParams::USER_ID => $user_id,
                    ConstParams::KANJI_LAST_NAME => $data[ConstParams::KANJI_LAST_NAME],
                    ConstParams::KANJI_FIRST_NAME => $data[ConstParams::KANJI_FIRST_NAME],
                    ConstParams::KANA_LAST_NAME => $data[ConstParams::KANA_LAST_NAME],
                    ConstParams::KANA_FIRST_NAME => $data[ConstParams::KANA_FIRST_NAME],
                    ConstParams::EMAIL => $data[ConstParams::EMAIL],
                    ConstParams::LOGIN_ID => $data[ConstParams::LOGIN_ID],
                    ConstParams::UPDATED_BY => $updated_by,
                ];
                $result = User::updateInfo($data);
                return redirect()
                    ->route('users.update.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_data' => $result['updated_data'],
                        'count' => $result['count'],
                    ]);
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
        return view('users.editResult', [
            'user_data' => session('user_data'),
            'count' => session('count'),
        ]);
    }

    /**
     * ユーザー削除処理の前の確認画面を返す
     * @return View
     */
    public function confirmDestroy(Request $request): View
    {
        $user = User::where('user_id', $request->user_id)->first();
        $user_data = $user->dataArray();
        return view('users.confirmDestroy', ['user_data' => $user_data]);
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
