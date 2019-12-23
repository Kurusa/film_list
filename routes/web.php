<?php

Route::get('/', function () {
    return redirect()->route('film-list');
});

Route::get('/film-list', 'Film\FilmController@filmListPage')
    ->name('film-list');
Route::get('/film/{id}', 'Film\FilmController@filmPage')
    ->name('film-page')
    ->where('id', '[0-9]+');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
    Route::get('/film-list', 'Film\FilmController@adminFilmListPage')
        ->name('admin-film-list');

    Route::get('/film-delete/{id}', 'Film\FilmController@delete')
        ->name('film-delete')
        ->where('id', '[0-9]+');

    Route::get('/film-edit/{id}', 'Film\FilmController@edit')
        ->name('film-edit')
        ->where('id', '[0-9]+');

    Route::post('/film-edit/{id}', 'Film\FilmController@save')
        ->name('film-edit-save')
        ->where('id', '[0-9]+');
});

Auth::routes();
