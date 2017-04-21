<?php

// Route::get('/', 'HomeController@homepage');

Route::get('/', function () {
    return view('welcome');
});


Route::get('/unauthorized', function () {
    return view('errors.403');
});

Route::get('/onworking', function () {
    return view('errors.503');
});

Route::auth();

Route::get('/registration', 'HomeController@registrare');


Route::get('/try/password', 'HomeController@reset');
Route::post('/reset/password/email', 'HomeController@resetpassword');
Route::get('/contatti', 'HomeController@mostracontatti');
Route::get('/faq', 'HomeController@mostrafaq');
Route::get('/coordinate', 'HomeController@mostracoordinate');
Route::get('/changelog', 'HomeController@mostrachangelog');
Route::get('/valutaci', function () {
    return view('layouts.valutaci');
});
Route::post('/valutaci/store', 'HomeController@segnalazionerrore');

Route::get('/calendario', 'HomeController@mostracalendario');
Route::get('/calendario/show/day/{day}/month/{month}/year/{year}', 'HomeController@show');
Route::get('/preventivi', 'HomeController@mostrapreventivi');
Route::get('preventivi/json', 'HomeController@getpreventivijson');
Route::get('/preventivi/pdf/quote/{id}', 'HomeController@pdfpreventivo');
Route::get('/richiedimodifica/{sezione}/{id}', 'HomeController@richiedimodifica');
Route::get('/progetti', 'HomeController@mostraprogetti');
Route::get('/progetti/json', 'HomeController@getprogettijson');

Route::get('/progetti', 'ProjectController@index');
Route::get('/progetti/modify/project/{project}', 'ProjectController@modify');
Route::post('/progetti/modify/project/{project}', 'ProjectController@update');
Route::get('/progetti/files/{project}', 'ProjectController@vedifiles');

Route::get('/fatture', 'HomeController@mostrafatture');
Route::get('/fatture/json', 'HomeController@getfatturejson');
Route::get('/pagamenti/tranche/pdf/{id}', 'HomeController@generapdftranche');