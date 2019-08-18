<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Student;
use App\Lecture;
use App\Grade;
use Faker\Generator as Faker;

$factory->define(Grade::class, function (Faker $faker) {
    return [
        'student_id' => function() {
            return factory(Student::class)->create()->id;
        },
        'lecture_id' => function() {
            return factory(Lecture::class)->create()->id;
        },
        'grade' => $faker->randomDigitNotNull(),

    ];
});
