<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id' ,
        'date' ,
        'clock_in' ,
        'clock_out' ,
    ];

    public function rests()
    {
        return $this/*Rest自身*/->hasmany(Rest::class); /*1つのattendance(勤怠)は、複数のrestを持つことができる*/
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
