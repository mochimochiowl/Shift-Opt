<?php

namespace App\Models;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 時給データの保持・加工とCRUD処理を担当する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserSalary extends Model
{
    use HasFactory;

    protected $primaryKey = ConstParams::USER_SALARY_ID;
    protected $fillable = [
        ConstParams::USER_ID,
        ConstParams::HOURLY_WAGE,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
    ];

    /**
     * 時給データの作成
     * @param User $user 対象のユーザー
     * @return UserSalary 新たに作成したモデル
     */
    public static function createForUser(User $user): UserSalary
    {
        try {
            return $user->salary()->create([
                ConstParams::USER_ID => $user->user_id,
                ConstParams::HOURLY_WAGE => ConstParams::HOURLY_WAGE_DEFAULT,
                ConstParams::CREATED_BY => $user->created_by,
                ConstParams::UPDATED_BY => $user->updated_by,
            ]);
        } catch (Exception $e) {
            ExceptionThrower::createFailed(ConstParams::USER_SALARY_JP, 301);
        }
    }

    /**
     * 時給データを更新する
     * @param array $data 更新対象のIDや金額などを格納した配列
     * @return array 更新後のデータを格納した配列
     */
    public static function updateInfo(array $data): array
    {
        try {
            $count = self::findById($data[ConstParams::USER_SALARY_ID])
                ->update(
                    [
                        ConstParams::HOURLY_WAGE => $data[ConstParams::HOURLY_WAGE],
                        ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
                    ]
                );
        } catch (Exception $e) {
            ExceptionThrower::updateFailed(ConstParams::USER_SALARY_JP, 302);
        }

        try {
            $salary = self::findById($data[ConstParams::USER_SALARY_ID]);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_SALARY_JP, 303);
        }

        $salary_labels = $salary->labels();
        $salary_data = $salary->data();

        $result = [
            'salary_labels' => $salary_labels,
            'salary_data' => $salary_data,
            'count' => $count,
        ];

        return $result;
    }

    /**
     * 特定のIDをもつ時給データを取得する
     * @param int $id 検索対象のID
     * @return UserSalary ヒットしたデータのモデル
     */
    public static function findById(int $id): UserSalary
    {
        try {
            $salary = self::where(ConstParams::USER_SALARY_ID, '=', $id)->first();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_SALARY_JP, 304);
        }

        if (!$salary) {
            ExceptionThrower::notExist(ConstParams::USER_SALARY_JP, 305);
        }

        return $salary;
    }

    /** 
     * データの表示用に項目名の配列を取得する
     * @return array 項目名の配列
     *  */
    public function labels(): array
    {
        $labels = [
            ConstParams::USER_SALARY_ID_JP ?? '取得失敗',
            ConstParams::HOURLY_WAGE_JP ?? '取得失敗',
            ConstParams::CREATED_AT_JP ?? '取得失敗',
            ConstParams::UPDATED_AT_JP ?? '取得失敗',
            ConstParams::CREATED_BY_JP ?? '取得失敗',
            ConstParams::UPDATED_BY_JP ?? '取得失敗',
        ];

        return $labels;
    }

    /** 
     * データの表示用に各項目のデータの配列を取得する
     * @return array 各項目のデータの配列
     *  */
    public function data(): array
    {
        $data = [
            $this->user_salary_id ?? '取得失敗',
            $this->hourly_wage ?? '取得失敗',
            $this->created_at ?? '取得失敗',
            $this->updated_at ?? '取得失敗',
            $this->created_by ?? '取得失敗',
            $this->updated_by ?? '取得失敗',
        ];

        return $data;
    }

    /** 
     * データの表示や更新処理用に、項目名をkeyに、項目のデータを値にした連想配列を取得する
     * @return array 項目名をkeyに、項目のデータを値にした連想配列
     *  */
    public function dataArray(): array
    {
        $data = [
            ConstParams::USER_SALARY_ID => $this->user_salary_id ?? '取得失敗',
            ConstParams::HOURLY_WAGE => $this->hourly_wage ?? '取得失敗',
            ConstParams::CREATED_AT => $this->created_at ?? '取得失敗',
            ConstParams::UPDATED_AT => $this->updated_at ?? '取得失敗',
            ConstParams::CREATED_BY => $this->created_by ?? '取得失敗',
            ConstParams::UPDATED_BY => $this->updated_by ?? '取得失敗',
        ];

        return $data;
    }

    /**
     * このモデルと紐づくUserモデルを取得する
     * @return BelongsTo 紐づくUserモデル
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
