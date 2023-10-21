<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Const\ConstParams;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
     * UserSalaryの新規作成
     * @return UserSalary
     *  */
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
            throw new Exception('UserSalary::createForUserでエラー : ' . $e->getMessage());
        }
    }

    /**
     * UserSalaryの更新
     * @return array
     */
    public static function updateInfo(array $data): array
    {
        $count = self::where(ConstParams::USER_SALARY_ID, '=', $data[ConstParams::USER_SALARY_ID])
            ->update(
                [
                    ConstParams::HOURLY_WAGE => $data[ConstParams::HOURLY_WAGE],
                    ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
                ]
            );
        $salary = self::where(ConstParams::USER_SALARY_ID, '=', $data[ConstParams::USER_SALARY_ID])->first();
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
     * UserSalaryデータの項目名の配列を返す
     * @return array
     *  */
    public function labels(): array
    {
        $labels = [
            ConstParams::USER_SALARY_ID_JP,
            ConstParams::HOURLY_WAGE_JP,
            ConstParams::CREATED_AT_JP,
            ConstParams::UPDATED_AT_JP,
            ConstParams::CREATED_BY_JP,
            ConstParams::UPDATED_BY_JP,
        ];

        return $labels;
    }

    /** 
     * UserSalaryデータの配列を返す
     * @return array
     *  */
    public function data(): array
    {
        $data = [
            $this->user_salary_id,
            $this->hourly_wage,
            $this->created_at,
            $this->updated_at,
            $this->created_by,
            $this->updated_by,
        ];

        return $data;
    }

    /** 
     * UserSalaryデータの表示や更新処理のために必要な文字列データをまとめた配列を返す
     * @return array
     *  */
    public function dataArray(): array
    {
        $data = [
            ConstParams::USER_SALARY_ID => $this->user_salary_id,
            ConstParams::HOURLY_WAGE => $this->hourly_wage,
            ConstParams::CREATED_AT => $this->created_at,
            ConstParams::UPDATED_AT => $this->updated_at,
            ConstParams::CREATED_BY => $this->created_by,
            ConstParams::UPDATED_BY => $this->updated_by,
        ];

        return $data;
    }

    /**
     * このUserSalaryモデルが属するUserモデルを取得
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
