<?php

namespace App\Http\Controllers;

use App\Const\ConstParams;
use App\Http\Requests\UserSalaryUpdateRequest;
use App\Models\User;
use App\Models\UserSalary;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserSalaryController extends Controller
{
    /**
     * UserSalary編集画面を返す
     * @return View
     */
    public function edit($user_id): View
    {
        $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
        $user_data = $user->dataArray();
        $salary_data = $user->salary->dataArray();

        return view('users.salaries.edit', [
            'user_data' => $user_data,
            'salary_data' => $salary_data,
        ]);
    }

    /** 
     * UserSalaryの更新
     * @return RedirectResponse
     *  */
    public function update($user_id, UserSalaryUpdateRequest $request): RedirectResponse
    {
        try {
            return DB::transaction(function () use ($user_id, $request) {
                $user = User::where(ConstParams::USER_ID, '=', $user_id)->first();
                $user_data = $user->dataArray();
                $salary_data = $user->salary->dataArray();
                /** @var \App\Models\User $logged_in_user */
                $logged_in_user = Auth::user();

                $data = [
                    ConstParams::USER_SALARY_ID => $salary_data[ConstParams::USER_SALARY_ID],
                    ConstParams::HOURLY_WAGE => $request->input(ConstParams::HOURLY_WAGE),
                    ConstParams::UPDATED_BY => $logged_in_user->getKanjiFullName(),
                ];
                $result = UserSalary::updateInfo($data);
                return redirect()
                    ->route('users.salaries.update.result', [ConstParams::USER_ID => $user_id])
                    ->with([
                        'user_data' => $user_data,
                        'salary_data' => $result['updated_data'],
                        'count' => $result['count'],
                    ]);
            }, 5);
        } catch (Exception $e) {
            return redirect()
                ->back()
                ->withErrors(['message' => 'UserSalaryController::updateでエラー' . $e->getMessage()]);
        }
    }

    /**
     * UserSalary更新処理を行い、その処理が成功したことを表示する画面を返す
     * @return View
     */
    public function showUpdateResult(Request $request): View
    {
        return view('users.salaries.editResult', [
            'user_data' => session('user_data'),
            'salary_data' => session('salary_data'),
            'count' => session('count'),
        ]);
    }
}
