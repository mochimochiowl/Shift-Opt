<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCondition extends Model
{
    use HasFactory;

    protected $primaryKey = 'user_condition_id';
    protected $fillable = [
        'user_id',
        'has_attended',
        'is_breaking',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
