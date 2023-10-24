<?php

namespace App\Models;

use App\Const\ConstParams;
use Exception;
use Laravel\Sanctum\HasApiTokens;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
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
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        ConstParams::PASSWORD,
        ConstParams::REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        ConstParams::EMAIL_VERIFIED_AT => 'datetime',
        ConstParams::PASSWORD => 'hashed',
    ];

    /**
     * Userの作成
     * @return User
     */
    public static function createNewUser(array $data): User
    {
        $is_admin = $data[ConstParams::IS_ADMIN] === "true" ? true : false;
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
                    ConstParams::IS_ADMIN => $is_admin,
                    ConstParams::CREATED_BY => $data[ConstParams::CREATED_BY] ?? '新規登録',
                    ConstParams::UPDATED_BY => $data[ConstParams::UPDATED_BY] ?? '新規登録',
                ]
            );

            return $user;
        } catch (Exception $e) {
            throw new Exception('User::createNewUserでエラー : ' . $e->getMessage());
        }
    }

    /**
     * Userの更新
     * @return array
     */
    public static function updateInfo(array $data): array
    {
        $count = self::where(ConstParams::USER_ID, '=', $data[ConstParams::USER_ID])
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
        $user = self::where(ConstParams::USER_ID, '=', $data[ConstParams::USER_ID])
            ->first();
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
     * Userの削除
     * @return int
     */
    public static function deletedById($user_id): int
    {
        return self::where(ConstParams::USER_ID, '=', $user_id)->delete();
    }

    /**
     * 特定のユーザーIDをもつUserオブジェクトを取得
     * @return  User|null
     */
    public static function findUserByUserId($user_id): User | null
    {
        return self::where(ConstParams::USER_ID, $user_id)->first();
    }

    /**
     * 特定のログインIDをもつUserオブジェクトを取得
     * @return  User|null
     */
    public static function findUserByLoginId(string $login_id): User | null
    {
        return self::where(ConstParams::LOGIN_ID, $login_id)->first();
    }

    /**
     * 条件を満たすUserオブジェクトの配列を取得
     * @return  LengthAwarePaginator
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

        //ユーザーIDで昇順並べ替え
        $results = $query->orderBy($column, $order)->paginate(ConstParams::USERS_PAGINATION_LIMIT);
        return $results;
    }

    /** 
     * Userデータの項目名の配列を返す
     * @return array
     *  */
    public function labels(): array
    {
        $labels = [
            ConstParams::USER_ID_JP,
            ConstParams::KANJI_LAST_NAME_JP,
            ConstParams::KANJI_FIRST_NAME_JP,
            ConstParams::KANA_LAST_NAME_JP,
            ConstParams::KANA_FIRST_NAME_JP,
            ConstParams::EMAIL_JP,
            ConstParams::EMAIL_VERIFIED_AT_JP,
            ConstParams::LOGIN_ID_JP,
            ConstParams::IS_ADMIN_JP,
            ConstParams::CREATED_AT_JP,
            ConstParams::UPDATED_AT_JP,
            ConstParams::CREATED_BY_JP,
            ConstParams::UPDATED_BY_JP,
        ];

        return $labels;
    }

    /** 
     * Userデータの配列を返す
     * @return array
     *  */
    public function data(): array
    {
        $data = [
            $this->user_id,
            $this->kanji_last_name,
            $this->kanji_first_name,
            $this->kana_last_name,
            $this->kana_first_name,
            $this->email,
            $this->email_verified_at ?? '未認証',
            $this->login_id,
            $this->is_admin ? ConstParams::ADMIN_JP : ConstParams::NOT_ADMIN_JP,
            $this->created_at,
            $this->updated_at,
            $this->created_by,
            $this->updated_by,
        ];

        return $data;
    }

    /** 
     * Userデータの表示や更新処理のために必要な文字列データをまとめた連想配列を返す
     * @return array
     *  */
    public function dataArray(): array
    {
        $data = [
            ConstParams::USER_ID => $this->user_id,
            ConstParams::KANJI_LAST_NAME => $this->kanji_last_name,
            ConstParams::KANJI_FIRST_NAME => $this->kanji_first_name,
            ConstParams::KANA_LAST_NAME => $this->kana_last_name,
            ConstParams::KANA_FIRST_NAME => $this->kana_first_name,
            ConstParams::EMAIL => $this->email,
            ConstParams::EMAIL_VERIFIED_AT => $this->email_verified_at,
            ConstParams::LOGIN_ID => $this->login_id,
            ConstParams::IS_ADMIN => $this->is_admin,
            ConstParams::CREATED_AT => $this->created_at,
            ConstParams::UPDATED_AT => $this->updated_at,
            ConstParams::CREATED_BY => $this->created_by,
            ConstParams::UPDATED_BY => $this->updated_by,
        ];

        return $data;
    }

    /**
     * このUserモデルと紐づくUserSalaryモデルを取得
     * @return HasOne
     */
    public function salary(): HasOne
    {
        return $this->hasOne(UserSalary::class, 'user_id');
    }

    /**
     * このUserモデルと紐づくUserConditionモデルを取得
     * @return HasOne
     */
    public function condition(): HasOne
    {
        return $this->hasOne(UserCondition::class, 'user_id');
    }

    /**
     * このUserモデルと紐づくat_recordsモデルを取得
     * @return HasMany
     */
    public function atRecords(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'user_id');
    }

    /**
     * 漢字のフルネームを取得
     * @return string
     */
    public function getKanjiFullName(): string
    {
        return $this->kanji_last_name . ' ' . $this->kanji_first_name;
    }

    /**
     * かなのフルネームを取得
     * @return string
     */
    public function getKanaFullName(): string
    {
        return $this->kana_last_name . ' ' . $this->kana_first_name;
    }

    public function isAdmin(): bool
    {
        return $this->is_admin;
    }
}
