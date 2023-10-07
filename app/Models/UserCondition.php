<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Const\ConstParams;

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
