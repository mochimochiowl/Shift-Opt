<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    use HasFactory;

    protected $primaryKey = 'at_record_id';
    protected $fillable = [
        'user_id',
        'at_record_type',
        'time',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by',
    ];
}
