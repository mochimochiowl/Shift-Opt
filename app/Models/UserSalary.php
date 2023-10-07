<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Const\ConstParams;

class UserSalary extends Model
{
    use HasFactory;

    protected $primaryKey = ConstParams::USER_SALARY_ID;
    protected $fillable = [
        ConstParams::USER_ID,
        ConstParams::HOURLY_WAGE,
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
