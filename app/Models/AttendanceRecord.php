<?php

namespace App\Models;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 打刻レコード関係のデータの保持・加工とCRUD処理を担当する
 * @author mochimochiowl
 * @version 1.0.0
 */
class AttendanceRecord extends Model
{
    use HasFactory;

    protected $primaryKey = ConstParams::AT_RECORD_ID;
    protected $fillable = [
        ConstParams::USER_ID,
        ConstParams::AT_SESSION_ID,
        ConstParams::AT_RECORD_TYPE,
        ConstParams::AT_RECORD_DATE,
        ConstParams::AT_RECORD_TIME,
        ConstParams::CREATED_BY,
        ConstParams::UPDATED_BY,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
    ];

    /**
     * at_recordの作成
     * @param array $data ユーザーIDや時刻などを格納した配列
     * @return AttendanceRecord 新たに作成したat_recordモデル
     */
    public static function createNewRecord(array $data): AttendanceRecord
    {

        try {
            $newRecord = self::query()->create(
                [
                    ConstParams::USER_ID => $data['target_user_id'],
                    ConstParams::AT_SESSION_ID => $data[ConstParams::AT_SESSION_ID],
                    ConstParams::AT_RECORD_TYPE => $data[ConstParams::AT_RECORD_TYPE],
                    ConstParams::AT_RECORD_DATE => $data[ConstParams::AT_RECORD_DATE],
                    ConstParams::AT_RECORD_TIME => $data[ConstParams::AT_RECORD_TIME],
                    ConstParams::CREATED_BY => $data[ConstParams::CREATED_BY] ?? '新規登録',
                    ConstParams::UPDATED_BY => $data[ConstParams::CREATED_BY] ?? '新規登録',
                ]
            );

            return $newRecord;
        } catch (Exception $e) {
            ExceptionThrower::createFailed(ConstParams::AT_RECORD_JP, 101);
        }
    }

    /**
     * 特定のIDをもつat_recordを取得する
     * @param int $at_record_id 検索対象のID
     * @return  AttendanceRecord ヒットしたデータのモデル
     */
    public static function searchById(int $at_record_id): AttendanceRecord
    {
        try {
            $record = self::join('users', 'users.' . ConstParams::USER_ID, '=', 'attendance_records.' . ConstParams::USER_ID)
                ->where(ConstParams::AT_RECORD_ID, '=', $at_record_id)
                ->select('attendance_records.*', 'users.kanji_last_name', 'users.kanji_first_name', 'users.kana_last_name', 'users.kana_first_name',)
                ->first();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 102);
        }

        if (!$record) {
            ExceptionThrower::notExist(ConstParams::AT_RECORD_JP, 103);
        }

