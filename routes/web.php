<?php

Route::get('/', 'HomeController@index');
Route::get('/testas/{id}', 'QuestionsController@index')->name('testas');
Route::get('/showSave', 'ResultsController@showSave')->name('showSave');
Route::get('/resetTest', 'QuestionsController@resetTest')->name('resetTest');
Route::get('/selectNewTest', 'QuestionsController@selectNewTest')->name('selectNewTest');
Route::post('/testas/next', 'QuestionsController@nextQuestion')->name('next');
Route::post('/saveResult', 'ResultsController@saveResult')->name('saveResult');
