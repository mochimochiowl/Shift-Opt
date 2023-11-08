<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\UserConditionUpdateRequest;
use App\Models\User;
use App\Models\UserCondition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * コンディションデータに関連するモデルやビューを制御する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserConditionController extends Controller
{
    /**
     * コンディションデータ編集画面を返す
     * @param int $user_id 更新対象のユーザーのID
     * @return View|RedirectResponse 編集画面か、検索画面へのリダイレクト
     */
    public function edit(int $user_id): View
    {
        try {
            $user = User::findByUserId($user_id);
            $user_data = $user->dataArray();
            $condition_data = $user->condition->dataArray();

            return view('users.conditions.edit', [
                'user_data' => $user_data,
                'condition_data' => $condition_data,
            ]);
        } catch (Exception $e) {
            return redirect('users/search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /** 
     * コンディションデータを更新する
     * @param int $user_id 更新対象のID
     * @param UserSalaryUpdateRequest $request バリデーション済みのリクエスト
     * @return RedirectResponse  更新結果画面か、前の画面へのリダイレクト
     *  */
    public function update(int $user_id, UserConditionUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $condition_data = User::findByUserId($user_id)->condition->dataArray();
                $validated_data = $request->validated();
                $formatted_data = $this->formatDataForUpdate($validated_data, $condition_data);

                $result = UserCondition::updateInfo($formatted_data);

                return redirect()
                    ->route('users.conditions.update.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_id' => $user_id,
                        'condition_labels' => $result['condition_labels'],
                        'condition_data' => $result['condition_data'],
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
     * コンディションデータの更新結果画面を返す
     * @return View|RedirectResponse 結果表示画面か検索画面へのリダイレクト
     */
    public function showUpdateResult(): View | RedirectResponse
    {
        try {
            return view('users.conditions.editResult', [
                'user_id' => session('user_id'),
                'condition_labels' => session('condition_labels'),
                'condition_data' => session('condition_data'),
                'count' => session('count'),
            ]);
        } catch (Exception $e) {
            return redirect()
                ->route('users.search')
                ->withErrors(['message' => $e->getMessage()]);
        }
    }

    /**
     * コンディションデータの更新に必要なデータを整形する
     * @param array $data バリエーション済みのデータ
     * @param array $condition_data 現状のコンディションデータ
     * @return array 整形済みのデータの配列
     */
    public static function formatDataForUpdate(array $validated_data, array $condition_data): array
    {
        /** @var \App\Models\User $logged_in_user */
        $logged_in_user = Auth::user();

        $formatted_data = [
            ConstParams::USER_CONDITION_ID => $condition_data[ConstParams::USER_CONDITION_ID],
            ConstParams::HAS_ATTENDED => $validated_data[ConstParams::HAS_ATTENDED],
            ConstParams::IS_BREAKING => $validated_data[ConstParams::IS_BREAKING],
            ConstParams::UPDATED_BY => $logged_in_user->getKanjiFullName(),
        ];

        return $formatted_data;
    }
}