        //Viewで加工しないようにするため、画面表示用に日本語表記の文字列を追加
        $record->at_record_type_jp = AttendanceRecord::getTypeName($record->at_record_type);
        return $record;
    }

    /**
     * 条件を満たすat_recordオブジェクトを取得する
     * @param array $data 検索条件
     * @param bool $asArray 返り値を配列で取得するか、ペジネーションで取得するか
     * @return  LengthAwarePaginator|array
     */
    public static function search(array $search_requirements, bool $asArray): LengthAwarePaginator | array
    {
        $start_date = $search_requirements['start_date'];
        $end_date = $search_requirements['end_date'];
        $search_field = $search_requirements['search_field'];
        $keyword = $search_requirements['keyword'];
        $column = $search_requirements['column'];
        $order = $search_requirements['order'];

        if ($search_field === 'all') {
            $query = self::join(
                'users',
                'users.' . ConstParams::USER_ID,
                '=',
                'attendance_records.' . ConstParams::USER_ID
            )->whereBetween(
                'attendance_records.' . ConstParams::AT_RECORD_DATE,
                [$start_date, $end_date]
            )->select(
                'attendance_records.*',
                'users.' . ConstParams::KANJI_LAST_NAME,
                'users.' . ConstParams::KANJI_FIRST_NAME,
                'users.' . ConstParams::KANA_LAST_NAME,
                'users.' . ConstParams::KANA_FIRST_NAME,
            );
        } else if ($search_field === 'name') {
            $query = self::join(
                'users',
                'users.' . ConstParams::USER_ID,
                '=',
                'attendance_records.' . ConstParams::USER_ID
            )->where('users.' . ConstParams::KANA_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.' . ConstParams::KANA_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.' . ConstParams::KANJI_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere('users.' . ConstParams::KANJI_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->whereBetween(
                    'attendance_records.' . ConstParams::AT_RECORD_DATE,
                    [$start_date, $end_date]
                )->select(
                    'attendance_records.*',
                    'users.' . ConstParams::KANJI_LAST_NAME,
                    'users.' . ConstParams::KANJI_FIRST_NAME,
                    'users.' . ConstParams::KANA_LAST_NAME,
                    'users.' . ConstParams::KANA_FIRST_NAME,
                );
        } else {
            // user_id か login_id の場合
            $query = self::join(
                'users',
                'users.' . ConstParams::USER_ID,
                '=',
                'attendance_records.' . ConstParams::USER_ID
            )->where('users.' . $search_field, $keyword)
                ->whereBetween(
                    'attendance_records.' . ConstParams::AT_RECORD_DATE,
                    [$start_date, $end_date]
                )->select(
                    'attendance_records.*',
                    'users.' . ConstParams::KANJI_LAST_NAME,
                    'users.' . ConstParams::KANJI_FIRST_NAME,
                    'users.' . ConstParams::KANA_LAST_NAME,
                    'users.' . ConstParams::KANA_FIRST_NAME,
                );
        }

        try {
            //日時、時刻で昇順並べ替え (指定があればその指定に従う)
            if ($column === 'datetime') {
                $ordered_query = $query->orderBy(ConstParams::AT_RECORD_DATE, 'asc')
                    ->orderBy(ConstParams::AT_RECORD_TIME, 'asc');
            } else {
                $ordered_query = $query->orderBy($column, $order);
            }

            if ($asArray) {
                $results = $ordered_query->get();
                //resultsの中にあるat_record一つ一つに対して、dataArray()を呼ぶ
                $array = $results->map(function ($result) {
                    return $result->dataArray();
                })->toArray();
                return $array;
            }

            return $ordered_query->paginate(25);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 104);
        }
    }

    /**
     * at_recordを更新する
     * @param int $at_record_id 更新対象のID
     * @param array $data ユーザーIDや時刻などを格納した配列
     * @return array 更新後のデータを格納した配列
     */
    public static function updateInfo(int $at_record_id, array $data): array
    {
        try {
            $count = self::where(ConstParams::AT_RECORD_ID, '=', $at_record_id)->update(
                [
                    ConstParams::AT_RECORD_TYPE => $data[ConstParams::AT_RECORD_TYPE],
                    ConstParams::AT_RECORD_DATE => $data[ConstParams::AT_RECORD_DATE],
                    ConstParams::AT_RECORD_TIME => $data[ConstParams::AT_RECORD_TIME],
                    ConstParams::UPDATED_BY => $data['logged_in_user_name'],
                ]
            );
        } catch (Exception $e) {
            ExceptionThrower::updateFailed(ConstParams::AT_RECORD_JP, 105);
        }

        try {
            $updated_record = self::searchById($at_record_id);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 106);
        }

        if (!$updated_record) {
            ExceptionThrower::notExist(ConstParams::AT_RECORD_JP, 107);
        }

        $data = $updated_record->dataArray();

        $result = [
            'count' => $count,
            'data' => $data,
        ];

        return $result;
    }

    /**
     * at_recordを削除する
     * @param int $at_record_id 削除対象のID
     * @return int 削除した個数（削除に成功したかどうかのチェックに使う）
     */
    public static function deletedById(int $at_record_id): int
    {
        try {
            return self::where(ConstParams::AT_RECORD_ID, '=', $at_record_id)->delete();
        } catch (Exception $e) {
            ExceptionThrower::deleteFailed(ConstParams::AT_RECORD_JP, 108);
        }
    }

    /**
     * 退勤していないセッションが存在するかチェックする
     * @param int $user_id ユーザーID
     * @return string|null 一番最初に見つけた未退勤のセッションID(未退勤のセッションIDがない場合、null)
     */
    public static function findSessionId(int $user_id): string | null
    {
        try {
            $startRecords = self::where(ConstParams::USER_ID, $user_id)
                ->where(ConstParams::AT_RECORD_TYPE, ConstParams::AT_RECORD_START_WORK)
                ->pluck(ConstParams::AT_SESSION_ID)
                ->toArray();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 109);
        }

        try {
            $endRecords = self::where(ConstParams::USER_ID, $user_id)
                ->where(ConstParams::AT_RECORD_TYPE, ConstParams::AT_RECORD_FINISH_WORK)
                ->whereIn(ConstParams::AT_SESSION_ID, $startRecords)
                ->pluck(ConstParams::AT_SESSION_ID)
                ->toArray();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 110);
        }


        $notEndedSessions = array_diff($startRecords, $endRecords);

        if (count($notEndedSessions) > 1) {
            ExceptionThrower::notEndedSessionsExist(111);
        }

        return $notEndedSessions ? reset($notEndedSessions) : null;
    }

    /**
     * サマリー画面用のデータ配列を取得する
     * @param DateTime $date 出力対象の日付
     * @return  array at_recordのデータ配列
     */
    public static function getDataForSummary(DateTime $date): array
    {
        /* at_session_idを取得
            条件：at_record_dateが$dateの日
            　　　＆at_record_typeがConstParams::AT_RECORD_START_WORK
        */
        $start_date = $date->format('Y-m-d'); // 年月日のみのフォーマットに変換
        $end_date = $date->format('Y-m-d');

        try {
            $records = self::whereBetween(
                'attendance_records.' . ConstParams::AT_RECORD_DATE,
                [$start_date, $end_date]
            )->where(
                'attendance_records.' . ConstParams::AT_RECORD_TYPE,
                '=',
                ConstParams::AT_RECORD_START_WORK
            )->select(
                'attendance_records.' . ConstParams::AT_SESSION_ID,
            )->get();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 112);
        }

        $session_ids = $records->map(function ($record) {
            return $record->at_session_id;
        })->toArray();

        $dailyAtRecordSets = [];

        foreach ($session_ids as $session_id) {
            //session_idを持つレコードをすべて取得
            //日付・時刻で昇順に並べ替えることで、休憩始と休憩終のレコードが正しく紐づくようにする
            $query = self::join(
                'users',
                'users.' . ConstParams::USER_ID,
                '=',
                'attendance_records.' . ConstParams::USER_ID
            )->where(
                'attendance_records.' . ConstParams::AT_SESSION_ID,
                $session_id
            )->select(
                'attendance_records.*',
                'users.' . ConstParams::KANJI_LAST_NAME,
                'users.' . ConstParams::KANJI_FIRST_NAME,
                'users.' . ConstParams::KANA_LAST_NAME,
                'users.' . ConstParams::KANA_FIRST_NAME,
            );

            try {
                $records = $query->orderBy(ConstParams::AT_RECORD_DATE, 'asc')
                    ->orderBy(ConstParams::AT_RECORD_TIME, 'asc')
                    ->get();
            } catch (Exception $e) {
                ExceptionThrower::fetchFailed(ConstParams::AT_RECORD_JP, 113);
            }
            //resultsの中にあるat_record一つ一つに対して、dataArray()を呼ぶ
            $modified_records = $records->map(function ($record) {
                return $record->dataArray();
            })->toArray();

            $start_work_record = null;
            $finish_work_record = null;
            $start_break_records = [];
            $finish_break_records = [];

            //at_record_typeで出勤、休憩開始、休憩終了、退勤に仕分け
            foreach ($modified_records as $record) {
                if ($record[ConstParams::AT_RECORD_TYPE] === ConstParams::AT_RECORD_START_BREAK) {
                    array_push($start_break_records, $record);
                } else if ($record[ConstParams::AT_RECORD_TYPE] === ConstParams::AT_RECORD_FINISH_BREAK) {
                    array_push($finish_break_records, $record);
                } else if ($record[ConstParams::AT_RECORD_TYPE] === ConstParams::AT_RECORD_START_WORK) {
                    $start_work_record = $record;
                } else {
                    $finish_work_record = $record;
                }
            }

            //退勤していないセッションがある場合、例外を投げる
            if (!$finish_work_record) {
                ExceptionThrower::notEndedSessionsExist(114);
            }

            if (!$start_work_record) {
                ExceptionThrower::notExist(ConstParams::AT_RECORD_START_WORK_JP . ConstParams::AT_RECORD_JP, 115);
            }


            $dailyAtRecordSet = [
                'start_work_record' => $start_work_record,
                'finish_work_record' => $finish_work_record,
                'start_break_records' => $start_break_records,
                'finish_break_records' => $finish_break_records,
            ];

            array_push($dailyAtRecordSets, $dailyAtRecordSet);
        }
        return $dailyAtRecordSets;
    }

    /**
     * 出勤レコードタイプの日本語表記を取得する
     * @param string $type アルファベット表記の出勤レコードタイプ
     * @return string 日本語表記の出勤レコードタイプ
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
                return '取得失敗';
        }
    }

    /** 
     * データの表示用に項目名の配列を取得する
     * @return array 項目名の配列
     *  */
    public function labels(): array
    {
        $labels = [
            ConstParams::AT_RECORD_ID_JP ?? '取得失敗',
            ConstParams::AT_SESSION_ID_JP ?? '取得失敗',
            ConstParams::USER_ID_JP ?? '取得失敗',
            ConstParams::KANJI_LAST_NAME_JP ?? '取得失敗',
            ConstParams::KANJI_FIRST_NAME_JP ?? '取得失敗',
            ConstParams::KANA_LAST_NAME_JP ?? '取得失敗',
            ConstParams::KANA_FIRST_NAME_JP ?? '取得失敗',
            ConstParams::AT_RECORD_TYPE_JP ?? '取得失敗',
            ConstParams::AT_RECORD_DATE_JP ?? '取得失敗',
            ConstParams::AT_RECORD_TIME_JP ?? '取得失敗',
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
            $this->at_record_id ?? '取得失敗',
            $this->at_session_id ?? '取得失敗',
            $this->user_id ?? '取得失敗',
            $this->kanji_last_name ?? '取得失敗',
            $this->kanji_first_name ?? '取得失敗',
            $this->kana_last_name ?? '取得失敗',
            $this->kana_first_name ?? '取得失敗',
            AttendanceRecord::getTypeName($this->at_record_type) ?? '取得失敗',
            $this->at_record_date ?? '取得失敗',
            $this->at_record_time ?? '取得失敗',
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
            ConstParams::AT_RECORD_ID => $this->at_record_id ?? '取得失敗',
            ConstParams::AT_SESSION_ID => $this->at_session_id ?? '取得失敗',
            ConstParams::USER_ID => $this->user_id ?? '取得失敗',
            ConstParams::AT_RECORD_TYPE => $this->at_record_type ?? '取得失敗',
            ConstParams::AT_RECORD_TYPE_TRANSLATED => AttendanceRecord::getTypeName($this->at_record_type) ?? '取得失敗',
            ConstParams::AT_RECORD_DATE => $this->at_record_date ?? '取得失敗',
            ConstParams::AT_RECORD_TIME => $this->at_record_time ?? '取得失敗',
            ConstParams::CREATED_AT => $this->created_at ?? '取得失敗',
            ConstParams::UPDATED_AT => $this->updated_at ?? '取得失敗',
            ConstParams::CREATED_BY => $this->created_by ?? '取得失敗',
            ConstParams::UPDATED_BY => $this->updated_by ?? '取得失敗',
            ConstParams::KANJI_LAST_NAME => $this->kanji_last_name ?? '取得失敗',
            ConstParams::KANJI_FIRST_NAME => $this->kanji_first_name ?? '取得失敗',
            ConstParams::KANA_LAST_NAME => $this->kana_last_name ?? '取得失敗',
            ConstParams::KANA_FIRST_NAME => $this->kana_first_name ?? '取得失敗',
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
