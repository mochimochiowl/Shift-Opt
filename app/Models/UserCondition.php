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
     * UserConditionデータの更新
     * 「出勤打刻済みかどうか」(Has_Attended)と「休憩中かどうか」(is_breaking)という2つのbool変数を見て、
     * 処理を行います。
     * @return void
     */
    public function updateInfo(User $user, string $at_record_type): void
    {
        $errorMessage = '';

        if ($this->has_attended) {
            switch ($at_record_type) {
                case ConstParams::AT_RECORD_START_WORK:
                    $errorMessage = 'Error: 既に出勤済みです';
                    break;
                case ConstParams::AT_RECORD_START_BREAK:
                    if ($this->is_breaking) {
                        $errorMessage = 'Error: 既に休憩開始済みです';
                    } else {
                        $this->is_breaking = true;
                    }
                    break;
                case ConstParams::AT_RECORD_FINISH_BREAK:
                    if (!$this->is_breaking) {
                        $errorMessage = 'Error: 先に休憩開始をしてください';
                    } else {
                        $this->is_breaking = false;
                    }
                    break;
                case ConstParams::AT_RECORD_FINISH_WORK:
                    if ($this->is_breaking) {
                        $errorMessage = 'Error: 先に休憩終了をしてください';
                    } else {
                        $this->has_attended = false;
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
            $this->has_attended = true;
        }

        $this->updated_by = $user->getKanjiFullName();
        $this->save();
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
