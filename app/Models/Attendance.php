<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $primaryKey = 'attendance_id';

    protected $fillable = [
        'employee_id', // Diubah dari user_id
        'user_name',
        'type',
        'lat',
        'lng',
        'photo_url',
        'status',
    ];
}