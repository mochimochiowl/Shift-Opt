<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\UserSalaryUpdateRequest;
use App\Models\User;
use App\Models\UserSalary;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * 時給データに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserSalaryController extends Controller
{
    /**
     * 時給データ編集画面を返す
     * @param int $user_id 更新対象のユーザーのID
     * @return View|RedirectResponse 編集画面か、検索画面へのリダイレクト
     */
    public function edit(int $user_id): View | RedirectResponse
    {
        try {
            $user = User::findByUserId($user_id);
            $user_data = $user->dataArray();
            $salary_data = $user->salary->dataArray();

            return view('users.salaries.edit', [
                'user_data' => $user_data,
                'salary_data' => $salary_data,
            ]);
        } catch (Exception $e) {
            return redirect('users/search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /** 
     * 時給データを更新する
     * @param int $user_id 更新対象のID
     * @param UserSalaryUpdateRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse  更新結果画面か、前の画面へのリダイレクト
     *  */
    public function update(int $user_id, UserSalaryUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $salary_data = User::findByUserId($user_id)->salary->dataArray();
                $validated_data = $request->validated();
                $formatted_data = $this->formatDataForUpdate($validated_data, $salary_data);

                $result = UserSalary::updateInfo($formatted_data);

                return redirect()
                    ->route('users.salaries.update.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_id' => $user_id,
                        'salary_labels' => $result['salary_labels'],
                        'salary_data' => $result['salary_data'],
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
     * 時給データの更新結果画面を返す
     * @return View|RedirectResponse 結果表示画面か検索画面へのリダイレクト
     */
    public function showUpdateResult(): View | RedirectResponse
    {
        try {
            return view('users.salaries.editResult', [
                'user_id' => session('user_id'),
                'salary_labels' => session('salary_labels'),
                'salary_data' => session('salary_data'),
                'count' => session('count'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * 時給データの更新に必要なデータを整形する
     * @param array $validated_data バリエーション済みのデータ
     * @param array $salary_data 現状の時給データ
     * @return array 整形済みのデータの配列
     */
    public function formatDataForUpdate(array $validated_data, array $salary_data): array
    {
        /** @var \App\Models\User $logged_in_user */
        $logged_in_user = Auth::user();

        $formatted_data = [
            ConstParams::USER_SALARY_ID => $salary_data[ConstParams::USER_SALARY_ID],
            ConstParams::HOURLY_WAGE => $validated_data[ConstParams::HOURLY_WAGE],
            ConstParams::UPDATED_BY => $logged_in_user->getKanjiFullName(),
        ];

        return $formatted_data;
    }
}
