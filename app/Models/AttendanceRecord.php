<?php

namespace App\Models;

use App\Const\ConstParams;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $primaryKey = ConstParams::AT_RECORD_ID;
    protected $fillable = [
        ConstParams::USER_ID,
        ConstParams::AT_RECORD_TYPE,
        ConstParams::AT_RECORD_TIME,
        ConstParams::CREATED_BY,
        ConstParams::UPDATED_BY,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
    ];

    /**
     * At_recordの作成
     * @return AttendanceRecord
     */
    public static function createNewRecord(User $user, string $at_record_type): AttendanceRecord
    {
        try {
            $newRecord = self::query()->create(
                [
                    ConstParams::USER_ID => $user->user_id,
                    ConstParams::AT_RECORD_TYPE => $at_record_type,
                    ConstParams::AT_RECORD_TIME => getCurrentTime(),
                    ConstParams::CREATED_BY => $user->getKanjiFullName(),
                    ConstParams::UPDATED_BY => $user->getKanjiFullName(),
                ]
            );

            return $newRecord;
        } catch (Exception $e) {
            throw new Exception('AttendanceRecord::createNewRecordでエラー : ' . $e->getMessage());
        }
    }
}
