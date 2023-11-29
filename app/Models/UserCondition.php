<?php

namespace App\Models;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * コンディションデータの保持・加工とCRUD処理を担当する
 * @author mochimochiowl
 * @version 1.0.0
 */
class UserCondition extends Model
{
    use HasFactory;

    protected $primaryKey = ConstParams::USER_CONDITION_ID;
    protected $fillable = [
        ConstParams::USER_ID,
        ConstParams::HAS_ATTENDED,
        ConstParams::IS_BREAKING,
        ConstParams::CREATED_AT,
        ConstParams::CREATED_BY,
        ConstParams::UPDATED_AT,
        ConstParams::UPDATED_BY,
    ];

    /** 
     * UserConditionデータの新規作成
     * @return void
     *  */
    /**
     * コンディションデータの作成
     * @param User $user 対象のユーザー
     * @return UserCondition 新たに作成したモデル
     */
    public static function createForUser(User $user): UserCondition
    {
        try {
            return $user->condition()->create([
                ConstParams::USER_ID => $user->user_id,
                ConstParams::HAS_ATTENDED => false,
                ConstParams::IS_BREAKING => false,
                ConstParams::CREATED_BY => $user->created_by,
                ConstParams::UPDATED_BY => $user->updated_by,
            ]);
        } catch (Exception $e) {
            ExceptionThrower::createFailed(ConstParams::USER_CONDITION_JP, 401);
        }
    }

    /**
     * コンディションデータを更新する
     * @param array $data 更新対象のIDや出勤フラグなどを格納した配列
     * @return array 更新後のデータを格納した配列
     */
    public static function updateInfo(array $data): array
    {
        try {
            $count = self::findById($data[ConstParams::USER_CONDITION_ID])
                ->update(
                    [
                        ConstParams::HAS_ATTENDED => $data[ConstParams::HAS_ATTENDED],
                        ConstParams::IS_BREAKING => $data[ConstParams::IS_BREAKING],
                        ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
                    ]
                );
        } catch (Exception $e) {
            ExceptionThrower::updateFailed(ConstParams::USER_CONDITION_JP, 402);
        }

        try {
            $condition = self::findById($data[ConstParams::USER_CONDITION_ID]);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_CONDITION_JP, 403);
        }

        $condition_labels = $condition->labels();
        $condition_data = $condition->data();

        $result = [
            'condition_labels' => $condition_labels,
            'condition_data' => $condition_data,
            'count' => $count,
        ];

        return $result;
    }

    /**
     * 特定のIDをもつコンディションデータを取得する
     * @param int $id 検索対象のID
     * @return UserCondition ヒットしたデータのモデル
     */
    public static function findById(int $id): UserCondition
    {
        try {
            $condition = self::where(ConstParams::USER_CONDITION_ID, '=', $id)->first();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_CONDITION_JP, 404);
        }

        if (!$condition) {
            ExceptionThrower::notExist(ConstParams::USER_CONDITION_JP, 405);
        }

        return $condition;
    }

    /**
     * アルファベット表記の「user_condition」に対応する日本語表記の項目名を返す
     * @return array 出勤、休憩の現在の状況を日本語で表した文字列の配列
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
     * 打刻を行う前に、コンディションデータの状態を確認し、更新を行って問題ないかチェックする
     * @param User $user 対象のユーザー
     * @param string $at_record_type 打刻するレコードのタイプ
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
                    $errorMessage = '既に出勤済みです。';
                    break;
                case ConstParams::AT_RECORD_START_BREAK:
                    if ($this->is_breaking) {
                        $errorMessage = '既に休憩開始済みです。';
                    } else {
                        $is_breaking = true;
                    }
                    break;
                case ConstParams::AT_RECORD_FINISH_BREAK:
                    if (!$this->is_breaking) {
                        $errorMessage = '先に休憩開始をしてください。';
                    } else {
                        $is_breaking = false;
                    }
                    break;
                case ConstParams::AT_RECORD_FINISH_WORK:
                    if ($this->is_breaking) {
                        $errorMessage = '先に休憩終了をしてください。';
                    } else {
                        $has_attended = false;
                    }
                    break;
            }

            if ($errorMessage) {
                ExceptionThrower::genericError($errorMessage, 406);
            }
        } else {
            if ($this->is_breaking) {
                $errorMessage = '出勤していないまま、休憩中の状態になっています。管理者にご連絡ください。';
            } else if ($at_record_type !== ConstParams::AT_RECORD_START_WORK) {
                $errorMessage = '先に出勤をしてください。';
            }

            if ($errorMessage) {
                ExceptionThrower::genericError($errorMessage, 407);
            }

            $has_attended = true;
        }


        try {
            self::updateInfo([
                ConstParams::USER_CONDITION_ID => $this->user_condition_id,
                ConstParams::HAS_ATTENDED => $has_attended,
                ConstParams::IS_BREAKING => $is_breaking,
                ConstParams::UPDATED_BY => $user->getKanjiFullName(),
            ]);
        } catch (Exception $e) {
            ExceptionThrower::updateFailed(ConstParams::USER_CONDITION_JP, 408);
        }
    }

    /** 
     * データの表示用に項目名の配列を取得する
     * @return array 項目名の配列
     *  */
    public function labels(): array
    {
        $labels = [
            ConstParams::USER_CONDITION_ID_JP,
            ConstParams::HAS_ATTENDED_JP,
            ConstParams::IS_BREAKING_JP,
            ConstParams::CREATED_AT_JP,
            ConstParams::UPDATED_AT_JP,
            ConstParams::CREATED_BY_JP,
            ConstParams::UPDATED_BY_JP,
        ];

        return $labels;
    }

    /** 
     * データの表示用に各項目のデータの配列を取得する
     * @return array 各項目のデータの配列
     *  */
    public function data(): array
    {
        $condition_jp = $this->getConditionMessageJP();
        $data = [
            $this->user_condition_id,
            $condition_jp['has_attended_jp'],
            $condition_jp['is_breaking_jp'],
            $this->created_at,
            $this->updated_at,
            $this->created_by,
            $this->updated_by,
        ];

        return $data;
    }

    /** 
     * データの表示や更新処理用に、項目名をkeyに、項目のデータを値にした連想配列を取得する
     * @return array 項目名をkeyに、項目のデータを値にした連想配列
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
     * このモデルと紐づくUserモデルを取得する
     * @return BelongsTo 紐づくUserモデル
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
