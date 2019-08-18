<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::post('logout', 'Auth\LoginController@logout')->name('logout');


Route::get('/', function () {
    return view('welcome');
});

Route::get('/grade', 'GradeController@index')
    ->name('crud.grade.index');

// grade view
Route::get('/grade/{id}/view', 'GradeController@view')
    ->name('crud.grade.view')
    ->where(['id' => '[0-9]+']);

//
// CRUD Auth protected group
Route::group(['middleware' => 'auth', 'prefix' => 'crud'], function () {
    // Grade edit form
    Route::get('/grade/{id}/edit', 'GradeController@edit')
        ->name('crud.grade.edit')
        ->where(['id' => '[0-9]+']);
//        ->middleware('auth');

    // Grade add form
    Route::get('/grade/add', 'GradeController@add')
        ->name('crud.grade.add');

    // New grade save
    Route::post('/grade/save', 'GradeController@save')
        ->name('crud.grade.save');

    // Save edited grade
    Route::put('grade/{id}/save', 'GradeController@save')
        ->where(['id' => '[0-9]+'])
        ->name('crud.grade.edit.save');

    // Delete grade
    Route::delete('/grade/delete', 'GradeController@delete')
        ->name('crud.grade.delete');
//});


// ----- Student ----------

Route::get('/student', 'StudentController@index')
    ->name('crud.student.index');

Route::get('/student/{id}/view', 'StudentController@view')
    ->name('crud.student.view')
    ->where(['id' => '[0-9]+']);

Route::get('/student/{id}/edit', 'StudentController@edit')
    ->name('crud.student.edit')
    ->where(['id' => '[0-9]+']);
//        ->middleware('auth');

Route::get('/student/add', 'StudentController@add')
    ->name('crud.student.add');

Route::post('/student/save', 'StudentController@save')
    ->name('crud.student.save');

Route::put('student/{id}/save', 'StudentController@save')
    ->where(['id' => '[0-9]+'])
    ->name('crud.student.edit.save');

Route::delete('/student/delete', 'StudentController@delete')
    ->name('crud.student.delete');

});

// ----- Lecture ----------

Route::get('/lecture', 'LectureController@index')
    ->name('crud.lecture.index');

Route::get('/lecture/{id}/view', 'LectureController@view')
    ->name('crud.lecture.view')
    ->where(['id' => '[0-9]+']);

Route::get('/lecture/{id}/edit', 'LectureController@edit')
    ->name('crud.lecture.edit')
    ->where(['id' => '[0-9]+'])
        ->middleware('auth');

Route::get('/lecture/add', 'LectureController@add')
    ->name('crud.lecture.add');

Route::post('/lecture/save', 'LectureController@save')
    ->name('crud.lecture.save');

Route::put('lecture/{id}/save', 'LectureController@save')
    ->where(['id' => '[0-9]+'])
    ->name('crud.lecture.edit.save');

Route::delete('/lecture/delete', 'LectureController@delete')
    ->name('crud.lecture.delete');
