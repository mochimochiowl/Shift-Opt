<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Const\ConstParams;
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
        try {
            $user->condition()->create([
                ConstParams::USER_ID => $user->user_id,
                ConstParams::HAS_ATTENDED => false,
                ConstParams::IS_BREAKING => false,
                ConstParams::CREATED_BY => '新規登録',
                ConstParams::UPDATED_BY => '新規登録',
            ]);
        } catch (Exception $e) {
            throw new Exception('UserCondition::createForUserでエラー : ' . $e->getMessage());
        }
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
