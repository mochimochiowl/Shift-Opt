<?php

namespace App\Models;

use App\Const\ConstParams;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserCondition extends Model
{
    use HasFactory;

    protected $primaryKey = ConstParams::USER_CONDITION_ID;
    protected $fillable = [
        ConstParams::USER_ID,
        ConstParams::HAS_ATTENDED,
        ConstParams::IS_BREAKING,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
    ];

    /** 
     * UserConditionデータの新規作成
     * @return void
     *  */
    public static function createForUser(User $user): void
    {
        $user->condition()->create([
            ConstParams::USER_ID => $user->user_id,
            ConstParams::HAS_ATTENDED => false,
            ConstParams::IS_BREAKING => false,
            ConstParams::CREATED_BY => '新規登録',
            ConstParams::UPDATED_BY => '新規登録',
        ]);
    }

    /**
     * user_condition の日本語表記を取得
     * @return array
     */
    public function getConditionMessageJP(): array
    {
        $has_attended_jp = ConstParams::HAS_ATTENDED_TRUE_JP;
        $is_breaking_jp = ConstParams::IS_BREAKING_TRUE_JP;
        if (!$this->has_attended) {
            $has_attended_jp = ConstParams::HAS_ATTENDED_FALSE_JP;
        }
        if (!$this->is_breaking) {
            $is_breaking_jp = ConstParams::IS_BREAKING_FALSE_JP;
        }
        return [
            'has_attended_jp' => $has_attended_jp,
            'is_breaking_jp' => $is_breaking_jp,
        ];
    }

    /**
     * UserConditionデータの更新を行うかチェックする
     * 「出勤打刻済みかどうか」(Has_Attended)と「休憩中かどうか」(is_breaking)という2つのbool変数を見て、
     * 処理を行います。
     * @return void
     */
    public function validateConditions(User $user, string $at_record_type): void
    {
        $errorMessage = '';
        $has_attended = $this->has_attended;
        $is_breaking = $this->is_breaking;

        if ($this->has_attended) {
            switch ($at_record_type) {
                case ConstParams::AT_RECORD_START_WORK:
                    $errorMessage = 'Error: 既に出勤済みです';
                    break;
                case ConstParams::AT_RECORD_START_BREAK:
                    if ($this->is_breaking) {
                        $errorMessage = 'Error: 既に休憩開始済みです';
                    } else {
                        $is_breaking = true;
                    }
                    break;
                case ConstParams::AT_RECORD_FINISH_BREAK:
                    if (!$this->is_breaking) {
                        $errorMessage = 'Error: 先に休憩開始をしてください';
                    } else {
                        $is_breaking = false;
                    }
                    break;
                case ConstParams::AT_RECORD_FINISH_WORK:
                    if ($this->is_breaking) {
                        $errorMessage = 'Error: 先に休憩終了をしてください';
                    } else {
                        $has_attended = false;
                    }
                    break;
            }

            if ($errorMessage) {
                throw new Exception($errorMessage . ' login_id: ' . $user->login_id . ' user_id:' . $user->user_id);
            }
        } else {
            if ($this->is_breaking) {
                $errorMessage = 'Error: これが出たらバグです。(休憩フラグが立っています) ';
            } else if ($at_record_type !== ConstParams::AT_RECORD_START_WORK) {
                $errorMessage = 'Error: 先に出勤をしてください ';
            }

            if ($errorMessage) {
                throw new Exception($errorMessage . ' login_id: ' . $user->login_id . ' user_id:' . $user->user_id);
            }
            $has_attended = true;
        }
        self::updateInfo([
            ConstParams::USER_CONDITION_ID => $this->user_condition_id,
            ConstParams::HAS_ATTENDED => $has_attended,
            ConstParams::IS_BREAKING => $is_breaking,
            ConstParams::UPDATED_BY => $user->getKanjiFullName(),
        ]);
    }

    /**
     * UserConditionデータの書き換えを実施
     * @return array
     */
    public static function updateInfo(array $data): array
    {
        $count = self::where(ConstParams::USER_CONDITION_ID, '=', $data[ConstParams::USER_CONDITION_ID])
            ->update(
                [
                    ConstParams::HAS_ATTENDED => $data[ConstParams::HAS_ATTENDED],
                    ConstParams::IS_BREAKING => $data[ConstParams::IS_BREAKING],
                    ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
                ]
            );
        $updated_data = self::where(ConstParams::USER_CONDITION_ID, '=', $data[ConstParams::USER_CONDITION_ID])
            ->first()->dataArray();

        $result = [
            'count' => $count,
            'updated_data' => $updated_data,
        ];

        return $result;
    }

    /** 
     * UserConditionデータの表示や更新処理のために必要な文字列データをまとめた配列を返す
     * @return array
     *  */
    public function dataArray(): array
    {
        $condition_jp = $this->getConditionMessageJP();
        $data = [
            ConstParams::USER_CONDITION_ID => $this->user_condition_id,
            ConstParams::HAS_ATTENDED => $this->has_attended,
            ConstParams::IS_BREAKING => $this->is_breaking,
            'has_attended_jp' => $condition_jp['has_attended_jp'],
            'is_breaking_jp' => $condition_jp['is_breaking_jp'],
            ConstParams::CREATED_AT => $this->created_at,
            ConstParams::UPDATED_AT => $this->updated_at,
            ConstParams::CREATED_BY => $this->created_by,
            ConstParams::UPDATED_BY => $this->updated_by,
        ];

        return $data;
    }

    /**
     * このUserConditionモデルが属するUserモデルを取得
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
