<?php

namespace App\Models;

use App\Const\ConstParams;
use App\Exceptions\ExceptionThrower;
use Exception;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

/**
 * ユーザー関係のデータの保持・加工とCRUD処理を担当する
 * @author mochimochiowl
 * @version 1.0.0
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = ConstParams::USER_ID;
    protected $fillable = [
        ConstParams::KANJI_LAST_NAME,
        ConstParams::KANJI_FIRST_NAME,
        ConstParams::KANA_LAST_NAME,
        ConstParams::KANA_FIRST_NAME,
        ConstParams::EMAIL,
        ConstParams::LOGIN_ID,
        ConstParams::PASSWORD,
        ConstParams::IS_ADMIN,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
        ConstParams::CREATED_BY,
        ConstParams::UPDATED_BY,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
        ConstParams::CREATED_AT,
        ConstParams::UPDATED_AT,
    ];

    protected $hidden = [
        ConstParams::PASSWORD,
        ConstParams::REMEMBER_TOKEN,
    ];

    protected $casts = [
        ConstParams::EMAIL_VERIFIED_AT => 'datetime',
        ConstParams::PASSWORD => 'hashed',
    ];

    /**
     * ユーザーの作成
     * @param array $data 氏名やログインIDなどを格納した配列
     * @return User 新たに作成したモデル
     */
    public static function createNewUser(array $data): User
    {
        try {
            $user = self::query()->create(
                [
                    ConstParams::KANJI_LAST_NAME => $data[ConstParams::KANJI_LAST_NAME],
                    ConstParams::KANJI_FIRST_NAME => $data[ConstParams::KANJI_FIRST_NAME],
                    ConstParams::KANA_LAST_NAME => $data[ConstParams::KANA_LAST_NAME],
                    ConstParams::KANA_FIRST_NAME => $data[ConstParams::KANA_FIRST_NAME],
                    ConstParams::EMAIL => $data[ConstParams::EMAIL],
                    ConstParams::LOGIN_ID => $data[ConstParams::LOGIN_ID],
                    ConstParams::PASSWORD => Hash::make($data[ConstParams::PASSWORD]),
                    ConstParams::IS_ADMIN => ($data[ConstParams::IS_ADMIN] === 'true') ? true : false,
                    ConstParams::CREATED_BY => $data[ConstParams::CREATED_BY] ?? '新規登録',
                    ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY] ?? '新規登録',
                ]
            );

            return $user;
        } catch (Exception $e) {
            ExceptionThrower::createFailed(ConstParams::USER_JP, 201);
        }
    }

    /**
     * 特定のユーザーIDをもつユーザーを取得する
     * @param int $user_id 検索対象のID
     * @return User ヒットしたデータのモデル
     */
    public static function findByUserId(int $user_id): User
    {
        try {
            $user = self::where(ConstParams::USER_ID, $user_id)->first();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_JP, 202);
        }

        if (!$user) {
            ExceptionThrower::notExist(ConstParams::USER_JP, 203);
        }

        return $user;
    }

    /**
     * 特定のログインIDをもつユーザーを取得する
     * @param string $login_id 検索対象のID
     * @return  User ヒットしたデータのモデル
     */
    public static function findByLoginId(string $login_id): User
    {
        try {
            $user = self::where(ConstParams::LOGIN_ID, $login_id)->first();
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_JP, 204);
        }

        if (!$user) {
            ExceptionThrower::notExist(ConstParams::USER_JP, 205);
        }

        return $user;
    }

    /**
     * 条件を満たすユーザーを取得する
     * @param string $field 検索対象のカラム
     * @param string $keyword 検索ワード
     * @param string $column 整列の基準となるカラム
     * @param string $order 昇順か降順か
     * @return  LengthAwarePaginator ペジネーションに対応したユーザーのデータコレクション
     */
    public static function searchByKeyword(string $field, string $keyword, string $column, string $order): LengthAwarePaginator
    {
        $query = self::query();

        if ($field === 'name') {
            $query->where(ConstParams::KANA_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere(ConstParams::KANA_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere(ConstParams::KANJI_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere(ConstParams::KANJI_FIRST_NAME, 'LIKE', '%' . $keyword . '%');
        } elseif ($field === 'all') {
            // 何も追加しない（すべてのレコードを取得）
        } elseif ($field === ConstParams::USER_ID | $field === ConstParams::LOGIN_ID) {
            $query->where($field, '=', $keyword);
        } else {
            $query->where($field, 'LIKE', '%' . $keyword . '%');
        }

        try {
            //ユーザーIDで昇順並べ替え
            $results = $query->orderBy($column, $order)->paginate(ConstParams::USERS_PAGINATION_LIMIT);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_JP, 206);
        }

        return $results;
    }

    /**
     * ユーザーを更新する
     * @param array $data 氏名やログインIDなどを格納した配列
     * @return array 更新後のデータを格納した配列
     */
    public static function updateInfo(array $data): array
    {
        try {
            $count = self::findByUserId($data[ConstParams::USER_ID])
                ->update(
                    [
                        ConstParams::KANJI_LAST_NAME => $data[ConstParams::KANJI_LAST_NAME],
                        ConstParams::KANJI_FIRST_NAME => $data[ConstParams::KANJI_FIRST_NAME],
                        ConstParams::KANA_LAST_NAME => $data[ConstParams::KANA_LAST_NAME],
                        ConstParams::KANA_FIRST_NAME => $data[ConstParams::KANA_FIRST_NAME],
                        ConstParams::EMAIL => $data[ConstParams::EMAIL],
                        ConstParams::LOGIN_ID => $data[ConstParams::LOGIN_ID],
                        ConstParams::IS_ADMIN => $data[ConstParams::IS_ADMIN],
                        ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
                    ]
                );
        } catch (Exception $e) {
            ExceptionThrower::updateFailed(ConstParams::USER_JP, 207);
        }

        try {
            $user = self::findByUserId($data[ConstParams::USER_ID]);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_JP, 208);
        }

        $user_labels = $user->labels();
        $user_data = $user->data();

        $result = [
            'user_id' => $user->user_id,
            'user_labels' => $user_labels,
            'user_data' => $user_data,
            'count' => $count,
        ];

        return $result;
    }

    /**
     * パスワードを更新する
     * @param array $data 現在のパスワードと新しいパスワードを格納した配列
     * @return array 更新後のデータを格納した配列
     */
    public static function updatePassword(array $data): array
    {
        try {
            $user = self::findByUserId($data[ConstParams::USER_ID]);

            if (!Hash::check($data['old_pwd'], $user->password)) {
                throw new Exception('現在のパスワードが正しくありません。');
            }
            if ($data['new_pwd_1'] !== $data['new_pwd_2']) {
                throw new Exception('新しいパスワードが、確認用の欄に入力したものと一致しません。');
            }

            $count = self::findByUserId($data[ConstParams::USER_ID])
                ->update(
                    [
                        ConstParams::PASSWORD => $data['new_pwd_1'],
                        ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY],
                    ]
                );
            $user->remember_token = Str::random(60);
            $user->save();
        } catch (Exception $e) {
            ExceptionThrower::genericError($e->getMessage(), 210);
        }

        try {
            $user = self::findByUserId($data[ConstParams::USER_ID]);
        } catch (Exception $e) {
            ExceptionThrower::fetchFailed(ConstParams::USER_JP, 211);
        }

        $user_data = $user->dataArray();

        $result = [
            'user_data' => $user_data,
            'count' => $count,
        ];

        return $result;
    }

    /**
     * ユーザーを削除する
     * @param int $user_id 削除対象のID
     * @return int 削除した個数（削除に成功したかどうかのチェックに使う）
     */
    public static function deletedById(int $user_id): int
    {
        try {
            return self::findByUserId($user_id)->delete();
        } catch (Exception $e) {
            ExceptionThrower::deleteFailed(ConstParams::USER_JP, 209);
        }
    }



    /** 
     * データの表示用に項目名の配列を取得する
     * @return array 項目名の配列
     *  */
    public function labels(): array
    {
        $labels = [
            ConstParams::USER_ID_JP ?? '取得失敗',
            ConstParams::KANJI_LAST_NAME_JP ?? '取得失敗',
            ConstParams::KANJI_FIRST_NAME_JP ?? '取得失敗',
            ConstParams::KANA_LAST_NAME_JP ?? '取得失敗',
            ConstParams::KANA_FIRST_NAME_JP ?? '取得失敗',
            ConstParams::EMAIL_JP ?? '取得失敗',
            ConstParams::EMAIL_VERIFIED_AT_JP ?? '取得失敗',
            ConstParams::LOGIN_ID_JP ?? '取得失敗',
            ConstParams::IS_ADMIN_JP ?? '取得失敗',
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
            $this->user_id ?? '取得失敗',
            $this->kanji_last_name ?? '取得失敗',
            $this->kanji_first_name ?? '取得失敗',
            $this->kana_last_name ?? '取得失敗',
            $this->kana_first_name ?? '取得失敗',
            $this->email ?? '取得失敗',
            $this->email_verified_at ?? '未認証',
            $this->login_id ?? '取得失敗',
            $this->is_admin ? ConstParams::ADMIN_JP : ConstParams::NOT_ADMIN_JP ?? '取得失敗',
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
            ConstParams::USER_ID => $this->user_id ?? '取得失敗',
            ConstParams::KANJI_LAST_NAME => $this->kanji_last_name ?? '取得失敗',
            ConstParams::KANJI_FIRST_NAME => $this->kanji_first_name ?? '取得失敗',
            ConstParams::KANA_LAST_NAME => $this->kana_last_name ?? '取得失敗',
            ConstParams::KANA_FIRST_NAME => $this->kana_first_name ?? '取得失敗',
            ConstParams::EMAIL => $this->email ?? '取得失敗',
            ConstParams::EMAIL_VERIFIED_AT => $this->email_verified_at,
            ConstParams::LOGIN_ID => $this->login_id ?? '取得失敗',
            ConstParams::IS_ADMIN => $this->is_admin ?? '取得失敗',
            ConstParams::CREATED_AT => $this->created_at ?? '取得失敗',
            ConstParams::UPDATED_AT => $this->updated_at ?? '取得失敗',
            ConstParams::CREATED_BY => $this->created_by ?? '取得失敗',
            ConstParams::UPDATED_BY => $this->updated_by ?? '取得失敗',
        ];

        return $data;
    }

    /**
     * このモデルと紐づくUserSalaryモデルを取得する
     * @return HasOne 紐づくUserSalaryモデル
     */
    public function salary(): HasOne
    {
        return $this->hasOne(UserSalary::class, 'user_id');
    }

    /**
     * このモデルと紐づくUserConditionモデルを取得する
     * @return HasOne 紐づくUserConditionモデル
     */
    public function condition(): HasOne
    {
        return $this->hasOne(UserCondition::class, 'user_id');
    }

    /**
     * このモデルと紐づくat_recordモデルを取得する
     * @return HasMany 紐づくat_recordモデル
     */
    public function atRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'user_id');
    }

    /**
     * 漢字のフルネームを取得する
     * @return string 漢字姓 . ' ' . 漢字名
     */
    public function getKanjiFullName(): string
    {
        return $this->kanji_last_name . ' ' . $this->kanji_first_name;
    }

    /**
     * かなのフルネームを取得する
     * @return string かな姓 . ' ' . かな名
     */
    public function getKanaFullName(): string
    {
        return $this->kana_last_name . ' ' . $this->kana_first_name;
    }
}
