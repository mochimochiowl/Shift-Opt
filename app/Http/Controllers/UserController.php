<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Services\SearchService;
use App\Http\Services\UpdateService;
use App\Models\User;
use App\Models\UserCondition;
use App\Models\UserSalary;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

/**
 * userに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserController extends Controller
{
    /**
     * ユーザー登録画面を返す
     * @return View 登録画面
     */
    public function create(): View
    {
        return view('users.create');
    }

    /** 
     * ユーザーを新規作成する (userと紐づくデータも合わせて作成する)
     * @param UserStoreRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse 作成結果画面か、前の画面へのリダイレクト
     *  */
    public function store(UserStoreRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($request) {
                $data = $request->validated();
                $user = User::createNewUser($data);
                $user_labels = $user->labels();
                $user_data = $user->data();

                UserSalary::createForUser($user);
                UserCondition::createForUser($user);

                return redirect()
                    ->route('users.create.result', [ConstParams::USER_ID => $user->user_id])
                    ->with([
                        'user_id' => $user->user_id,
                        'user_labels' => $user_labels,
                        'user_data' => $user_data,
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()])->withInput($request->except(ConstParams::PASSWORD));
        }
    }

    /**
     * ユーザーの新規作成結果画面を返す
     * @return View 結果表示画面
     */
    public function showCreateResult(): View
    {
        return view('users.createResult', [
            'user_id' => session('user_id'),
            'user_labels' => session('user_labels'),
            'user_data' => session('user_data'),
        ]);
    }

    /**
     * ユーザー詳細画面を返す
     * @param int $user_id 表示対象のID
     * @return View 詳細画面
     */
    public function show(int $user_id): View
    {
        $user = User::findByUserId($user_id);
        $user_labels = $user->labels();
        $user_data = $user->data();
        $salary_labels = $user->salary->labels();
        $salary_data = $user->salary->data();
        $condition_labels = $user->condition->labels();
        $condition_data = $user->condition->data();

        return view('users.show', [
            'user_id' => $user->user_id,
            'user_labels' => $user_labels,
            'user_data' => $user_data,
            'salary_labels' => $salary_labels,
            'salary_data' => $salary_data,
            'condition_labels' => $condition_labels,
            'condition_data' => $condition_data,
        ]);
    }

    /**
     * ユーザー検索画面を返す
     * @param Request $request バリデーション未実施のリクエスト
     * @return View|RedirectResponse 検索画面
     */
    public function showSearchPage(Request $request): View | RedirectResponse
    {
        if ($request->input('column')) {
            // 検索ボタンを押下したとき

            // カスタムフォームリクエストを初めから利用すると、
            // リダイレクトループが発生してしまうため、あえてここでバリエーション実行
            $validator = Validator::make(
                $request->all(),
                (new SearchUserRequest)->rules(),
                (new SearchUserRequest)->messages(),
                (new SearchUserRequest)->attributes(),
            );

            if ($validator->fails()) {
                return redirect('users/search')
                    ->withErrors($validator)
                    ->withInput();
            }

            $validated_data = $validator->validated();
            $formatted_data = SearchService::formatUserSearchRequirements(false, $validated_data);
            $results = $this->search($formatted_data['search_requirements']);
        } else {
            // 検索画面を開いたとき
            $formatted_data = SearchService::formatAtRecordSearchRequirements(true);
            $results = null;
        }

        return view('users/search', [
            'results' => $results,
            'search_requirements' => $formatted_data['search_requirements'],
            'search_requirement_labels' => $formatted_data['search_requirement_labels'],
            'search_requirements_data' => $formatted_data['search_requirements_data'],
        ]);
    }

    /**
     * 検索条件に基づき、ユーザーを検索する
     * @param array $search_requirements キーワードや整列順序などを格納した配列
     * @return LengthAwarePaginator 検索結果
     */
    private function search(array $search_requirements): LengthAwarePaginator
    {
        $search_field = $search_requirements['search_field'];
        $keyword = $search_requirements['keyword'] ?? '_';
        $column = $search_requirements['column'];
        $order = $search_requirements['order'];

        return User::searchByKeyword($search_field, $keyword, $column, $order);
    }

    /**
     * ユーザー編集画面を返す
     * @param int $at_record_id 更新対象のID
     * @return View 編集画面
     */
    public function edit(int $user_id): View
    {
        $user = User::findByUserId($user_id);
        $user_data = $user->dataArray();
        return view('users.edit', ['user_data' => $user_data]);
    }

    /** 
     * ユーザーを更新する
     * @param int $user_id 更新対象のID
     * @param UserUpdateRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse  更新結果画面か、前の画面へのリダイレクト
     *  */
    public function update(int $user_id, UserUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $validated_data = $request->validated();
                $formatted_data = UpdateService::formatDataForUser($user_id, $validated_data);
                $result = User::updateInfo($formatted_data);

                return redirect()
                    ->route('users.update.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_id' => $result['user_id'],
                        'user_labels' => $result['user_labels'],
                        'user_data' => $result['user_data'],
                        'count' => $result['count'],
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()]);
        }
    }


    /**
     * ユーザーの更新結果画面を返す
     * @return View 結果表示画面
     */
    public function showUpdateResult(): View
    {
        return view('users.editResult', [
            'user_id' => session('user_id'),
            'user_labels' => session('user_labels'),
            'user_data' => session('user_data'),
            'count' => session('count'),
        ]);
    }

    /**
     * ユーザーの削除確認画面を返す
     * @param Request $request IDを受け取るために使う
     * @return View 確認画面
     */
    public function confirmDestroy(Request $request): View | RedirectResponse
    {
        try {
            $user = User::findByUserId($request->user_id);
            $user_labels = $user->labels();
            $user_data = $user->data();

            if ($user->is_admin) {
                ExceptionThrower::unableDeleteAdmin(ConstParams::USER_JP, 1201);
            }

            return view('users.confirmDestroy', [
                'user_id' => $user->user_id,
                'is_admin' => $user->is_admin,
                'user_labels' => $user_labels,
                'user_data' => $user_data,
            ]);
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }


    /** 
     * ユーザーを削除する
     * @param int $user_id 削除対象のID
     * @return RedirectResponse  削除結果画面か、前の画面へのリダイレクト
     */
    public function destroy(int $user_id): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id) {
                $user = User::findByUserId($user_id);
                $user_labels = $user->labels();
                $user_data = $user->data();

                if ($user->is_admin) {
                    ExceptionThrower::unableDeleteAdmin(ConstParams::USER_JP, 1202);
                }

                $count = User::deletedById($user_id);

                return redirect()
                    ->route('users.delete.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_id' => $user->user_id,
                        'user_labels' => $user_labels,
                        'user_data' => $user_data,
                        'count' => $count,
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()->route('users.search')->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * ユーザーの削除結果画面を返す
     * @return View 結果表示画面
     */
    public function showDestroyResult(): View
    {
        return view('users.destroyResult', [
            'user_id' => session('user_id'),
            'user_labels' => session('user_labels'),
            'user_data' => session('user_data'),
            'count' => session('count'),
        ]);
    }

    /**
     * ログイン画面を返す
     * @return View ログイン画面
     */
    public function showLogin(): View
    {
        return view('auth.login');
    }

    /**
     * ログイン処理を行う
     * @param LoginRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse トップ画面へのリダイレクト
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
     * ログアウト処理を行う
     * @return RedirectResponse トップ画面へのリダイレクト
     */
    public function logout(): RedirectResponse
    {
        Auth::logout();
        return redirect(route('top'));
    }
}
