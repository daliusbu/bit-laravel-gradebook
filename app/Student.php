<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'name',
        'surname',
        'email',
        'phone',
    ];

    public function grade()
    {
        return $this->hasMany('App\Grade');
    }
}
