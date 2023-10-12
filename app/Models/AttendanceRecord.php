<?php

namespace App\Models;

use App\Const\ConstParams;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * at_record_typeの日本語表記を取得
     * @return string
     */
    public static function getTypeName(string $type): string
    {
        switch ($type) {
            case ConstParams::AT_RECORD_START_WORK:
                return ConstParams::AT_RECORD_START_WORK_JP;
            case ConstParams::AT_RECORD_FINISH_WORK:
                return ConstParams::AT_RECORD_FINISH_WORK_JP;
            case ConstParams::AT_RECORD_START_BREAK:
                return ConstParams::AT_RECORD_START_BREAK_JP;
            case ConstParams::AT_RECORD_FINISH_BREAK:
                return ConstParams::AT_RECORD_FINISH_BREAK_JP;
            default:
                return 'ERROR: タイプの日本語表記取得ができませんでした。';
        }
    }

    /**
     * 条件を満たすat_recordオブジェクトの配列を取得
     * @return  Collection
     */
    public static function search(array $data): Collection
    {
        $search_field = $data['search_field'];
        $keyword = $data['keyword'];
        $start_date = $data['start_date'];
        $end_date = $data['end_date'];

        if ($search_field === 'all') {
            $records = self::join('users', 'users.' . ConstParams::USER_ID, '=', 'attendance_records.' . ConstParams::USER_ID)
                ->whereBetween('attendance_records.at_record_time', [$start_date, $end_date])
                ->select('attendance_records.*', 'users.kanji_last_name', 'users.kanji_first_name', 'users.kana_last_name', 'users.kana_first_name',)
                ->get();
        } else if ($search_field === 'name') {
            $records = self::join('users', 'users.' . $search_field, '=', 'attendance_records.' . $search_field)
                ->where('users.' . ConstParams::KANA_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.' . ConstParams::KANA_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.' . ConstParams::KANJI_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.' . ConstParams::KANJI_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->whereBetween('attendance_records.at_record_time', [$start_date, $end_date])
                ->select('attendance_records.*', 'users.kanji_last_name', 'users.kanji_first_name', 'users.kana_last_name', 'users.kana_first_name',)
                ->get();
        } else {
            // user_id か login_id の場合
            $records = self::join('users', 'users.' . $search_field, '=', 'attendance_records.' . $search_field)
                ->where('attendance_records.' . $search_field, $keyword)
                ->whereBetween('attendance_records.at_record_time', [$start_date, $end_date])
                ->select('attendance_records.*', 'users.kanji_last_name', 'users.kanji_first_name', 'users.kana_last_name', 'users.kana_first_name',)
                ->get();
        }

        //Viewで加工しないようにするため、at_record_typeのカラムのみ、画面表示用に日本語表記の文字列に差し替え
        $modified_records = $records->map(function ($record) {
            $record->at_record_type = AttendanceRecord::getTypeName($record->at_record_type);
            return $record;
        });
        return $modified_records;
    }

    /**
     * このat_recordモデルと紐づくUserモデルを取得
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
