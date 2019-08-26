<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function grade()
    {
        return $this->hasMany('App\Grade');
    }

    public function hasGrade() {
        return $this->hasOne(Grade::class);
    }
}
