<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'attendance_request_id',
        'rest_id',
        'rest_start',
        'rest_end',
    ];
}
