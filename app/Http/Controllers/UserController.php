<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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
 * ユーザーに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserController extends Controller
{
    /**
     * ユーザー登録画面を返す
     * @return View|RedirectResponse 登録画面か、トップ画面へのリダイレクト
     */
    public function create(): View | RedirectResponse
    {
        try {
            return view('users.create');
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
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
            return redirect()
                ->back()
                ->withErrors(['message' => $e->getMessage()])
                ->withInput($request->except(ConstParams::PASSWORD));
        }
    }

    /**
     * ユーザーの新規作成結果画面を返す
     * @return View 結果表示画面|RedirectResponse 結果表示画面か、トップ画面へのリダイレクト
     */
    public function showCreateResult(): View | RedirectResponse
    {
        try {
            if (!session('user_id')) {
                ExceptionThrower::unauthorizedAccess(1205);
            }
            return view('users.createResult', [
                'user_id' => session('user_id'),
                'user_labels' => session('user_labels'),
                'user_data' => session('user_data'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * ユーザー詳細画面を返す
     * @param int $user_id 表示対象のID
     * @return View|RedirectResponse  詳細画面か、検索画面へのリダイレクト
     */
    public function show(int $user_id): View | RedirectResponse
    {
        try {
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
        } catch (Exception $e) {
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * ユーザー検索画面を返す
     * @param Request $request バリデーション未実施のリクエスト
     * @return View|RedirectResponse 検索画面か、トップ画面へのリダイレクト
     */
    public function showSearchPage(Request $request): View | RedirectResponse
    {
        try {
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
                $formatted_data = $this->formatSearchRequirements(false, $validated_data);
                $results = $this->search($formatted_data['search_requirements']);
            } else {
                // 検索画面を開いたとき
                $formatted_data = $this->formatSearchRequirements(true);
                $results = null;
            }

            return view('users/search', [
                'results' => $results,
                'search_requirements' => $formatted_data['search_requirements'],
                'search_requirement_labels' => $formatted_data['search_requirement_labels'],
                'search_requirements_data' => $formatted_data['search_requirements_data'],
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
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
     * @return View|RedirectResponse 編集画面か、検索画面へのリダイレクト
     */
    public function edit(int $user_id): View | RedirectResponse
    {
        try {
            $user = User::findByUserId($user_id);
            $user_data = $user->dataArray();
            return view('users.edit', [
                'user_data' => $user_data
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
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
                $formatted_data = $this->formatDataForUpdate($user_id, $validated_data);
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
     * @return View|RedirectResponse 結果表示画面か検索画面へのリダイレクト
     */
    public function showUpdateResult(): View | RedirectResponse
    {
        try {
            if (!session('user_id')) {
                ExceptionThrower::unauthorizedAccess(1204);
            }
            return view('users.editResult', [
                'user_id' => session('user_id'),
                'user_labels' => session('user_labels'),
                'user_data' => session('user_data'),
                'count' => session('count'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * ユーザーの削除確認画面を返す
     * @param Request $request IDを受け取るために使う
     * @return View|RedirectResponse 確認画面か検索画面へのリダイレクト
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
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
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
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * ユーザーの削除結果画面を返す
     * @return View|RedirectResponse 結果表示画面か検索画面へのリダイレクト
     */
    public function showDestroyResult(): View | RedirectResponse
    {
        try {
            if (!session('user_id')) {
                ExceptionThrower::unauthorizedAccess(1203);
            }
            return view('users.destroyResult', [
                'user_id' => session('user_id'),
                'user_labels' => session('user_labels'),
                'user_data' => session('user_data'),
                'count' => session('count'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * ログイン画面を返す
     * @return View|RedirectResponse ログイン画面かトップへのリダイレクト
     */
    public function showLogin(): View
    {
        try {
            return view('auth.login');
        } catch (Exception $e) {
            return redirect()
                ->route('top')
                ->withErrors(['message' => $e->getMessage()]);
        }
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
        return back()
            ->withErrors(['message' => 'パスワードが一致しません。'])
            ->withInput($request->except(ConstParams::PASSWORD));
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

    /**
     * ユーザーレコードの更新に必要なデータを整形する
     * @param int $user_id 更新対象のID
     * @param array $data バリエーション済みのデータ
     * @return array 整形済みのデータの配列
     */
    private static function formatDataForUpdate(int $user_id, array $data): array
    {
        /** @var \App\Models\User $logged_in_user */
        $logged_in_user = Auth::user();

        $updated_by = $logged_in_user->getKanjiFullName();

        // ログインユーザー自身の情報を更新する場合、
        // 変更後の氏名（＝最新の氏名）を最終更新者に記録するようにする
        if ($user_id == $logged_in_user->user_id) {
            $updated_by = $data[ConstParams::KANJI_LAST_NAME] . ' ' . $data[ConstParams::KANJI_FIRST_NAME];
        }

        $formatted_data = [
            ConstParams::USER_ID => $user_id,
            ConstParams::KANJI_LAST_NAME => $data[ConstParams::KANJI_LAST_NAME],
            ConstParams::KANJI_FIRST_NAME => $data[ConstParams::KANJI_FIRST_NAME],
            ConstParams::KANA_LAST_NAME => $data[ConstParams::KANA_LAST_NAME],
            ConstParams::KANA_FIRST_NAME => $data[ConstParams::KANA_FIRST_NAME],
            ConstParams::EMAIL => $data[ConstParams::EMAIL],
            ConstParams::LOGIN_ID => $data[ConstParams::LOGIN_ID],
            ConstParams::IS_ADMIN => $data[ConstParams::IS_ADMIN],
            ConstParams::UPDATED_BY => $updated_by,
        ];

        return $formatted_data;
    }

    /**
     * ユーザーレコード検索の実行と結果表示に必要なデータを整形する
     * @param bool $is_empty 空の配列を返すかどうか
     * @param array $data バリエーション済みの検索条件
     * @return array 整形済みのデータの配列
     */
    public static function formatSearchRequirements(bool $is_empty, array $data = []): array
    {
        if ($is_empty) {
            return [
                'search_requirements' => null,
                'search_requirement_labels' => null,
                'search_requirements_data' => null,
            ];
        }

        $search_field = $data['search_field'] ?? 'all';
        $keyword = $data['keyword'] ?? 'empty';
        if ($search_field === 'all') {
            $keyword = 'all';
        }
        $search_requirements = [
            'search_field' => $search_field,
            'search_field_jp' => getFieldNameJP($search_field),
            'keyword' => $keyword,
            'column' => $data['column'],
            'order' => $data['order'],
        ];

        $search_requirement_labels = [
            '検索種別',
            'キーワード',
        ];

        $search_requirements_data = [
            getFieldNameJP($search_requirements['search_field']),
            $search_requirements['keyword'],
        ];

        return [
            'search_requirements' => $search_requirements,
            'search_requirement_labels' => $search_requirement_labels,
            'search_requirements_data' => $search_requirements_data,
        ];
    }
}
