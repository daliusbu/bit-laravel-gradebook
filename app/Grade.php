<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'student_id',
        'lecture_id',
        'grade',
    ];

    public function student()
    {
        return $this->belongsTo('App\Student');
    }

    public function lecture()
    {
        return $this->belongsTo('App\Lecture');
    }
}
