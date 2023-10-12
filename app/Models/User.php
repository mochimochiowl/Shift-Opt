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
                    ConstParams::CREATED_BY => '新規登録',
                    ConstParams::UPDATED_BY => '新規登録',
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
    public static function updateInfo($user_id, array $data): array
    {
        $count = self::where(ConstParams::USER_ID, '=', $user_id)->update(
            [
                ConstParams::KANJI_LAST_NAME => $data[ConstParams::KANJI_LAST_NAME],
                ConstParams::KANJI_FIRST_NAME => $data[ConstParams::KANJI_FIRST_NAME],
                ConstParams::KANA_LAST_NAME => $data[ConstParams::KANA_LAST_NAME],
                ConstParams::KANA_FIRST_NAME => $data[ConstParams::KANA_FIRST_NAME],
                ConstParams::EMAIL => $data[ConstParams::EMAIL],
                ConstParams::LOGIN_ID => $data[ConstParams::LOGIN_ID],
                ConstParams::UPDATED_BY => $data['logged_in_user_name'],
            ]
        );
        $user = self::where(ConstParams::USER_ID, '=', $user_id)->first();

        $result = [
            'count' => $count,
            'user' => $user,
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
     * @return  Collection
     */
    public static function searchByKeyword(string $field, string $keyword): Collection
    {
        if ($field === 'name') {
            return self::where(ConstParams::KANA_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere(ConstParams::KANA_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere(ConstParams::KANJI_LAST_NAME, 'LIKE', '%' . $keyword . '%')
                ->orWhere(ConstParams::KANJI_FIRST_NAME, 'LIKE', '%' . $keyword . '%')
                ->get();
        }

        if ($field === 'all') {
            return self::all();
        }

        return self::where($field, 'LIKE', '%' . $keyword . '%')->get();
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
}
