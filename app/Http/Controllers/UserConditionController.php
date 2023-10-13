<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\UserConditionUpdateRequest;
use App\Models\User;
use App\Models\UserCondition;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserConditionController extends Controller
{
    /**
     * UserCondition編集画面を返す
     * @return View
     */
    public function edit($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        $user_data = $user->dataArray();
        $condition_data = $user->condition->dataArray();

        return view('users.conditions.edit', [
            'user_data' => $user_data,
            'condition_data' => $condition_data,
        ]);
    }

    /** 
     * UserConditionの更新
     * @return RedirectResponse
     *  */
    public function update($user_id, UserConditionUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
                $user_data = $user->dataArray();
                $condition_data = $user->condition->dataArray();
                /** @var \App\Models\User $logged_in_user */
                $logged_in_user = Auth::user();

                $data = [
                    ConstParams::USER_CONDITION_ID => $condition_data[ConstParams::USER_CONDITION_ID],
                    ConstParams::HAS_ATTENDED => $request->input(ConstParams::HAS_ATTENDED),
                    ConstParams::IS_BREAKING => $request->input(ConstParams::IS_BREAKING),
                    ConstParams::UPDATED_BY => $logged_in_user->getKanjiFullName(),
                ];
                $result = UserCondition::updateInfo($data);
                return redirect()
                    ->route('users.conditions.update.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_data' => $user_data,
                        'condition_data' => $result['updated_data'],
                        'count' => $result['count'],
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'UserConditionController::updateでエラー' . $e->getMessage()]);
        }
    }

    /**
     * UserCondition更新処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUpdateResult(Request $request): View
    {
        return view('users.conditions.editResult', [
            'user_data' => session('user_data'),
            'condition_data' => session('condition_data'),
            'count' => session('count'),
        ]);
    }
}
