<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Const\ConstParams;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
     * 漢字のフルネームを取得
     * @return string
     */
    public function getKanjiFullName(): string
    {
        return $this->kanji_last_name . ' ' . $this->kanji_first_name;
    }
}
